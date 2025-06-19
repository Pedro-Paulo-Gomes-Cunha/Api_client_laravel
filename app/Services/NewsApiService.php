<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Exception;


class NewsApiService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl =  ApiConfig::GetApiUrlBase();
        $this->apiKey =ApiConfig::GetApiKey();

        if (empty($this->baseUrl)) {
            throw new Exception('API_BASE_URL not configured');
        }

        if (empty($this->apiKey)) {
            throw new Exception('API_API_KEY not configured');
        }
    }

    /**
     * @param string $country ex. us.
     * @param string 
     * @param int $page number.
     * @param int $pageSize
     * @return array 'articles'and 'totalResults'.
     * @throws \Exception
     */
    public function getTopHeadlines(string $country = 'pt', string $category = '', int $page = 1, int $pageSize = 20): array
    {


        try {
             $response = Http::baseUrl($this->baseUrl) 
                ->get('top-headlines', [
                    'country' => $country,
                    'category' => $category,
                    'page' => $page,
                    'pageSize' => $pageSize,
                    'apiKey' => $this->apiKey, 
                ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['status']) && $data['status'] === 'ok') {
                    return [
                        'articles' => $data['articles'],
                        'totalResults' => $data['totalResults'] ?? 0,
                    ];
                }  else {
                    $message = $data['message'] ?? 'Unknown API error.';
                    $code = $data['code'] ?? 'unknown_error';
                    throw new Exception("API Error [{$code}]: {$message}");
                }
            } else {
                throw new Exception("Failed to find news: HTTP Status {$response->status()} - {$response->body()}");
            }
        } catch (\Illuminate\Http\Client\RequestException $e) {
            dd($e->getMessage());
            throw new Exception("API connection or response error: " . $e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
              dd($e);
            throw new Exception("An unexpected error has occurred: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     *
     * @param string $query word to search.
     * @return array  'articles' and'totalResults'.
     * @throws \Exception
     */
    public function searchEverything(string $query, int $page = 1, int $pageSize = 6): array
    {
        try {

            $response = Http::baseUrl($this->baseUrl)
            ->get('everything', [ 
                'q' => $query,
                'language' => 'en', 
                'page' => $page,
                'pageSize' => $pageSize,
                'apiKey' => $this->apiKey, 
            ]);
            if ($response->successful()) {
                $data = $response->json();
            
                if (isset($data['status']) && $data['status'] === 'ok') {
                    return [
                        'articles' => $data['articles'],
                        'totalResults' => $data['totalResults'] ?? 0,
                    ];
                } else {
                    $message = $data['message'] ?? 'Unknown API error.';
                    $code = $data['code'] ?? 'unknown_error';
                    throw new Exception("API Error [{$code}]: {$message}");
                }
            } else {
                throw new Exception("Failed to find news: HTTP Status {$response->status()} - {$response->body()}");
            }
        } catch (\Illuminate\Http\Client\RequestException $e) {
            throw new Exception("API connection or response error: " . $e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new Exception("An unexpected error has occurred: " . $e->getMessage(), 0, $e);
        }
    }
}

  
// Http::get($this->baseUrl.'everything?q='.$query.'&apiKey='.$this->apiKey);