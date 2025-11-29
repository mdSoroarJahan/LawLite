<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ArticlesController extends Controller
{
    /** @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View */
    public function index(Request $request): View|ViewFactory
    {
        $search = $request->input('search');

        $query = Article::latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        $articles = $query->limit(50)->get();
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
