<?php

namespace App\Domains\Suppliers\Models\Traits;

use App\Domains\Suppliers\Notifications\LinkToSupplierActivation;

trait SupplierFunction
{
    public function sendLinkToSupplierActivationNotification()
    {
        $this->notify( (new LinkToSupplierActivation())->delay(now()->addSeconds(10)) );
    }
}
