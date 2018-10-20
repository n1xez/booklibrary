<?php

namespace App\Services;

use Monolog\Logger;
use Illuminate\Http\Request;
use Monolog\Handler\StreamHandler;
use App\Repositories\BookRepository;

/**
 * Class BookService
 * @package App\Services
 */
class BookService
{
    /**
     * @var BookRepository
     */
    private $repository;

    /**
     * @var RequestValidatorService
     */
    private $requestValidatorService;

    private $log;

    /**
     * BookService constructor.
     * @param BookRepository $bookRepository
     * @param RequestValidatorService $requestValidatorService
     * @throws \Exception
     */
    public function __construct(
        BookRepository $bookRepository,
        RequestValidatorService $requestValidatorService
    ) {
        $this->log = $this->getLogger();
        $this->repository = $bookRepository;
        $this->requestValidatorService = $requestValidatorService;
    }

    /**
     * Find book or create new book
     * @param $fields
     * @return \App\Models\Book|bool|mixed
     */
    public function updateOrCreate($fields)
    {
        $book = $this->repository->getByIsbn($fields['isbn']);
        if ($book) {
            $this->log->info('Book found and modified isbn#' . $fields['isbn']);
            return $book->update($fields);
        }
        $this->log->info('Create new book isbn#' . $fields['isbn']);

        return $this->repository->create($fields);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function validateRequest(Request $request) : bool
    {
        $rules = [
            'isbn' => 'required|numeric',
            'author_full_name' => 'required|string',
            'title' => 'required|string',
            'year' => 'required|numeric',
        ];

        return $this->requestValidatorService->validate($request, $rules);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function validateRequestByAuthor(Request $request) : bool
    {
        $rules = [
            'author_full_name' => 'required_without:date_from:date_to|string',
            'date_from' => 'required_without:author_full_name:date_to|string',
            'date_to' => 'required_without:author_full_name:date_from|string',
        ];

        return $this->requestValidatorService->validate($request, $rules);
    }

    /**
     * Return logger
     * @return Logger
     * @throws \Exception
     */
    private function getLogger()
    {
        $log = new Logger('scans log');

        return $log->pushHandler(new StreamHandler(storage_path('logs/scans.log'), Logger::INFO));
    }
}