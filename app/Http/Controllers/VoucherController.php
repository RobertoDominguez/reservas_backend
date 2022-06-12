<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Http\Requests\Voucher\IndexVoucherRequest;
use App\Http\Requests\Voucher\StoreVoucherRequest;
use App\Http\Requests\Voucher\UpdateVoucherRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{

    public function index(IndexVoucherRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<Voucher> enviada correctamente';
        try {
            $responseArr['data'] = Voucher::Store($request->store_id)
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


    public function store(StoreVoucherRequest $request)
    {
        $data = [
            'image'=>'',
            'accepted'=>$request->accepted,
            'rejected'=>$request->rejected,
            'message'=>$request->message,
            'total'=>$request->total,
            'store_id'=>$request->store_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Voucher> Registro exitoso';

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $data['image'] = Storage::disk('public')->put('image', $request->image);
            }

            $voucher = Voucher::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo Voucher : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $voucher;
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


    public function show(Voucher $voucher)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Voucher> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $voucher;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(Voucher $voucher)
    {
        //
    }

    public function update(UpdateVoucherRequest $request, Voucher $voucher)
    {
        $data = [
            'image'=>$voucher->image,
            'accepted'=>$request->accepted,
            'rejected'=>$request->rejected,
            'message'=>$request->message,
            'total'=>$request->total,
            'store_id'=>$request->store_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Voucher> Modificado correctamente';
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                if (!is_null($voucher->image)) {
                    Storage::disk('public')->delete($voucher->image);
                }
                $data['image'] = Storage::disk('public')->put('image', $request->image);
            }


            $before = $voucher;
            $voucher->update($data);

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
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo Voucher : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $voucher;
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

    public function destroy(Voucher $voucher)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Voucher> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$voucher->id;
            if (!is_null($voucher->image)) {
                Storage::disk('public')->delete($voucher->image);
            }

            $voucher->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó Voucher: con id:' . $id . '.'
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


    public function restore(Voucher $voucher)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<Voucher> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $voucher->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró Voucher: ' . $voucher->id 
            //@@@     . ' con id:' . $voucher->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $voucher;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}