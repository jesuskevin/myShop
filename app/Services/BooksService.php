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
        ];
        $product = $this->stripeClient->products->create($params);

        //create the price
        $this->stripeClient->prices->create([
            "product" => $product->id,
            "currency" => "usd",
            "unit_amount" => bcmul($data["price"], "100"),
        ]);

        $data['stripe_product_id'] = $product->id;

        return $this->model->create($data);
    }

    public function update($data, $id)
    {
        $book = $this->findById($id);

        //Product params
        $params = [
            'name' => $data['name'],
            'description' => 'Author: ' . $data['author'],
        ];

        //Update the price in stripe (disable it first and then create again since stripe does not allow to edit the price amount directly)
        //if the price change disable the old ones and create news with the new values
        if ($data["price"] != $book->price) {

            //disable the old prices
            $prices = $this->stripeClient->prices->all([
                "product" => $book->stripe_product_id,
                "active" => true,
            ]);

            foreach ($prices as $price) {
                $this->stripeClient->prices->update(
                    $price->id,
                    [
                        "active" => false,
                    ]
                );
            }

            //create the price
            $this->stripeClient->prices->create([
                "product" => $book->stripe_product_id,
                "currency" => "usd",
                "unit_amount" => bcmul($data["price"], "100"),
            ]);

            //updating the product
            $this->stripeClient->products->update($book->stripe_product_id, $params);

            return $book->update($data);
        }

        //if there is not change in the price just update the product
        $this->stripeClient->products->update($book->stripe_product_id, $params);

        return $book->update($data);
    }

    public function delete($id)
    {
        $book = $this->findById($id);
        return $book->delete();
    }
}
