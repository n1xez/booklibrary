<?php

namespace App\Services;

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
     * BookService constructor.
     * @param BookRepository $bookRepository
     */
    public function __construct(BookRepository $bookRepository)
    {
        $this->repository = $bookRepository;
    }

    /**
     * @param $fields
     */
    public function updateOrCreate($fields)
    {
        $book = $this->findOrCreateBookByIsbn($fields['isbn']);
        $book->author_full_name = $fields['author_full_name'];
        $book->title = $fields['title'];
        $book->year = $fields['year'];
        $book->save();
    }

    /**
     * Find book or create new book
     * @param $isbn
     * @return mixed|null
     */
    private function findOrCreateBookByIsbn($isbn)
    {
        return $this->repository->getByIsbn($isbn)
            ?? $this->repository->create($isbn);
    }
}