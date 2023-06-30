<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\BooksService;
use App\Services\StripeService;

class PaymentsService
{

    protected $booksService;
    protected $stripeService;

    public function __construct(BooksService $booksService, StripeService $stripeService)
    {
        $this->booksService = $booksService;
        $this->stripeService = $stripeService;
    }

    public function checkout($request, $id)
    {
        $book = $this->booksService->findById($id);
        $price = $this->stripeService->getProductPrice($book->stripe_product_id);
        return $request->user()->checkout($price, [
            'success_url' => route('home') . "?session_id={CHECKOUT_SESSION_ID}&book_id=$book->id",
            'cancel_url' => route('home'),
        ]);
    }
}
