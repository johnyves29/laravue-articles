<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get articles
        $articles = Article::paginate(15);

        // Return collection of articles as a resource
        return ArticleResource::collection($articles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $article = $request->isMethod('put') ? Article::findOrFail($request->article_id) : new Article;

        $article->id = $request->input('article_id');
        $article->title = $request->input('title');
        $article->content = $request->input('content');

        if ($article->save()) {
            return new ArticleResource($article);
        }

        return null;
    }

    /**
     * Display the specified resource.
     */
    // public function show(Article $article)
    public function show($id): ArticleResource
    {
        // Get article
        $article = Article::findOrFail($id);

        // Return single article as a resource
        return new ArticleResource($article);   
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Article $article)
    public function destroy($id)
    {
         // Get article
         $article = Article::findOrFail($id);

         if ($article->delete()) {
             return new ArticleResource($article);
         }
 
         return null;
    }
}
