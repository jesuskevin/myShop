<?php

namespace App\Http\Controllers;

use App\Models\UserBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (!empty($request->get('session_id'))) {
            $checkoutSession = $request->user()->stripe()->checkout->sessions->retrieve($request->get('session_id'));
            UserBook::create([
                'user_id' => auth()->user()->id,
                'book_id' => $request->get('book_id'),
                'checkout_session_id' => $checkoutSession->id,
                'payment_intent' => $checkoutSession->payment_intent
            ]);

            return redirect('/home')->with('success', 'Purchase completed successfully. Enjoy :)!');
        }

        $books = auth()->user()->books;
        $data = compact('books');

        return view('home', $data);
    }
}
