<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiDocument extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'document_path', 'summary_text', 'language'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
