<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;

class Login extends Component
{
    public $identity;
    public $password;
    private $identityType;

    protected $rules = [
        'password' => 'required|string'
    ];

    public function updatedIdentity() {
        $this->validateIdentity();
    }

    public function login() {
        $this->validateIdentity();
        $this->validateOnly('password');

        if (Auth::attempt([$this->identityType => $this->identity, 'password' => $this->password])) {
            $this->redirect('/app');          //If user was authenticated correctly, go to dashboard
        } else {
            throw ValidationException::withMessages([   //If the authentication was unsuccessful, throw error
                'identity' => ['The identity or password you provided doesnt match our records']
            ]);
        }
    }

    public function render()
    {
        return view('livewire.login');
    }

    private function validateIdentity() {
        if (str_contains($this->identity, '@')) {
            $this->identityType = 'email';
            $this->validateOnly('identity', [
                'identity' => 'required|exists:users,email',                    //Identity is an email
            ],
                [
                    'identity.exists' => "The email provided doesnt exist"      //Message if fails
                ]);
        } else {
            $this->identityType = 'username';
            $this->validateOnly('identity', [
                'identity' => 'required|exists:users,username',                 //Identity is a username
            ],
                [
                    'identity.exists' => "The username provided doesnt exist"   //Message if fails
                ]);
        }
    }
}
