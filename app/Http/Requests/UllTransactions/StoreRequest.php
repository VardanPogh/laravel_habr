<?php

namespace App\Http\Requests\UllTransactions;

use App\Client;
use App\Services;
use App\Transaction;
use App\UllTransaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    public $ullService;
    public $client;
    public $documentRetro;
    public $documentFront;

    public function rules(): array
    {
        return [
            'first_name'                    => 'required|string',
            'last_name'                     => 'required|string',
            'tax_code'                      => 'required|string',
            'birthday'                      => 'required|string',
            'mobile'                        => 'required|string',
            'birth_place'                   => 'required|string',
            'provincia'                     => 'required|string',
            'gender'                        => 'required|string',
            'email'                         => 'required|string',
            'document_date'                 => 'required|date',
            'type_of_document'              => 'required|string',
            'document_number'               => 'required|alpha_num',
            'issue_date'                    => 'required|date',
            'expiry_date'                   => 'required|date',
            'place_of_issue'                => 'required|string',
            'issuing_body'                  => 'required|string',
            'emission_province'             => 'required|string',
            'document_front'                => 'required|file',
            'document_retro'                => 'required|file',
            'plant_location_address'        => 'required|string',
            'alternative_telephone_number'  => 'required|string',
            'current_manager'               => 'required|string',
            'migration_code'                => 'required|alpha_num',
            'current_landline_number'       => 'required|string',
            'service_id'                    => 'required|int|exists:services,id'
        ];
    }

    public function persist(): self
    {
        $this->manageRelations();

        $this->ullService = UllTransaction::create(array_merge($this->request->all(), $this->getMergingData()));

        return $this;
    }

    public function manageRelations()
    {
        $this->client = $this->createEditClient();
        $this->createFile();
        $this->createTransaction();
    }

    public function getMergingData(): array
    {
        return [
            'document_front' => $this->documentFront,
            'document_retro' => $this->documentRetro,
            'user_id'        => Auth::id(),
            'client_id'      => $this->client->id,
        ];
    }

    public function createTransaction(): Transaction
    {
        $service = Services::find($this->service_id);
       return Transaction::create([
            'user_id' => Auth::id(),
            'client_id' => $this->client_id,
            'service_id' => $service->id ,
            'price' => $service->price,
            'agent_percent' => $service->price * $service->agent_percent / 100,
            'admin_percent' => $service->price * $service->admin_percent / 100,
            'options' => 1,
            'payment_status' => 0
        ]);
    }

    public function createEditClient(): Client
    {
        if ($this->client_id){
            $client = Client::find($this->client_id);
            $client->update([
                'first_name'                    => $this->first_name,
                'last_name'                     => $this->last_name,
                'birthday'                      => $this->birthday,
                'birth_place'                   => $this->birth_place,
                'provincia'                     => $this->provincia,
                'gender'                        => $this->gender,
                'email'                         => $this->email,
                'mobile'                        => $this->mobile,
                'service_id'                    => $this->service_id,
            ]);
            return $client;
        }
        return  Client::create([
            'first_name'                    => $this->first_name,
            'last_name'                     => $this->last_name,
            'tax_code'                      => $this->tax_code,
            'birthday'                      => $this->birthday,
            'birth_place'                   => $this->birth_place,
            'provincia'                     => $this->provincia,
            'gender'                        => $this->gender,
            'email'                         => $this->email,
            'mobile'                        => $this->mobile,
            'service_id'                    => $this->service_id,
        ]);
    }

    public function createFile()
    {
        if ($this->hasFile('document_retro')) {
            $file = $this->file('document_retro');
            $nameOri = join('_', explode(' ', $file->getClientOriginalName()));
            $fileName = time().'_ull_transaction_document_retro_'.$nameOri;
            $file->move(public_path('Attachments/UllTransactionAttachments'), $fileName);
            $this->documentRetro= $fileName;
        }

        if ($this->hasFile('document_front')) {
            $file = $this->file('document_front');
            $nameOri = join('_', explode(' ', $file->getClientOriginalName()));
            $fileName = time().'_ull_transaction_document_front_'.$nameOri;
            $file->move(public_path('Attachments/UllTransactionAttachments'), $fileName);
            $this->documentFront = $fileName;
        }
    }

    public function getUllService(): UllTransaction
    {
        return $this->ullService;
    }
}
