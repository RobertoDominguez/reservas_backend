<?php

namespace App\Http\Controllers;

use App\Models\Open;
use App\Http\Requests\Open\IndexOpenRequest;
use App\Http\Requests\Open\StoreOpenRequest;
use App\Http\Requests\Open\UpdateOpenRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class OpenController extends Controller
{

    public function index(IndexOpenRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<Open> enviada correctamente';
        try {
            $responseArr['data'] = Open::Store($request->store_id)
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


    public function store(StoreOpenRequest $request)
    {
        $data = [
            'begin_time'=>$request->begin_time,
            'end_time'=>$request->end_time,
            'day'=>$request->day,
            'store_id'=>$request->store_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Open> Registro exitoso';

        try {
            DB::beginTransaction();


            $open = Open::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo Open : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $open;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();


            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }


    public function show(Open $open)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Open> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $open;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(Open $open)
    {
        //
    }

    public function update(UpdateOpenRequest $request, Open $open)
    {
        $data = [
            'begin_time'=>$request->begin_time,
            'end_time'=>$request->end_time,
            'day'=>$request->day,
            'store_id'=>$request->store_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Open> Modificado correctamente';
        try {
            DB::beginTransaction();



            $before = $open;
            $open->update($data);

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
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo Open : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $open;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function destroy(Open $open)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Open> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$open->id;

            $open->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó Open: con id:' . $id . '.'
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


    public function restore(Open $open)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<Open> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $open->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró Open: ' . $open->id 
            //@@@     . ' con id:' . $open->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $open;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}