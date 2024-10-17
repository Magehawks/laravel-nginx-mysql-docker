<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed Formular</title>
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
                @endif
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">RSS Feed Formular</h5>
                        <p>Bitte geben Sie einen RSS Feed an, um die Artikel anzuzeigen.
                            <ul>
                                <li>Beispiel: https://www.tagesschau.de/xml/rss2</li>
                                <li>Beispiel: https://www.heise.de/rss/heise-Rubrik-IT.rdf</li>
                                <li>Beispiel: https://www.spiegel.de/schlagzeilen/tops/index.rss</li>
                            </ul>
                        </p>
                        <form action="{{ route('fetch.articles') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="feed_url">RSS Feed URL</label>
                                <input type="url" class="form-control" id="feed_url" name="feed_url" placeholder="Geben Sie die Feed-URL ein" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Feed verarbeiten</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>