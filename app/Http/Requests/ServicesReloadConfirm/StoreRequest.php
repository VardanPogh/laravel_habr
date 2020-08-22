<?php

namespace App\Http\Requests\ServicesReloadConfirm;

use App\Services;
use App\ServicesReloadConfirm;
use App\Transaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    public $serviceReloadConfirm;

    public function rules()
    {
        return [
            'reloaded_number'           => 'required|int',
            'confirm_reloaded_number'   => 'required|int|same:reloaded_number',
            'service_id'                => 'required|int|exists:services,id'
        ];
    }

    public function persist(): self
    {
        $this->serviceReloadConfirm = ServicesReloadConfirm::create(array_merge($this->request->all(), $this->getMergingData()));
        $this->createTransaction();
        return $this;
    }

    public function manageRelations()
    {
        $this->createTransaction();
    }

    public function getMergingData(): array
    {
        return [
          'user_id' => Auth::id()
        ];
    }

    public function createTransaction(): Transaction
    {
        $service = Services::find($this->service_id);
        return Transaction::create([
            'user_id' => Auth::id(),
            'client_id' => Auth::id(),
            'service_id' => $service->id ,
            'price' => $service->amount,
            'agent_percent' => $service->amount * $service->agent_percent / 100,
            'admin_percent' => $service->amount * $service->admin_percent / 100,
            'options' => 1,
            'payment_status' => 0
        ]);
    }

    public function getServiceReloadConfirm(): ServicesReloadConfirm
    {
        return $this->serviceReloadConfirm;
    }
}
