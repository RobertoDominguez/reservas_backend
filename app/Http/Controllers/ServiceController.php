<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Requests\Service\IndexServiceRequest;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{

    public function index(IndexServiceRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<Service> enviada correctamente';
        try {
            $responseArr['data'] = Service::Store($request->store_id)
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


    public function store(StoreServiceRequest $request)
    {
        $data = [
            'name'=>$request->name,
            'description'=>$request->description,
            'duration'=>$request->duration,
            'price'=>$request->price,
            'image'=>'',
            'store_id'=>$request->store_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Service> Registro exitoso';

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $data['image'] = Storage::disk('public')->put('image', $request->image);
            }

            $service = Service::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo Service : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $service;
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


    public function show(Service $service)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Service> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $service;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(Service $service)
    {
        //
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $data = [
            'name'=>$request->name,
            'description'=>$request->description,
            'duration'=>$request->duration,
            'price'=>$request->price,
            'image'=>$service->image,
            'store_id'=>$request->store_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Service> Modificado correctamente';
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                if (!is_null($service->image)) {
                    Storage::disk('public')->delete($service->image);
                }
                $data['image'] = Storage::disk('public')->put('image', $request->image);
            }


            $before = $service;
            $service->update($data);

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
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo Service : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $service;
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

    public function destroy(Service $service)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Service> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$service->id;
            if (!is_null($service->image)) {
                Storage::disk('public')->delete($service->image);
            }

            $service->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó Service: con id:' . $id . '.'
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


    public function restore(Service $service)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<Service> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $service->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró Service: ' . $service->id 
            //@@@     . ' con id:' . $service->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $service;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}