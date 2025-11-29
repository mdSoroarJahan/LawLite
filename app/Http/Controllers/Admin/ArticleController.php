<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')->latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
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
            'published_at' => now(),
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'language' => 'required|in:en,bn',
        ]);

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'language' => $request->language,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }

    public function approve(Article $article)
    {
        $article->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Article published successfully.');
    }

    public function reject(Article $article)
    {
        $article->update([
            'status' => 'rejected',
        ]);
        return redirect()->back()->with('success', 'Article rejected.');
    }
}
