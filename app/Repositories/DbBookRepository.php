<?php

namespace App\Repositories;

use App\Models\Book;
use Illuminate\Support\Collection;

class DbBookRepository extends DbRepository implements BookRepository
{

    /**
     * DbBookRepository constructor.
     * @param Book $model
     */
    public function __construct(Book $model)
    {
        parent::__construct($model);
    }

    /**
     * Return book by ISBN
     * @param $isbn
     * @return mixed
     */
    public function getByIsbn($isbn)
    {
        return $this->model->where('isbn', $isbn)->first();
    }

    /**
     * Return book by ISBN
     * @return Collection
     */
    public function getTopAuthors()
    {
        return $this->model
            ->groupBy('author_full_name')
            ->selectRaw('books.author_full_name, books.count(isbn)')
            ->take(100)
            ->get();
    }

    public function getByAuthor($authorName)
    {
        // TODO: Implement getByAuthor() method.
    }
}