<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel Zusammenfassung</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @include('partials.styles')
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                @if(isset($error))
                    <div class="alert alert-warning" role="alert">
                        {{ $error }}
                    </div>
                @else
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $summary['title'] }}</h5>
                            <p class="card-text">{{ $summary['short_text'] }}</p>
                            <p class="card-text">{{ $summary['body_text'] }}</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">SEO Informationen</h5>
                            <p><strong>Meta-Title:</strong> {{ $summary['seo']['meta_title'] }}</p>
                            <p><strong>Meta-Description:</strong> {{ $summary['seo']['meta_description'] }}</p>
                            <p><strong>Meta-Keywords:</strong> {{ $summary['seo']['meta_keywords'] }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>