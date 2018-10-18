<?php

namespace App\Repositories;

interface BookRepository
{
    /**
     * Return book by ISBN
     * @param $isbn
     * @return mixed
     */
    public function getByIsbn($isbn);

    public function getTopAuthors();

    public function getByAuthor($authorName);
}