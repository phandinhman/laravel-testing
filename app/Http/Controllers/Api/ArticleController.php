<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    function index()
    {
        return ArticleResource::collection(Article::paginate(10));
    }

    function show($id)
    {
        $article =  Article::findOrFail($id);

        return new ArticleResource($article);
    }

    public function store(ArticleRequest $request)
    {
        $validated = $request->validated();
        $article = Article::create($request->all());

        return new ArticleResource($article);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->update($request->all());

        return new ArticleResource($article);
    }

    public function destroy(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return 204;
    }
}
