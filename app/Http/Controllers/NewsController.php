<?php

namespace App\Http\Controllers;

use App\Services\NewsApiService;
use Illuminate\Http\Request;
use Exception;

class NewsController extends Controller
{
    protected $newsApiService;

    public function __construct(NewsApiService $newsApiService)
    {
        $this->newsApiService = $newsApiService;
    }

    public function index(Request $request)
    {
        $currentPage = $request->query('page', 1);
        $pageSize = 6;

        try {
            $data = $this->newsApiService->searchEverything('apple', $currentPage, $pageSize);
            // dd($data);
            $articles = $data==[]?[]:$data['articles'];
            $totalResults = $data==[]?0:$data['totalResults'];
          
            $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                $articles,
                $totalResults,
                $pageSize,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return view('news.index', compact('paginator'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'We could not load the news: ' . $e->getMessage());
        }
    }
}