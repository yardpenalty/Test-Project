<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GuestSignIn extends Component
{
    public function render()
    {
		$email = '';
		$firstname = ''; 
        return view('livewire.guest-sign-in');
    }
}
