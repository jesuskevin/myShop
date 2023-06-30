<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Str;

class BooksService
{

    protected $model;
    protected $stripeService;

    public function __construct(Book $model, StripeService $stripeService)
    {
        $this->model = $model;
        $this->stripeService = $stripeService;
    }

    public function getAllPaginated($quantity)
    {
        $userBooks = auth()->user()->books->pluck('id')->toArray();
        return $this->model::whereNotIn('id', $userBooks)->orderByDesc('created_at')->paginate($quantity);
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function findByUuid($uuid)
    {
        return $this->model::where('uuid', $uuid)->first();
    }

    public function store($data)
    {
        $product = $this->stripeService->createProduct($data);
        $data['stripe_product_id'] = $product->id;
        $data['uuid'] = Str::uuid();
        return $this->model->create($data);
    }

    public function update($data, $uuid)
    {
        $book = $this->findByUuid($uuid);
        $this->stripeService->updateProduct($data, $book);
        return $book->update($data);
    }

    public function delete($uuid)
    {
        $book = $this->findByUuid($uuid);
        $this->stripeService->disableProduct($book);
        return $book->delete();
    }
}
