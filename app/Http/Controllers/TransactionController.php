<?php

namespace App\Http\Controllers;

use App\FixedServices;
use App\NipTransaction;
use App\ServicesReloadConfirm;
use App\UllTransaction;
use PDF;
use App\User;
use Carbon\Carbon;
use App\Transaction;
use Psy\Readline\Transient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index()
    {
        return view('admin', ['component' => '<transactions-component></transactions-component>']);
    }

    public function transaction(Request $request)
    {
        $transactions = Transaction::with(['user', 'service', 'client', 'client.manager', 'client.service'])
        ->where('user_id', Auth::id())
        ->orderBy('motivazione', 'desc');

        if (!empty($request->from)){
            $transactions->whereBetween('created_at', [
                $request->from,
                $request->to ? $request->to : Carbon::now()->toDateString()]);
        }

       $data = $transactions->get();
       $this->changeTransactionDuration($data);
        if (User::is_Agent()) {
            // foreach ($transactions as $k => $transaction) {
            //     $data = [
            //         'id' => $transaction['client']['service']['id'],
            //         'title' => $transaction['client']['service']['title'],
            //         'description' => $transaction['client']['service']['description'],
            //         'price' => $transaction['client']['service']['price'],
            //         'agent_percent' => $transaction['client']['service']['agent_percent'],
            //     ];
            //     $transactions[$k]['client']['service'] = $data;
            // }
        }

        $agent_value_sum = 0;
        $agent_price_sum = 0;
        $agent_percent_sum = 0;
        $compare = 0;

        if (count($data)) {
            $agent_value_sum = array_sum(array_map(function ($item) use ($data) {
                return $item['price'];
            }, $data->toArray()));
            $agent_price_sum = array_sum(array_map(function ($item) use ($data) {
                return $item['agent_price'];
            }, $data->toArray()));
            $agent_percent_sum = array_sum(array_map(function ($item) use ($data) {
                return $item['agent_percent'];
            }, $data->toArray()));
            $compare = array_sum(array_map(function ($item) use ($data) {
                return $item['price'] - $item['agent_percent'];
            }, $data->toArray()));
        }

        return view('transaction', [
            'transactions'      => $data->toArray(),
            'agent_value_sum'   => $agent_value_sum,
            'agent_price_sum'   => $agent_price_sum,
            'agent_percent_sum' => $agent_percent_sum,
            'compare'           => $compare
        ]);
    }

    public function changeTransactionDuration($transactions)
    {
        foreach ($transactions as $transaction){
            if (isset($transaction->service->durata)){
                $createdAt = Carbon::parse($transaction->created_at);
                $diffInDays = $createdAt->diffInDays(Carbon::now()->subDays($transaction->service->durata));
                $transaction->service->durata < $diffInDays
                    ?  $transaction['days_to_maturity'] = '-'. $diffInDays
                    : $transaction['days_to_maturity'] = $diffInDays;
                $transaction['data_di_scadenza'] = $createdAt->addDays($transaction->service->durata)->toDateString();
            }
        }
    }

    public function changeStatusOptionsServices(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:transactions,id',
            'status' => 'in:0,1',
            'options' => 'in:0,1,2'
        ]);

        $transaction = Transaction::find($request->id);
        if ($request->has('status')) {
            $transaction->status = $request->status;
        }
        if ($request->has('options')) {
            $transaction->options = $request->options;
        }

        $transaction->save();

        return response()->json(['data' => $transaction, 'message' => "successful"]);
    }

    public function updateTransaction(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:transactions,id',
            'status' => 'in:0,1',
            'options' => 'in:0,1,2,3',
            'payment_status' => 'in:0,1'
        ]);

        $data = $request->except('id');
        $transaction = Transaction::find($request->id);
        $transaction->update($data);
        return response()->json(['data' => $transaction, 'message' => "successful"]);
    }

    public function getTransaction(Request $request)
    {
        $admins = [];
        $transactions = Transaction::with(['user', 'client', 'client.manager', 'client.service', 'admin']);

        $transactionsCount = Transaction::get()->count();
        $asigned = Transaction::whereNotNull('admin_id')->get()->count();

        if (User::is_Admin()) {
            $transactions = $transactions->where('admin_id', \Auth::id());
        } else {
            $admins = User::whereHas('role', function ($query){
                $query->where('role_id', 1);
            })
            ->with(['transacrtions' => function($q){
                $q->where('options', 3);
            }])
           ->get();

        }


        if($request->has('filter') && $request->filter !=''){
            if($request->filter == 'asigned'){
                $transactions = $transactions->whereNotNull('admin_id');
            }
            if($request->filter == 'notasigned'){
                $transactions = $transactions->whereNull('admin_id');
            }
        }

        if($request->has('tax_code') && $request->tax_code !=''){
            $transactions = $transactions->wherehas('client', function($q) use($request){
                $q->where('tax_code', 'like', '%'.$request->tax_code .'%');
            });
        }

        if($request->has('tax_order') && $request->tax_order !=''){
            $transactions = $transactions->join('clients', 'transactions.client_id', '=', 'clients.id')
            ->orderBy('clients.tax_code', $request->tax_order);
        }

        if($request->has('admin_id') && $request->admin_id !=''){
            $transactions = $transactions->where('admin_id', $request->admin_id);
        }
        if($request->has('pratica') && $request->pratica !=''){
            $transactions = $transactions->where('pratica', $request->pratica);
        }
        if($request->has('agent') && $request->agent !=''){
            $transactions = $transactions->with(['user'=>function($q) use($request){
                $q->where('name', 'like', '%'.$request->agent.'%')
                ->orWhere('last_name', 'like', '%'.$request->agent.'%')
                ->orWhere('username', 'like', '%'.$request->agent.'%')
                ->orWhere('email', 'like', '%'.$request->agent.'%');
            }]);
        }
        if($request->has('stato') && $request->stato !=''){
            $transactions = $transactions->whereHas('client', function($q) use($request){

                $q->where('provincia', 'like', '%'.$request->stato.'%')
                ->orWhere('birth_place', 'like', '%'.$request->stato.'%')
                ->orWhere('birth_provincia', 'like', '%'.$request->stato.'%')
                ->orWhere('city', 'like', '%'.$request->stato.'%');
            });
        }

        if($request->has('option') && $request->option !=''){
            $transactions = $transactions->where('options', $request->option);
        }



        if($request->has('expire') && $request->expire !=''){
            $d = Carbon::now()->addDays($request->expire);
            $d = date('Y-m-d', strtotime($d));

            $transactions = $transactions->whereHas('client.service', function($q) use($d){
                // $q->where('dataDiScadenza', '>=', date('Y-m-d'));
                $q-> where('dataDiScadenza', '<', $d);

            });
        }

        $transactions = $transactions->get();

        $isSuperAdmin = Auth::user()->role_id == 3;
        $this->changeTransactionDuration($transactions);
        return response()->json([
              'transactions' => $transactions,
              'admins' => $admins,
              'transactionsCount'=>$transactionsCount, 'asigned'=>$asigned,
              'isSuperAdmin' => $isSuperAdmin
          ]);
    }


    function asigntoAdmin(Request $request){
        $request->validate([
            'admin_id' => 'required|exists:users,id',
            'transaction_ids.*' => "required|string|distinct|min:1"
        ]);

          $transaction_ids = json_decode($request->transaction_ids);
          if(count($transaction_ids)){
            $transaction =  Transaction::whereIn('id',$transaction_ids )->update(['admin_id'=>$request->admin_id]);
            return response()->json(['message' => "successful"]);
          }else{
            return response()->json(['error' => "Please select transactions"]);
          }


    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:transactions,id'
        ]);
        $transactions = Transaction::find($request->id);
        $transactions->delete();
        return response()->json(['message' => "successful"]);
    }


    public function downloadPDF($id)
    {
        $transaction = Transaction::with(['user', 'service', 'client.manager', 'client.service'])->orderBy('motivazione', 'desc')->find($id)->toArray();


        // if (is_array($transaction['client'])) {

        //     $data = [
        //         'id' => $transaction['client']['service']['id'],
        //         'title' => $transaction['client']['service']['title'],
        //         'description' => $transaction['client']['service']['description'],
        //         'price' => $transaction['client']['service']['price'],
        //         'agent_percent' => $transaction['client']['service']['agent_percent'],
        //     ];
        //     $transaction['client']['service'] = $data;
        // }

        // echo "<pre>";
        // print_r($transaction);
        // die;
        // return view('client-pdf',  compact('transaction'));

        $pdf = PDF::loadView('client-pdf', compact('transaction'));
        $filname = time() . '.' . 'pdf';
        $path = 'public/csv/transaction/' . $filname;
        $content = $pdf->download()->getOriginalContent();
        Storage::put($path, $content);
        return $pdf->download($filname);
    }

    public function setAdminToTransaction(Request $request)
    {

        $data = $request->all();
        $transaction = Transaction::find($data['id']);
        $transaction->admin_id = $data['admin_id'];
        $transaction->save();
        return response()->json(['data' => $transaction,'message' => "successful"]);

    }
}
