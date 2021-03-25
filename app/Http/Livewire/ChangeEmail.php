<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class ChangeEmail extends Component
{
    public string $modal;

    protected array $listeners = ['changeEmail'];

    public string $password = '';

    public string $email = '';


    public function mount($modal)
    {
        $this->modal = $modal;

        $this->validationAttributes = [
            'password' => __('Current password'),
            'email' => __('Email address'),
        ];


        $this->messages = [
            'password.password' => __('Your current password did not match our records'),
            'password.required' => __("The password is required"),
            'email.required' => __("New email is required"),
            'email.email' => __("Please enter a valid email address"),
            'email.unique' => __("This email address already exists in our records, please use a different one"),
        ];
    }

    public function render()
    {
        return view('livewire.change-email');
    }

    public function changeEmail()
    {
        $this->validate([
            'password' => ['required', 'password'],
            'email' => ['required', 'email', 'unique:users,email,'.auth()->user()->id]
        ]);

        $user = User::find(auth()->user()->id);

        $user->email = $this->email;

        if ($user->save()) {
            $this->reset(['password', 'email']);

            session()->flash('message',__('Email changed successfully'));

            $this->dispatchBrowserEvent('emailChanged');
        }
    }
}
