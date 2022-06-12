<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Http\Requests\Account\IndexAccountRequest;
use App\Http\Requests\Account\StoreAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{

    public function index(IndexAccountRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<Account> enviada correctamente';
        try {
            $responseArr['data'] = Account::clientUser($request->client_user_id)
                                   ->Store($request->store_id)
                                   ->administratorUser($request->administrator_user_id)
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


    public function store(StoreAccountRequest $request)
    {
        $data = [
            'is_entry'=>$request->is_entry,
            'detail'=>$request->detail,
            'ammount'=>$request->ammount,
            'client_user_id'=>$request->client_user_id,
            'store_id'=>$request->store_id,
            'administrator_user_id'=>$request->administrator_user_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Account> Registro exitoso';

        try {
            DB::beginTransaction();


            $account = Account::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo Account : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $account;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();


            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }


    public function show(Account $account)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Account> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $account;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(Account $account)
    {
        //
    }

    public function update(UpdateAccountRequest $request, Account $account)
    {
        $data = [
            'is_entry'=>$request->is_entry,
            'detail'=>$request->detail,
            'ammount'=>$request->ammount,
            'client_user_id'=>$request->client_user_id,
            'store_id'=>$request->store_id,
            'administrator_user_id'=>$request->administrator_user_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Account> Modificado correctamente';
        try {
            DB::beginTransaction();



            $before = $account;
            $account->update($data);

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
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo Account : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $account;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function destroy(Account $account)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Account> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$account->id;

            $account->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó Account: con id:' . $id . '.'
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


    public function restore(Account $account)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<Account> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $account->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró Account: ' . $account->id 
            //@@@     . ' con id:' . $account->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $account;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}