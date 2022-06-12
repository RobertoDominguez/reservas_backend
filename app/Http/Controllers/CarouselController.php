<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Http\Requests\Carousel\IndexCarouselRequest;
use App\Http\Requests\Carousel\StoreCarouselRequest;
use App\Http\Requests\Carousel\UpdateCarouselRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class CarouselController extends Controller
{

    public function index(IndexCarouselRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<Carousel> enviada correctamente';
        try {
            $responseArr['data'] = Carousel::Store($request->store_id)
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


    public function store(StoreCarouselRequest $request)
    {
        $data = [
            'image'=>'',
            'store_id'=>$request->store_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Carousel> Registro exitoso';

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $data['image'] = Storage::disk('public')->put('image', $request->image);
            }

            $carousel = Carousel::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo Carousel : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $carousel;
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


    public function show(Carousel $carousel)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Carousel> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $carousel;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(Carousel $carousel)
    {
        //
    }

    public function update(UpdateCarouselRequest $request, Carousel $carousel)
    {
        $data = [
            'image'=>$carousel->image,
            'store_id'=>$request->store_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Carousel> Modificado correctamente';
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                if (!is_null($carousel->image)) {
                    Storage::disk('public')->delete($carousel->image);
                }
                $data['image'] = Storage::disk('public')->put('image', $request->image);
            }


            $before = $carousel;
            $carousel->update($data);

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
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo Carousel : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $carousel;
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

    public function destroy(Carousel $carousel)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Carousel> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$carousel->id;
            if (!is_null($carousel->image)) {
                Storage::disk('public')->delete($carousel->image);
            }

            $carousel->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó Carousel: con id:' . $id . '.'
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


    public function restore(Carousel $carousel)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<Carousel> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $carousel->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró Carousel: ' . $carousel->id 
            //@@@     . ' con id:' . $carousel->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $carousel;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}