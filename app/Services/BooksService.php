<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Book;

class BooksService
{

    protected $model;

    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    public function getAllPaginated($quantity)
    {
        return $this->model->orderByDesc('created_at')->paginate($quantity);
    }

    public function store($data)
    {
        return $this->model->create($data);
    }
}
