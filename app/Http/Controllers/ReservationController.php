<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Requests\Reservation\IndexReservationRequest;
use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{

    public function index(IndexReservationRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<Reservation> enviada correctamente';
        try {
            $responseArr['data'] = Reservation::Store($request->store_id)
                                   ->Service($request->service_id)
                                   ->clientUser($request->client_user_id)
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


    public function store(StoreReservationRequest $request)
    {
        $data = [
            'user_name'=>$request->user_name,
            'date'=>$request->date,
            'time'=>$request->time,
            'accepted'=>$request->accepted,
            'rejected'=>$request->rejected,
            'message'=>$request->message,
            'image'=>'',
            'store_id'=>$request->store_id,
            'service_id'=>$request->service_id,
            'client_user_id'=>$request->client_user_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Reservation> Registro exitoso';

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $data['image'] = Storage::disk('public')->put('image', $request->image);
            }

            $reservation = Reservation::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo Reservation : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $reservation;
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


    public function show(Reservation $reservation)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Reservation> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $reservation;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(Reservation $reservation)
    {
        //
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $data = [
            'user_name'=>$request->user_name,
            'date'=>$request->date,
            'time'=>$request->time,
            'accepted'=>$request->accepted,
            'rejected'=>$request->rejected,
            'message'=>$request->message,
            'image'=>$reservation->image,
            'store_id'=>$request->store_id,
            'service_id'=>$request->service_id,
            'client_user_id'=>$request->client_user_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Reservation> Modificado correctamente';
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                if (!is_null($reservation->image)) {
                    Storage::disk('public')->delete($reservation->image);
                }
                $data['image'] = Storage::disk('public')->put('image', $request->image);
            }


            $before = $reservation;
            $reservation->update($data);

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
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo Reservation : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $reservation;
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

    public function destroy(Reservation $reservation)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Reservation> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$reservation->id;
            if (!is_null($reservation->image)) {
                Storage::disk('public')->delete($reservation->image);
            }

            $reservation->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó Reservation: con id:' . $id . '.'
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


    public function restore(Reservation $reservation)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<Reservation> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $reservation->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró Reservation: ' . $reservation->id 
            //@@@     . ' con id:' . $reservation->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $reservation;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}