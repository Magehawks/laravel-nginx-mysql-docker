<!DOCTYPE html>
    <html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Artikel Auswahl</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        @include('partials.styles')
        <style>
            .selected {
                border: 2px solid #007bff;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    @if(isset($error))
                        <div class="alert alert-warning" role="alert">
                            {{ $error }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Artikel Auswahl</h5>
                            <div class="articles">
                                @foreach ($articles as $index => $article)
                                    <div class="article-tile card" id="article-{{ $index }}" onclick="selectArticle(this, '{{ $article['link'] }}')">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $article['title'] }}</h5>
                                            <p class="card-text">{{ $article['description'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Wählen Sie eine Interpretation aus:</h5>
                            <form id="summary-form" action="{{ route('summarize.article') }}" method="POST">
                                @csrf
                                <input type="hidden" name="article_link" id="article-link">
                                <div class="form-group">
                                    <label for="interpretation_style">Interpretationsstil</label>
                                    <select class="form-control" name="interpretation_style" required>
                                        <option value="Du">Du</option>
                                        <option value="Sie">Sie</option>
                                        <option value="freundlich">freundlich</option>
                                        <option value="professionell">professionell</option>
                                        <option value="überzeugend">überzeugend</option>
                                        <option value="locker">locker</option>
                                    </select>
                                </div>
                                <button type="submit" id="submit-button" class="btn btn-primary" disabled>Zusammenfassung von OpenAi erstellen lassen</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <script>
            let selectedTile = null;
    
            function selectArticle(tile, link) {
                if (selectedTile) {
                    selectedTile.classList.remove('selected');
                }
                tile.classList.add('selected');
                selectedTile = tile;
    
                document.getElementById('article-link').value = link;
                document.getElementById('submit-button').disabled = false;
            }
        </script>
    </body>
    </html>