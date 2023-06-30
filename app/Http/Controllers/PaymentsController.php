<?php

namespace App\Http\Controllers;

use App\Services\BooksService;
use App\Services\StripeService;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{

    protected $booksService;
    protected $stripeService;

    public function __construct(BooksService $booksService, StripeService $stripeService)
    {
        $this->booksService = $booksService;
        $this->stripeService = $stripeService;
    }

    public function checkout(Request $request, $id)
    {
        $book = $this->booksService->findById($id);
        $price = $this->stripeService->getProductPrice($book->stripe_product_id);
        return $request->user()->checkout($price, [
            'success_url' => route('home') . "?session_id={CHECKOUT_SESSION_ID}&book_id=$book->id",
            'cancel_url' => route('home'),
        ]);
    }
}
