<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Services\BookService;
use App\Repositories\BookRepository;
use App\Http\Controllers\Controller;

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
     * @param BookService $service
     * @param BookRepository $repository
     */
    public function __construct(
        BookService $service,
        BookRepository $repository
    ) {
        $this->repository = $repository;
        $this->service = $service;

    }

    /**
     * Save scanner input
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function scan(Request $request)
    {
        if ($this->service->validateRequest($request)) {
            $this->service->updateOrCreate($request->all());

            return response('Success', 200);
        }

        return response('Not valid', 400);
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
    public function getBooks(Request $request)
    {
        if ($this->service->validateRequestByAuthor($request)) {
            $fields = $request->all(['author_full_name', 'date_from', 'date_to']);
            $books = $this->repository->getBooks($fields);

            return response()->json($books);
        }

        return response('Not valid', 400);
    }

    /**
     * Get all book
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $books = $this->repository->getAll();

        return response()->json($books);
    }
}