<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Http\Requests\System\IndexSystemRequest;
use App\Http\Requests\System\StoreSystemRequest;
use App\Http\Requests\System\UpdateSystemRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{

    public function index(IndexSystemRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<System> enviada correctamente';
        try {
            $responseArr['data'] = System::all();
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


    public function store(StoreSystemRequest $request)
    {
        $data = [
            'admin_version'=>$request->admin_version,
            'client_version'=>$request->client_version,
            'qr'=>'',

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<System> Registro exitoso';

        try {
            DB::beginTransaction();

            if ($request->hasFile('qr')) {
                $data['qr'] = Storage::disk('public')->put('qr', $request->qr);
            }

            $system = System::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo System : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $system;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();

            if (!is_null($data['qr'])) {
                Storage::disk('public')->delete($data['qr']);
            }

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }


    public function show(System $system)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<System> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $system;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(System $system)
    {
        //
    }

    public function update(UpdateSystemRequest $request, System $system)
    {
        $data = [
            'admin_version'=>$request->admin_version,
            'client_version'=>$request->client_version,
            'qr'=>$system->qr,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<System> Modificado correctamente';
        try {
            DB::beginTransaction();

            if ($request->hasFile('qr')) {
                if (!is_null($system->qr)) {
                    Storage::disk('public')->delete($system->qr);
                }
                $data['qr'] = Storage::disk('public')->put('qr', $request->qr);
            }


            $before = $system;
            $system->update($data);

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
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo System : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $system;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            if (!is_null($data['qr'])) {
                Storage::disk('public')->delete($data['qr']);
            }

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function destroy(System $system)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<System> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$system->id;
            if (!is_null($system->qr)) {
                Storage::disk('public')->delete($system->qr);
            }

            $system->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó System: con id:' . $id . '.'
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


    public function restore(System $system)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<System> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $system->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró System: ' . $system->id 
            //@@@     . ' con id:' . $system->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $system;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}