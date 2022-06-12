<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Http\Requests\Store\IndexStoreRequest;
use App\Http\Requests\Store\StoreStoreRequest;
use App\Http\Requests\Store\UpdateStoreRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{

    public function index(IndexStoreRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<Store> enviada correctamente';
        try {
            $responseArr['data'] = Store::all();
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


    public function store(StoreStoreRequest $request)
    {
        $data = [
            'name'=>$request->name,
            'url_map'=>$request->url_map,
            'days'=>$request->days,
            'location'=>$request->location,
            'ico'=>'',
            'logo'=>'',
            'mision'=>$request->mision,
            'vision'=>$request->vision,
            'phone'=>$request->phone,
            'facebook'=>$request->facebook,
            'twitter'=>$request->twitter,
            'tik_tok'=>$request->tik_tok,
            'youtube'=>$request->youtube,
            'whatsapp'=>$request->whatsapp,
            'qr'=>'',
            'is_open'=>$request->is_open,
            'days_subscription'=>$request->days_subscription,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Store> Registro exitoso';

        try {
            DB::beginTransaction();

            if ($request->hasFile('ico')) {
                $data['ico'] = Storage::disk('public')->put('ico', $request->ico);
            }
            if ($request->hasFile('logo')) {
                $data['logo'] = Storage::disk('public')->put('logo', $request->logo);
            }
            if ($request->hasFile('qr')) {
                $data['qr'] = Storage::disk('public')->put('qr', $request->qr);
            }

            $store = Store::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo Store : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $store;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();

            if (!is_null($data['ico'])) {
                Storage::disk('public')->delete($data['ico']);
            }
            if (!is_null($data['logo'])) {
                Storage::disk('public')->delete($data['logo']);
            }
            if (!is_null($data['qr'])) {
                Storage::disk('public')->delete($data['qr']);
            }

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }


    public function show(Store $store)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Store> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $store;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(Store $store)
    {
        //
    }

    public function update(UpdateStoreRequest $request, Store $store)
    {
        $data = [
            'name'=>$request->name,
            'url_map'=>$request->url_map,
            'days'=>$request->days,
            'location'=>$request->location,
            'ico'=>$store->ico,
            'logo'=>$store->logo,
            'mision'=>$request->mision,
            'vision'=>$request->vision,
            'phone'=>$request->phone,
            'facebook'=>$request->facebook,
            'twitter'=>$request->twitter,
            'tik_tok'=>$request->tik_tok,
            'youtube'=>$request->youtube,
            'whatsapp'=>$request->whatsapp,
            'qr'=>$store->qr,
            'is_open'=>$request->is_open,
            'days_subscription'=>$request->days_subscription,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Store> Modificado correctamente';
        try {
            DB::beginTransaction();

            if ($request->hasFile('ico')) {
                if (!is_null($store->ico)) {
                    Storage::disk('public')->delete($store->ico);
                }
                $data['ico'] = Storage::disk('public')->put('ico', $request->ico);
            }
            if ($request->hasFile('logo')) {
                if (!is_null($store->logo)) {
                    Storage::disk('public')->delete($store->logo);
                }
                $data['logo'] = Storage::disk('public')->put('logo', $request->logo);
            }
            if ($request->hasFile('qr')) {
                if (!is_null($store->qr)) {
                    Storage::disk('public')->delete($store->qr);
                }
                $data['qr'] = Storage::disk('public')->put('qr', $request->qr);
            }


            $before = $store;
            $store->update($data);

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
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo Store : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $store;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            if (!is_null($data['ico'])) {
                Storage::disk('public')->delete($data['ico']);
            }
            if (!is_null($data['logo'])) {
                Storage::disk('public')->delete($data['logo']);
            }
            if (!is_null($data['qr'])) {
                Storage::disk('public')->delete($data['qr']);
            }

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function destroy(Store $store)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Store> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$store->id;
            if (!is_null($store->ico)) {
                Storage::disk('public')->delete($store->ico);
            }
            if (!is_null($store->logo)) {
                Storage::disk('public')->delete($store->logo);
            }
            if (!is_null($store->qr)) {
                Storage::disk('public')->delete($store->qr);
            }

            $store->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó Store: con id:' . $id . '.'
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


    public function restore(Store $store)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<Store> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $store->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró Store: ' . $store->id 
            //@@@     . ' con id:' . $store->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $store;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}