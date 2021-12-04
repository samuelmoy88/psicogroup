<?php

namespace App\Http\Livewire;

use App\Jobs\NotifyAdminPasswordReset;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminPasswordReset extends Component
{
    public string $modal;

    public User $user;

    protected $listeners = ['resetPassword'];

    public function mount($modal, User $user)
    {
        $this->modal = $modal;

        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.admin-password-reset');
    }

    public function resetPassword()
    {
        $password = Str::random(10);

        $this->user->resetPassword($password);

        dispatch(new NotifyAdminPasswordReset($this->user->profile, $password));

        $this->dispatchBrowserEvent('passwordReset');

        session()->flash('success', __('config.user_password_reset_success'));
    }
}
