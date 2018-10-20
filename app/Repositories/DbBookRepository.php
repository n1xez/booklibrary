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
     * @return Book
     */
    public function getByIsbn(int $isbn) : ?Book
    {
        return $this->model->where('isbn', $isbn)->first();
    }

    /**
     * Return top books
     * @return Collection
     */
    public function getTopAuthors() : Collection
    {
        return $this->model
            ->groupBy('author_full_name')
            ->selectRaw('author_full_name as author, count(isbn) as quantity')
            ->orderBy('quantity', 'DESC')
            ->take(100)
            ->get();
    }

    /**
     * @inheritdoc
     */
    public function create(array $fields) : Book
    {
        return $this->model->create($fields);
    }

    /**
     * @inheritdoc
     */
    public function getBooks(array $fields): Collection
    {
        $query = $this->model->newQuery();

        if (isset($fields['author_full_name']) && $fields['author_full_name']) {
            $query->where('author_full_name', $fields['author_full_name']);
        }

        if (isset($fields['date_from']) && $fields['date_from']) {
            $query->where('year', '>', $fields['date_from']);
        }

        if (isset($fields['date_to']) && $fields['date_to']) {
            $query->where('year', '<', $fields['date_to']);
        }

        return $query->get();
    }
}