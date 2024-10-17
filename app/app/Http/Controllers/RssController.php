<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use OpenAI;

class RssController extends Controller
{
    public function showFeedForm()
    {
        return view('feed_form');
    }


    public function fetchArticles(Request $request)
    {
        $rssFeedUrl = $request->input('feed_url');

        $client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
            ],
        ]);

        try {
            $response = $client->get($rssFeedUrl);
            $rssContent = simplexml_load_string($response->getBody()->getContents());

            $articles = [];
            $count = 0;
            foreach ($rssContent->channel->item as $index => $item) {
                if ($count >= 10) break;
                $articles[] = [
                    'title' => (string) $item->title,
                    'link' => (string) $item->link,
                    'description' => (string) $item->description,
                    'content' => (string) $item->description 
                ];
                $count++;
            }

            return view('select_article', [
                'articles' => $articles,
                'rss_feed_url' => $rssFeedUrl
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Handle the exception
            return response()->json(['error' => 'Failed to fetch RSS feed.'], 403);
        }
    }


    private function extractArticleContent($html)
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        $articleContent = '';

        $tags = ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
        foreach ($tags as $tag) {
            $elements = $dom->getElementsByTagName($tag);
            foreach ($elements as $element) {
                $articleContent .= ' ' . trim($element->textContent);
            }
        }

        return $articleContent;
    }

    public function generateSummary(Request $request)
    {
        $articleLink = $request->input('article_link');
        $interpretationStyle = $request->input('interpretation_style');
    
        $client = new Client([]);
    
        try {
            $response = $client->get($articleLink);
            $articleHtml = $response->getBody()->getContents();
    
            $articleContent = $this->extractArticleContent($articleHtml);
            $prompt = "Interpretiere den folgenden Artikel im Stil \"$interpretationStyle\". 
                        erstelle einen Titel:
                        erstelle einen Kurztext (max. 160 Zeichen).
                        erstelle einen umfassende ausführliche zusammenfassung mit allen wichtigen Informatinen des artikels so das der user komplett informiert ist.
                        erstelle einen Meta-Title,
                        erstelle einen Meta-Description,
                        erstelle einen Meta-Keywords.
                        Artikel: $articleContent
                        Bitte das ergebniss in folgender json zurück Struktur (Titel, Kurztext, Zusammenfassung, Meta-Title, Meta-Description, Meta-Keywords)";
    
            $summary = $this->callOpenAI($prompt);
            $result = $this->parseSummary($summary);
    
            return response()
                ->view('summary', ['summary' => $result])
                ->header('Content-Type', 'text/html; charset=UTF-8');
    
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Handle the exception
            return response()->json(['error' => 'Failed to fetch article content.'], 403);
        }
    }

    private function callOpenAI($prompt)
    {
        $openaiClient = OpenAI::client(env('OPENAI_API_KEY'));
        $response = $openaiClient->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => 2048,
            'temperature' => 0.7,
        ]);
    
        \Log::info('OpenAI Response: ' . json_encode($response));
    
        return $response['choices'][0]['message']['content'];
    }

    private function parseSummary($summary)
    {
        $summary = str_replace(["```json", "```"], "", $summary);

        $summary = trim($summary);
    
        $data = json_decode($summary, true);
    
        $result = [
            'title' => '',
            'short_text' => '',
            'body_text' => '',
            'seo' => [
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
            ],
        ];
    
        if ($data) {
            $result['title'] = $data['Titel'] ?? '';
            $result['short_text'] = $data['Kurztext'] ?? '';
            $result['body_text'] = $data['Zusammenfassung'] ?? '';
            $result['seo']['meta_title'] = $data['Meta-Title'] ?? '';
            $result['seo']['meta_description'] = $data['Meta-Description'] ?? '';
            $result['seo']['meta_keywords'] = $data['Meta-Keywords'] ?? '';
        }
    
        return $result;
    }
}