<?php

namespace App\Http\Controllers\Api\V1;

use Monolog\Logger;
use Illuminate\Http\Request;
use App\Services\BookService;
use App\Repositories\BookRepository;
use App\Http\Controllers\Controller;
use Monolog\Handler\StreamHandler;

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
     * @var Logger
     */
    private $log;

    /**
     * BooksController constructor.
     * @param BookService $service
     * @param BookRepository $repository
     * @throws \Exception
     */
    public function __construct(
        BookService $service,
        BookRepository $repository
    ) {
        $this->repository = $repository;
        $this->service = $service;
        $this->log = $this->getLogger();
    }

    /**
     * Save scanner input
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function scan(Request $request)
    {
        $this->log->info('Request has come #' . print_r($request->all()));

        if ($this->service->validateRequest($request)) {
            $this->service->updateOrCreate($request->all());

            return response('Success', 200);
        }
        $this->log->error('Bad request #');

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
     * Return average books per years per per authors
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAverageByYears()
    {
        $books = $this->repository->getAverageByYears();

        return response()->json($books);
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

    /**
     * Return logger
     * @return Logger
     * @throws \Exception
     */
    private function getLogger()
    {
        $log = new Logger('name');
        return $log->pushHandler(new StreamHandler('logs/scans.log', Logger::WARNING));
    }
}