<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notícias - Angola</title>
     {{-- Internal CSS forthe news page --}}
    <style>
        /* Basic body*/
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f2f5; 
            color: #333;
            line-height: 1.6;
        }

        /* Main */
        h1 {
            color: #2c3e50; 
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5em;
            font-weight: 700;
        }

        /* Error message */
        .error-message {
            background-color: #ffebee; 
            color: #c0392b; 
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #c0392b;
            text-align: center;
            font-weight: bold;
        }

        /* Articles grid*/
        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
            gap: 25px; 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 20px;
        }

        /* unique article card*/
        .article-card {
            background-color: #ffffff; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); 
            overflow: hidden; 
            transition: transform 0.3s ease, box-shadow 0.3s ease; 
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .article-card:hover {
            transform: translateY(-5px); 
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); 
        }

        /* Article image */
        .article-card img {
            width: 100%;
            height: 200px; 
            object-fit: cover; 
            border-radius: 8px; 
            margin-bottom: 15px;
            display: block; 
        }

        /* Article title*/
        .article-card h2 {
            font-size: 1.4em;
            margin-top: 0;
            margin-bottom: 10px;
            line-height: 1.3;
            flex-grow: 1; 
        }

        .article-card h2 a {
            color: #34495e;
            text-decoration: none; 
            transition: color 0.2s ease;
        }

        .article-card h2 a:hover {
            color: #3498db; 
            text-decoration: underline;
        }

      
        .article-card p {
            font-size: 0.95em;
            color: #555;
            margin-bottom: 10px;
        }

        /* Published date*/
        .article-card p small {
            color: #777;
            font-size: 0.85em;
            display: block; 
            margin-top: auto; 
        }

        /* Pagination */
        .pagination-links {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 30px;
            padding: 10px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            max-width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        /* Laravel pagination*/
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap; 
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination li a,
        .pagination li span {
            display: block;
            padding: 3px 3px;
            border-radius: 6px;
            text-decoration: none;
            color: #3498db; /* Blue for links */
            background-color: #ecf0f1; /* Light grey background */
            border: 1px solid #bdc3c7; /* Light border */
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .pagination li a:hover {
            background-color: #3498db; /* Blue on hover */
            color: #ffffff; /* White text on hover */
            border-color: #3498db;
        }

        .pagination li.active span {
            background-color: #2980b9; /* Darker blue for active page */
            color: #ffffff;
            border-color: #2980b9;
            cursor: default;
        }

        .pagination li.disabled span {
            color: #95a5a6; /* Grey for disabled links */
            background-color: #f0f2f5;
            border-color: #e0e6eb;
            cursor: not-allowed;
        }

        /* No articles found message */
        .no-articles-found {
            text-align: center;
            font-size: 1.2em;
            color: #777;
            margin-top: 50px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            h1 {
                font-size: 2em;
            }

            .articles-grid {
                grid-template-columns: 1fr; /* Single column on smaller screens */
                padding: 10px;
            }

            .article-card {
                padding: 15px;
            }

            .article-card img {
                height: 180px;
            }

            .article-card h2 {
                font-size: 1.2em;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            h1 {
                font-size: 1.8em;
                margin-bottom: 20px;
            }

            .pagination li {
                margin: 0 2px;
            }

            .pagination li a,
            .pagination li span {
                padding: 8px 12px;
                font-size: 0.9em;
            }
        }
    </style>

    </head>
<body>
    <h1>Últimas Notícias</h1>

    @if (session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    @if (count($paginator->items()) > 0)
        <div class="articles-grid">
            @foreach ($paginator->items() as $article)
                <div class="article-card">
                    <h2><a href="{{ $article['url'] }}" target="_blank">{{ $article['title'] }}</a></h2>
                    @if ($article['author'])
                        <p>Por: {{ $article['author'] }}</p>
                    @endif
                    <p>{{ $article['description'] }}</p>
                    @if ($article['urlToImage'])
                        <img src="{{ $article['urlToImage'] }}" alt="{{ $article['title'] }}" style="max-width: 100%; height: auto;">
                    @endif
                    <p><small>{{ \Carbon\Carbon::parse($article['publishedAt'])->format('d/m/Y H:i') }}</small></p>
                </div>
            @endforeach
        </div>

        {{-- Links de paginação --}}
        <div class="pagination-links" style="margin-top: 20px;">
            {{ $paginator->links() }}
        </div>
    @else
        <p>Não foram encontradas notícias para exibir.</p>
    @endif

</body>
</html>