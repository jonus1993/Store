<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Items;
use SoapBox\Formatter\Formatter;

class ArticleController extends Controller
{
    public function __construct()
    {
//        $this->middleware('api_token');
        $this->middleware(function ($request, $next) {
            $token = 'MWcFiQSFjAr1Ij98ZyT69rmS7IkjLbR4Hq7u2a3YH22dZ10ZanslKtE1Z2ob1vCy';
            if ($request->token != $token) {
                return response('Bad request.', 400);
            }

            return $next($request);
        });
    }

//    public function callAction($method, $parameters) {
//
//        $response = parent::callAction($method, $parameters);
//
//        if ($request->has('format') && $request->format == 'xml') {
//            header('Content-type: text/xml; charset=utf8');
//
//            $formatter = Formatter::make($response, Formatter::XML);
//            return $formatter->toXml();
//        }
//
//    }

    public function index(Request $request)
    {
        $articles = Items::all();

        if ($request->has('format') && $request->format == 'xml') {
            $articles = $this->asXML($articles);
            return (new Response($articles))->header('Content-Type', 'text/xml; charset=utf8');
        }

        return $articles;
    }

    public function show(Items $article, Request $request)
    {
        if ($request->has('format')) {
            if ($request->format == 'xml') {
                $article = $this->asXML($article);
                return (new Response($article))->header('Content-Type', 'text/xml; charset=utf8');
            } elseif ($request->format == 'csv') {
                $article = $this->asCSV($article);
                return $article;
            }
        }


        return response($article, 200);
    }

    protected function asXML($article)
    {
        $formatter = Formatter::make($article->toArray(), Formatter::XML);
        return $article = $formatter->toXml();
    }

    protected function asCSV($article)
    {
        $formatter = Formatter::make($article->toJson(), Formatter::CSV);
        return $article = $formatter->toCsv();
    }

    public function store(Request $request)
    {
        $article = Items::create($request->all());

        return response()->json($article, 201);
    }

    public function update(Request $request, Items $article)
    {
        $article->update($request->all());

        return response()->json($article, 200);
    }

    public function delete(Items $article)
    {
        $article->delete();

        return response()->json(null, 204);
    }
}
