<?php

namespace App\Repositories;

use App\Models\Book;
use Illuminate\Support\Collection;

interface BookRepository
{
    /**
     * Return book by ISBN
     * @param $isbn
     * @return mixed
     */
    public function getByIsbn(int $isbn) : ?Book;

    /**
     * Return top books group by authors
     * @return mixed
     */
    public function getTopAuthors() : Collection;

    /**
     * Return books by params
     * @param array $fields
     * @return mixed
     */
    public function getBooks(array $fields) : Collection;

    /**
     * Get all models from DB
     * @return Collection
     */
    public function getAll() : Collection;

    /**
     * Create new book by isbn
     * @param array $fields
     * @return mixed
     */
    public function create(array $fields) : Book;
}