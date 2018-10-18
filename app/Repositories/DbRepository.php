<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class DbRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * DbRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get model from DB by id
     * @param $id
     * @return Model
     */
    public function getById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Get all models from DB
     * @return Collection
     */
    public function getAll()
    {
        return $this->model->all();
    }
}