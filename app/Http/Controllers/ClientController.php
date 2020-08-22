<?php

namespace App\Http\Controllers;

use Throwable;
use App\Client;
use App\Services;
use App\Transaction;
use App\ClientDocument;
use  PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        return view('admin', ['component' => '<client-component></client-component>']);
    }

    public function getClient($id = null)
    {
        $client = Client::with(['documents', 'service', 'manager']);
        if ($id) {
            $client = $client->find($id);
        } else {
            $client = $client->get();
        }

        return response()->json(['data' => $client]);
    }

    public function addEditClient(Request $request)
    {
        if ($request->isMethod('get')) {

            return view('admin', ['component' => '<client-add-edit-component></client-add-edit-component>']);
        }

        if ($request->isMethod('post')) {

            $client = Client::findOrNew($request->id);

            $rules = [
                'id' => 'exists:clients,id',
                'type' => 'required',
                'address' => 'required|string',
                'cap' => 'required|string',
                'tax_code' => 'required|regex:/^[a-zA-Z]{6}[0-9]{2}[abcdehlmprstABCDEHLMPRST]{1}[0-9]{2}([a-zA-Z]{1}[0-9]{3})[a-zA-Z]{1}$/',
                'manager' => 'required|exists:manager_options,id',
                'service_id' => 'required|exists:services,id',
                'provincia' => 'required',
                'city' => 'required',
                'fixed_delivery' => 'required',
                'fixed_manager' => 'required',
                'mobile_delivery' => 'required',
                'alternative_mobile' => 'nullable',
                'email' => 'nullable|string|email|max:255|unique:clients,email,' . $client->id  . ',id',
            ];

            if ($request->type == 1) { //Privato
                $rules['doc1'] = 'required_without:id';
                $rules['doc2'] = 'required_without:id';
                $rules['doc3'] = 'required_without:id';
                $rules['doc4'] = 'required_without:id';
                $rules['first_name'] = 'required|string';
                $rules['last_name'] = 'required|string';
                $rules['house_number'] = 'required|string';
                $rules['birthday'] = 'required'; //|before:18 years ago

                $rules['birth_place'] = 'required|string';
                $rules['gender'] = 'required';
                $rules['birth_provincia'] = 'required|string';
            }

            if ($request->type == 2) { //Azienda
                $rules['business_name'] = 'required|string';
                $rules['vat_number'] = 'required';
                $rules['alternative_email'] =  'nullable|string|email|max:255|unique:clients,email,' . $client->id  . ',id';
            }


            $request->validate($rules);

            DB::beginTransaction();
            try {
                $data = $request->except(['id']);


                if ($request->id) {
                    $client = Client::find($request->id);
                    $client->update($data);
                } else {
                    $client =  Client::create($data);
                }

                $service = Services::find($request->service_id);

                Transaction::create([
                    'user_id' => Auth::id(),
                    'client_id' => $client->id,
                    'service_id' => $service->id,
                    'price' => $service->price,
                    'agent_percent' => $service->price * $service->agent_percent / 100,
                    'admin_percent' => $service->price * $service->admin_percent / 100,
                    'options' => 1,
                    'durata'  => $request->durata
                ]);
                for ($i = 1; $i < 7; $i++) {
                    if ($request->hasFile('doc' . $i)) {
                        $doc = $request['doc' . $i];

                        if ($doc['front']  || $doc['retro']) {

                            $files = [];
                            if ($doc['front']) {
                                $file = $doc['front'];
                                $fileName = 'attachment' . $i . '_' . time() . '_front.jpg';
                                $file->move(storage_path('app/public/clients/document'), $fileName);
                                array_push($files, $fileName);
                            }

                            if ($doc['retro']) {
                                $file = $doc['retro'];
                                $fileName = 'attachment' . $i . '_' . time() . '_retro.jpg';
                                $file->move(storage_path('app/public/clients/document'), $fileName);
                                array_push($files, $fileName);
                            }


                            $document = new ClientDocument();
                            $document->client_id = $client->id;
                            $document->document = json_encode($files);
                            $document->validaty = $doc['validaty'];
                            $document->type = $doc['type'];
                            $document->save();
                        }
                    }
                }

                DB::commit();
                return response()->json($client);
            } catch (Throwable $e) {
                DB::rollback();
                return response()->json(404);
            }
        }
    }


    public function addClient(Request $request)
    {
        $rules = [
            'service_id' => 'required|exists:services,id',
        ];


        $sevise = Services::find($request->service_id);
        $client = Client::findOrNew($request->id);
        if ($sevise->with_protocol == 1) {
            $rules = array_merge($rules, [
                'id' => 'exists:clients,id',
                'type' => 'required',
                'address' => 'required|string',
                'cap' => 'required|string',
                'tax_code' => 'required|regex:/^[a-zA-Z]{6}[0-9]{2}[abcdehlmprstABCDEHLMPRST]{1}[0-9]{2}([a-zA-Z]{1}[0-9]{3})[a-zA-Z]{1}$/',
                'manager' => 'required|exists:manager_options,id',
                'provincia' => 'required',
                'city' => 'required',
                'fixed_delivery' => 'required',
                'fixed_manager' => 'required',
                'mobile_delivery' => 'required',
                'alternative_mobile' => 'nullable',
                'email' => 'nullable|string|email|max:255|unique:clients,email,' . $client->id  . ',id',
            ]);


            if ($request->type == 1) { //Privato
                $rules['doc1'] = 'required_without:id';
                $rules['doc2'] = 'required_without:id';

                $rules['first_name'] = 'required|string';
                $rules['last_name'] = 'required|string';
                $rules['house_number'] = 'required|string';
                $rules['birthday'] = 'required'; //|before:18 years ago

                $rules['birth_place'] = 'required|string';
                $rules['gender'] = 'required';
                $rules['birth_provincia'] = 'required|string';
            }

            if ($request->type == 2) { //Azienda
                $rules['business_name'] = 'required|string';
                $rules['vat_number'] = 'required';
                $rules['alternative_email'] =  'nullable|string|email|max:255|unique:clients,email,' . $client->id  . ',id';
            }
        }




        $request->validate($rules);
        DB::beginTransaction();
        try {
            if ($sevise->with_protocol == 1) {
                $data = $request->except(['id']);
                if ($request->id) {
                    $client = Client::find($request->id);

                    $client->update($data);
                } else {
                    $client =  Client::create($data);
                }
            }
            $service = Services::find($request->service_id);

            Transaction::create([
                'user_id' => Auth::id(),
                'client_id' => $client ?  $client->id : null,
                'service_id' => $sevise->id ,
                'price' => $service->price,
                'agent_percent' => $service->price * $service->agent_percent / 100,
                'admin_percent' => $service->price * $service->admin_percent / 100,
                'options' => 1,
                'payment_status' => 0
            ]);

            for ($i = 1; $i < 7; $i++) {
                if ($request->hasFile('doc' . $i)) {
                    $doc = $request['doc' . $i];
                    if (isset($doc)) {

                        if ($doc['front']  || $doc['retro']) {

                            $files = [];
                            if ($doc['front']) {
                                $file = $doc['front'];
                                $fileName = 'attachment' . $i . '_' . time() . '_front.jpg';
                                $file->move(storage_path('app/public/clients/document'), $fileName);
                                array_push($files, $fileName);
                            }

                            if ($doc['retro']) {
                                $file = $doc['retro'];
                                $fileName = 'attachment' . $i . '_' . time() . '_retro.jpg';
                                $file->move(storage_path('app/public/clients/document'), $fileName);
                                array_push($files, $fileName);
                            }




                            $document = new ClientDocument();
                            $document->client_id = $client->id;
                            $document->document = json_encode($files);
                            $document->validaty = $doc['validaty'];
                            $document->type = $doc['type'];
                            $document->save();
                        }
                    }
                }
            }

            DB::commit();
            if(!$request->has('form')){
                    return response()->json(['message' => 'successful']);
            }
            return redirect('/agent/transaction');
        } catch (Throwable $e) {
            DB::rollback();
            return response()->json(404,404);
        }
    }

    public function taxCode(Request $request)
    {
        $request->validate([
            'tax_code' => 'required|exists:clients,tax_code'
        ]);

        $client = Client::with('manager')->where('tax_code', $request->tax_code)->first();

        return response()->json(['data' => $client, 'message' => "successful"]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:clients,id'
        ]);

        $client = Client::find($request->id);
        $transac = Transaction::where('client_id', $request->id)->first();
        if ($transac) {
            return response()->json(['message' => "Not Delete"], 404);
        }

        $client->delete();

        return response()->json(['message' => "successful"]);
    }

}
