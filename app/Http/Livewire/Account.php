<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;
use App\Models\User;

class Account extends Component
{
    use WireToast;

    public User $user;
    public $editing = false;

    public function rules() {
        return [
            'user.name' => ['required', 'string', 'max:255'],
            'user.surname' => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'string', 'email', 'max:255', Rule::unique('users','email')->ignore($this->user->id)],
            'user.birthday' => ['date', 'before:today'],
            'user.phone' => ['min_digits:9', 'max_digits:9','integer'],
        ];
    }

    //livewire lifecycle
    public function mount() {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.account');
    }

    //Account functions
    public function logout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        $this->redirect('/');
    }

    public function editProfile() {
        $this->editing = !$this->editing;
    }

    public function sync() {
        try {
            if($this->user->isDirty()) { //if the user changed update it
                $this->validate();

                $this->user->save();
                toast()->success('User data updated')->duration(4000)->push();
            }
            $this->editProfile(); //Turn off editing
        } catch (ValidationException $e) {
            foreach ($e->validator->getMessageBag()->getMessages() as $field) {
                foreach ($field as $message) {
                    toast()->danger($message)->duration(4000)->push();
                }
            }
        }
    }

    //Extra functions
    public function fullName() {
        return $this->user->name . ' ' . $this->user->surname;
    }

    public function getBirthdayFormated() {
        return Carbon::parse($this->user->birthday)->format('M d Y');
    }

}
