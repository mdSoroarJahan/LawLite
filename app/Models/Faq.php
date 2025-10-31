<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @phpstan-use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\FaqFactory>
 */
class Faq extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'answer', 'language'];
}
