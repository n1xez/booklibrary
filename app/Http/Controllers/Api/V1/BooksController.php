<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\BookService;
use App\Repositories\BookRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookScannerRequest;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * @var BookRepository
     */
    private $repository;
    /**
     * @var BookService
     */
    private $service;

    /**
     * BooksController constructor.
     * @param BookRepository $repository
     * @param BookService $service
     */
    public function __construct(
        BookRepository $repository,
        BookService $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Save scanner input
     * @param BookScannerRequest $request
     */
    public function scan(BookScannerRequest $request)
    {
        $this->service->updateOrCreate($request->all());
    }

    /**
     * Get authors top 100
     */
    public function topAuthors()
    {
        $books = $this->repository->getTopAuthors();

        return response()->json($books);
    }

    /**
     * Get books by author
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByAuthor(Request $request)
    {
        $books = $this->repository->getByAuthor($request->get('authorName'));

        return response()->json($books);
    }

    public function test()
    {
        return 'ura';
    }
}