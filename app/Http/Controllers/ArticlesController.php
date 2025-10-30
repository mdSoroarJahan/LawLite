<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ArticlesController extends Controller
{
    /** @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View */
    public function index(): View|ViewFactory
    {
        $articles = Article::latest()->limit(20)->get();
        return view('articles.index', compact('articles'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(int $id): View|ViewFactory
    {
        $article = Article::findOrFail($id);
        return view('articles.show', compact('article'));
    }
}
