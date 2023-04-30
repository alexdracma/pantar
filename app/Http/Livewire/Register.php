<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\CreateNewUser;
class Register extends Component
{

    public $name;
    public $surname;
    public $username;
    public $email;
    public $password;

    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'surname' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^[^\x40]+$/u'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    ];

    protected $messages = [
      'username.regex' => 'The username cannot contain @'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function register($data) {

        (new CreateNewUser())->create($data);        //Create the new user, this class comes from Jetstream directly,
                                                     //so it handles the validation
        Auth::attempt(['email' => $this->email,
            'password' => $this->password]);         //Authenticate the new user

        $this->redirect('/dashboard');           //Go to dashboard
    }

    public function render()
    {
        return view('livewire.register');
    }
}
