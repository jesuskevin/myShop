<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Book;
use Stripe\StripeClient;

class BooksService
{

    protected $model;
    protected $stripeClient;

    public function __construct(Book $model)
    {
        $this->model = $model;
        $this->stripeClient = new StripeClient(config('services.stripe.STRIPE_SECRET'));
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

        //Create the product in stripe
        $params = [
            'name' => $data['name'],
            'description' => 'Author: ' . $data['author'],
            'default_price_data' => [
                'currency' => 'USD',
                'unit_amount' => bcmul($data['price'], '100')
            ]
        ];
        $product = $this->stripeClient->products->create($params);
        $data['stripe_product_id'] = $product->id;

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
