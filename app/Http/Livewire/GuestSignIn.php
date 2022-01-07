<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Shopper\Shopper;
class GuestSignIn extends Component
{
    public function render()
    {
		//Guest Shopper $model;
        return view('livewire.guest-sign-in');
    }
}
