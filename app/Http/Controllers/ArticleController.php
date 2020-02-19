<?php

namespace App\Http\Controllers;

use App\Articles;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function index()
    {
        $articles = Articles::orderBy('created_at','desc')->paginate(5);
        return ArticleResource::collection($articles);
    }

    public function create()
    {
        // 
        
    }

    public function store(Request $request)
    {
        $article = $request->isMethod('put') ? Articles::findOrFail($request->id) : new Articles ;
        if($request->isMethod('put')){

            $article->id = $request->input('id');
        }
        $article->title = $request->input('title');
        $article->body = $request->input('body');

        if($article->save()){
            return new ArticleResource($article);
        }
    }


    public function show($id)
    {
        return new ArticleResource(Articles::findOrFail($id));
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $article =  Articles::findOrFail($id);
        if($article->delete()){
            return new ArticleResource($article);
        }
    }
}
