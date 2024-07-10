<?php

namespace App\Livewire\EditCustomer;

use Livewire\Component;

class EditCustomerFeatures extends Component
{
    public $whatsapp_telegram_group;
    public $auto_backup;
    public $cloud_user;
    public $mobile_app;

    protected $rules = [
        'whatsapp_telegram_group' => 'nullable|boolean',
        'auto_backup' => 'nullable|boolean',
        'cloud_user' => 'nullable|boolean',
        'mobile_app' => 'nullable|boolean',
    ];

    public function mount($customer)
    {
        $this->fill($customer->only([
            'whatsapp_telegram_group', 'auto_backup', 'cloud_user', 'mobile_app'
        ]));
    }

    public function save()
    {
        $this->validate();

        $this->emit('updateCustomerFeatures', [
            'whatsapp_telegram_group' => $this->whatsapp_telegram_group,
            'auto_backup' => $this->auto_backup,
            'cloud_user' => $this->cloud_user,
            'mobile_app' => $this->mobile_app,
        ]);
    }

    public function render()
    {
        return view('livewire.edit-customer.edit-customer-features');
    }
}
