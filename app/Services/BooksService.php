<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Book;
use Stripe\StripeClient;

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
        return $this->model->orderByDesc('created_at')->paginate($quantity);
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function store($data)
    {
        $product = $this->stripeService->createProduct($data);
        $data['stripe_product_id'] = $product->id;
        return $this->model->create($data);
    }

    public function update($data, $id)
    {
        $book = $this->findById($id);
        $this->stripeService->updateProduct($data, $book);
        return $book->update($data);
    }

    public function delete($id)
    {
        $book = $this->findById($id);
        return $book->delete();
    }
}
