<?php

namespace App\Livewire\AddCustomer;

use Livewire\Component;

class OtherSettings extends Component
{
    public $whatsapp_telegram_group;
    public $auto_backup = false;
    public $cloud_user = false;
    public $mobile_app = false;

    protected $rules = [
        'whatsapp_telegram_group' => 'nullable|boolean',
        'auto_backup' => 'nullable|boolean',
        'cloud_user' => 'nullable|boolean',
        'mobile_app' => 'nullable|boolean',
    ];

    public function save()
    {
        $this->validate();
        $this->emit('otherSettingsSaved', [
            'whatsapp_telegram_group' => $this->whatsapp_telegram_group,
            'auto_backup' => $this->auto_backup,
            'cloud_user' => $this->cloud_user,
            'mobile_app' => $this->mobile_app,
        ]);
    }

    public function render()
    {
        return view('livewire.add-customer.other-settings');
    }
}

