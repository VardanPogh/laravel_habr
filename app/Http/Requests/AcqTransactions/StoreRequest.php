<?php

namespace App\Http\Requests\AcqTransactions;

use App\AcqTransaction;
use App\Client;
use App\Services;
use App\Transaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

/**
 * @property string first_name
 * @property string last_name
 * @property string tax_code
 * @property date birthday
 * @property string birth_place
 * @property string provincia
 * @property string gender
 * @property string email
 * @property integer mobile
 * @property int fixed_service_id
 */
class StoreRequest extends FormRequest
{
    public $acqTransaction;
    public $client;
    public $documentRetro;
    public $documentFront;

    public function rules(): array
    {
        return [
            'first_name'                    => 'required|string',
            'last_name'                     => 'required|string',
            'tax_code'                      => 'required|string',
            'birthday'                      => 'required|date',
            'mobile'                        => 'required|string',
            'birth_place'                   => 'required|string',
            'provincia'                     => 'required|string',
            'gender'                        => 'required|string',
            'email'                         => 'required|string',
            'document_date'                 => 'required|string',
            'type_of_document'              => 'required|string',
            'document_number'               => 'required|alpha_num',
            'issue_date'                    => 'required|date',
            'expiry_date'                   => 'required|date',
            'place_of_issue'                => 'required|string',
            'issuing_body'                  => 'required|string',
            'emission_province'             => 'required|string',
            'document_front'                => 'required|file',
            'document_retro'                => 'required|file',
            'new_sim_number'                => 'required|string',
            'iccid_serial_sim'              => 'required|string',
            'iccid_serial_sim_2'            => 'required|string',
            'service_id'                    => 'required|int|exists:services,id'
        ];
    }

    public function persist(): self
    {
        $this->manageRelations();

        $this->acqTransaction = AcqTransaction::create(array_merge($this->request->all(), $this->getMergingData()));

        return $this;
    }

    public function manageRelations()
    {
        $this->client = $this->createEditClient();
        $this->createTransaction();
        $this->createFile();
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
            $fileName = time().'_asc_transaction_document_retro_'.$nameOri;
            $file->move(public_path('Attachments/AscTransactionAttachments'), $fileName);
            $this->documentRetro= $fileName;
        }

        if ($this->hasFile('document_front')) {
            $file = $this->file('document_front');
            $nameOri = join('_', explode(' ', $file->getClientOriginalName()));
            $fileName = time().'_asc_transaction_document_front_'.$nameOri;
            $file->move(public_path('Attachments/AscTransactionAttachments'), $fileName);
            $this->documentFront = $fileName;
        }
    }

    public function getAsqService(): AcqTransaction
    {
        return $this->acqTransaction;
    }
}
