<?php

namespace App\Http\Controllers;

use App\Classes\Transformers\StoreTransformer;
use App\Classes\Validators\StoreValidator;
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

class StoreController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Responsable
     */
    public function index()
    {
        try {
            $stores = Store::all();
            $stores = fractal()->collection($stores)
                ->transformWith(new StoreTransformer())
                ->serializeWith(new ArraySerializer())
                ->toArray();


            return new SuccessAPIResponse('stores', $stores);
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
            $storeValidator    = new StoreValidator();
            $requestParameters = $request->all();
            $storeValidator->validateCreation($requestParameters);
            $store = Store::create([
                'name'    => $requestParameters['name'],
                'address' => $requestParameters['address']
            ]);
            $store = fractal()->item($store)
                ->transformWith(new StoreTransformer())
                ->serializeWith(new ArraySerializer());

            return new SuccessAPIResponse('store', $store);

        } catch (ValidationException $validationException) {
            Log::error($validationException);

            return new ErrorAPIResponse(Response::HTTP_BAD_REQUEST);
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
            $store = Store::findOrFail($id);
            $store = fractal()->item($store)
                ->transformWith(new StoreTransformer())
                ->serializeWith(new ArraySerializer());

            return new SuccessAPIResponse('store', $store);
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
            $storeValidator  = new StoreValidator();
            $requestParameters = $request->all();
            $storeValidator->validateUpdate($requestParameters);
            $store = Store::findOrFail($requestParameters['id']);
            $store->name = $requestParameters['name'];
            $store->address = $requestParameters['address'];
            $store->save();

            $store = fractal()->item($store)
                ->transformWith(new StoreTransformer())
                ->serializeWith(new ArraySerializer());

            return new SuccessAPIResponse('store', $store);

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
            $store = Store::findOrFail($id);
            $store->articles()->delete();
            $store->delete();

            return new SuccessAPIResponse('store', []);
        } catch (ModelNotFoundException $modelNotFoundException) {
            Log::error($modelNotFoundException);

            return new ErrorAPIResponse(Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            Log::error($exception);

            return new ErrorAPIResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
