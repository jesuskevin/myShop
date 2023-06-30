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

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function update($data, $id)
    {
        $book = $this->findById($id);
        return $book->update($data);
    }

    public function delete($id)
    {
        $book = $this->findById($id);
        return $book->delete();
    }
}
