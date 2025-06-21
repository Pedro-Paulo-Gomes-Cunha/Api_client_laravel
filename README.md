
# Laravel NewsAPI Consumer Project
  This Laravel project was developed to consume the NewsAPI.org, allowing the display of news with pagination in an organized manner, following clean code and best practices.

# Setup
  To get this project up and running on your machine, follow the steps below:

# 1. Requirements
  PHP >= 8.1
  Composer
  Laravel ^10.x
  A valid API Key from NewsAPI.org
  2. Installation
  Clone the repository and install the dependencies:
  git clone https://github.com/Pedro-Paulo-Gomes-Cunha/Api_client_laravel.git
  cd Api_client_laravel
  composer install
# 3. API Key Configuration
  To consume the NewsAPI.org, you need to configure your API key.

# Duplicate the environment file:
  cp .env.example .env
  Edit the .env file:
  Open the .env file and add the following lines with your API key and the base URL for NewsAPI.org:

# Fragmento do código

# NewsAPI Configurations
  NEWSAPI_BASE_URL=https://newsapi.org/v2/
  NEWSAPI_API_KEY=YOUR_API_KEY_HERE
  Remember to replace YOUR_API_KEY_HERE with your actual NewsAPI.org key.

# Generate application key:
  php artisan key:generate
  Clear configuration cache (important after changing .env):
  php artisan config:clear
  Application Endpoint
  Your application exposes a single web endpoint to display the news:
  
  URL: / (the application's root route)
  Method: GET
  Query Parameters (Optional):
  page: The page number to display (e.g., ?page=2). Default: 1.
  This endpoint is controlled by App\Http\Controllers\NewsController@index, which uses App\Services\NewsApiService to interact with NewsAPI.org.
  
  Example Expected Response (from NewsAPI.org)
  NewsAPI.org returns a JSON structure for news articles. Although your application processes and displays this data on an HTML page, the underlying API response (which the NewsApiService consumes) has this format:
  
  JSON
  {
    "status": "ok",
    "totalResults": 38,
    "articles": [
      {
        "source": {
          "id": "google-news",
          "name": "Google News"
        },
        "author": "Author Name",
        "title": "Example News Title",
        "description": "A brief description of the news, summarizing the article content.",
        "url": "https://example.com/link-to-news",
        "urlToImage": "https://example.com/news-image.jpg",
        "publishedAt": "2025-06-19T22:00:00Z",
        "content": "Full or partial content of the news. [...]"
      },
      // ... other article objects
    ]
  }
  Your frontend (news/index.blade.php) will iterate over the articles array to display each news item individually.

# Running the Application
  After setting everything up, you can serve the Laravel application:
  php artisan serve
  Access the application in your browser, usually at http://127.0.0.1:8000 or http://localhost:8000.
  ![image](https://github.com/user-attachments/assets/6024bd16-7823-49ec-974d-2ac7835aaeaa)

