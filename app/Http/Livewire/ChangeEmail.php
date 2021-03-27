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
            'password.password' => __('common.current_password_error'),
            'password.required' => __("common.password_required"),
            'email.required' => __("common.new_email_required"),
            'email.email' => __("common.email_invalid"),
            'email.unique' => __("common.email_unique"),
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

            session()->flash('message',__('common.email_changed_success'));

            $this->dispatchBrowserEvent('emailChanged');
        }
    }
}
