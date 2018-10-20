<?php

namespace App\Services;

use Illuminate\Http\Request;
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

    /**
     * BookService constructor.
     * @param BookRepository $bookRepository
     * @param RequestValidatorService $requestValidatorService
     */
    public function __construct(
        BookRepository $bookRepository,
        RequestValidatorService $requestValidatorService
    ) {
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
            return $book->update($fields);
        }

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

    public function validateRequestByAuthor(Request $request) : bool
    {
        $rules = [
            'author_full_name' => 'required_without:dateFrom:dateTo|string',
            'dateFrom' => 'required_without:author_full_name|string',
            'dateTo' => 'required_without:author_full_name|string',
        ];

        return $this->requestValidatorService->validate($request, $rules);
    }
}