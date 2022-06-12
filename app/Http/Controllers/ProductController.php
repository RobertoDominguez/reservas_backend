<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\Product\IndexProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function index(IndexProductRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<Product> enviada correctamente';
        try {
            $responseArr['data'] = Product::Store($request->store_id)
                                   ->get();
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function create()
    {
        //
    }


    public function store(StoreProductRequest $request)
    {
        $data = [
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description,
            'image'=>'',
            'store_id'=>$request->store_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Product> Registro exitoso';

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $data['image'] = Storage::disk('public')->put('image', $request->image);
            }

            $product = Product::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo Product : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $product;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();

            if (!is_null($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }


    public function show(Product $product)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Product> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $product;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = [
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description,
            'image'=>$product->image,
            'store_id'=>$request->store_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Product> Modificado correctamente';
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                if (!is_null($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                $data['image'] = Storage::disk('public')->put('image', $request->image);
            }


            $before = $product;
            $product->update($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ $description_before = '';
            //@@@ foreach ($before as $b) {
            //@@@     $index = array_search($b, $before);
            //@@@     $description_before = $description_before .   $index . " : " . $b . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo Product : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $product;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            if (!is_null($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function destroy(Product $product)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Product> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$product->id;
            if (!is_null($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó Product: con id:' . $id . '.'
            //@@@ ]);

            DB::commit();
            
            $responseArr['data'] = [];
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }


    public function restore(Product $product)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<Product> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $product->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró Product: ' . $product->id 
            //@@@     . ' con id:' . $product->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $product;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}