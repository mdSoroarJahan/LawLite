<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('author_id', Auth::id())->latest()->paginate(10);
        return view('lawyer.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('lawyer.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'language' => 'required|in:en,bn',
        ]);

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'language' => $request->language,
            'author_id' => Auth::id(),
            'status' => 'pending', // Default status for lawyer created articles
        ]);

        return redirect()->route('lawyer.articles.index')->with('success', 'Article submitted for approval.');
    }

    public function edit(Article $article)
    {
        if ($article->author_id !== Auth::id()) {
            abort(403);
        }
        return view('lawyer.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        if ($article->author_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'language' => 'required|in:en,bn',
        ]);

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'language' => $request->language,
            'status' => 'pending', // Reset to pending on update if it was rejected or draft
        ]);

        return redirect()->route('lawyer.articles.index')->with('success', 'Article updated and submitted for approval.');
    }

    public function destroy(Article $article)
    {
        if ($article->author_id !== Auth::id()) {
            abort(403);
        }
        $article->delete();
        return redirect()->route('lawyer.articles.index')->with('success', 'Article deleted successfully.');
    }
}
