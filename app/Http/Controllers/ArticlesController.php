<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticlesController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->limit(20)->get();
        return view('articles.index', compact('articles'));
    }

    public function show($id)
    {
        $article = Article::find($id);
        if (!$article) abort(404);
        return view('articles.show', compact('article'));
    }
}
