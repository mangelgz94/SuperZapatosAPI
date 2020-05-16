<?php

namespace App\Http\Controllers;

use App\Article;

use App\Classes\Transformers\ArticleTransformer;
use App\Classes\Validators\ArticleValidator;
use App\Responses\Classes\ErrorAPIResponse;
use App\Responses\Classes\SuccessAPIResponse;
use App\Store;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Spatie\Fractalistic\ArraySerializer;

class ArticleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Responsable
     */
    public function index()
    {
        try {
            $articles = Article::with('store:id,name')->get();
            $articles = fractal()->collection($articles)
                ->transformWith(new ArticleTransformer())
                ->serializeWith(new ArraySerializer())
                ->toArray();


            return new SuccessAPIResponse('articles', $articles);
        } catch (\Exception $exception) {
            Log::error($exception);

            return new ErrorAPIResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return Responsable
     */
    public function store(Request $request)
    {

        try {
            $articleValidator  = new ArticleValidator();
            $requestParameters = $request->all();
            $articleValidator->validateCreation($requestParameters);
            $store   = Store::findOrFail($requestParameters['store_id']);
            $article = Article::create([
                'name'           => $requestParameters['name'],
                'description'    => $requestParameters['description'],
                'price'          => $requestParameters['price'],
                'total_in_shelf' => $requestParameters['total_in_shelf'],
                'total_in_vault' => $requestParameters['total_in_vault'],
                'store_id'       => $store->id,
            ]);
            $article = fractal()->item($article)
                ->transformWith(new ArticleTransformer())
                ->serializeWith(new ArraySerializer());

            return new SuccessAPIResponse('article', $article);

        } catch (ValidationException $validationException) {
            Log::error($validationException);

            return new ErrorAPIResponse(Response::HTTP_BAD_REQUEST);
        } catch (ModelNotFoundException $modelNotFoundException) {
            Log::error($modelNotFoundException);

            return new ErrorAPIResponse(Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::error($exception);

            return new ErrorAPIResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Responsable
     */
    public function show($id)
    {
        try {
            $article = Article::with('store:id,name')->where('id', $id)->firstOrFail();
            $article = fractal()->item($article)
                ->transformWith(new ArticleTransformer())
                ->serializeWith(new ArraySerializer());

            return new SuccessAPIResponse('article', $article);
        } catch (ModelNotFoundException $modelNotFoundException) {
            Log::error($modelNotFoundException);

            return new ErrorAPIResponse(Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::error($exception);

            return new ErrorAPIResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return Responsable
     */
    public function update(Request $request, $id)
    {
        try {
            $articleValidator  = new ArticleValidator();
            $requestParameters = $request->all();
            $articleValidator->validateUpdate($requestParameters);
            $article = Article::with('store:id,name')->where('id', $requestParameters['id'])->firstOrFail();
            $article->name = $requestParameters['name'];
            $article->description = $requestParameters['description'];
            $article->price = $requestParameters['price'];
            $article->total_in_shelf = $requestParameters['total_in_shelf'];
            $article->total_in_vault = $requestParameters['total_in_vault'];
            $article->save();

            $article = fractal()->item($article)
                ->transformWith(new ArticleTransformer())
                ->serializeWith(new ArraySerializer());

            return new SuccessAPIResponse('article', $article);

        } catch (ValidationException $validationException) {
            Log::error($validationException);

            return new ErrorAPIResponse(Response::HTTP_BAD_REQUEST);
        } catch (ModelNotFoundException $modelNotFoundException) {
            Log::error($modelNotFoundException);

            return new ErrorAPIResponse(Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::error($exception);

            return new ErrorAPIResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Responsable
     */
    public function destroy($id)
    {
        try{
            $article = Article::find($id);
            $article->delete();

            return new SuccessAPIResponse('article', []);
        } catch (ModelNotFoundException $modelNotFoundException) {
            Log::error($modelNotFoundException);

            return new ErrorAPIResponse(Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::error($exception);

            return new ErrorAPIResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
