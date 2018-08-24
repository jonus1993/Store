<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Items;
use SoapBox\Formatter\Formatter;

class ArticleController extends Controller {

    public function index(Request $request) {

        $articles = Items::all()->toArray();
        if ($request->has('format') && $request->format == 'xml') {
            $formatter = Formatter::make($articles, Formatter::XML);
            $articles = $formatter->toXml();
        } else
            $articles = json_encode($articles);
        return $articles;
    }

    public function show(Items $article, Request $request) {

        if ($request->has('format') && $request->format == 'xml') {
            $formatter = Formatter::make($article, Formatter::XML);
            $article = $formatter->toXml();
        } else
            $article = json_encode($article);
        return $article;
    }

    public function store(Request $request) {
        
        $article = Items::create($request->all());

        return response()->json($article, 201);
    }

    public function update(Request $request, Items $article) {
        
        $article->update($request->all());

        return response()->json($article, 200);
    }

    public function delete(Items $article) {
        
        $article->delete();

        return response()->json(null, 204);
    }

}
