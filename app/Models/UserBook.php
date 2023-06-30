<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBook extends Model
{
    use HasFactory;

    protected $table = 'users_books';

    protected $fillable = [
        'user_id',
        'book_id',
        'checkout_session_id',
        'payment_intent',
    ];
}
