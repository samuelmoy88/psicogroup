<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Rules\IsValidPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{
    protected array $listeners = ['changePassword', 'doPasswordsMatch','newPasswordType', 'confirmPasswordType'];

    public string $currentPassword = '';

    public string $newPassword = '';

    public string $confirmPassword = '';

    public string $modal = '';

    public function mount($modal)
    {
        $this->modal = $modal;

/*        $this->validationAttributes = [
            'currentPassword' => __('common.current_password'),
            'newPassword' => __('common.new_password'),
            'confirmPassword' => __('common.confirm_password'),
        ];

        $this->messages = [
            'currentPassword.password' => __('common.current_password_error'),
            'newPassword.same' => __("common.same_password_error"),
            'confirmPassword.same' => __("common.same_password_error"),
            'confirmPassword.required' => __("common.same_password_confirm"),
        ];*/
    }

    public function render()
    {
        return view('livewire.change-password');
    }

    public function changePassword($data)
    {
        $this->init($data);

        $this->validate([
            'currentPassword' => ['required', 'password'],
            'newPassword' => ['required','same:confirmPassword', new IsValidPassword()],
            'confirmPassword' => ['required', 'same:newPassword']
        ]);

        $user = User::find(auth()->user()->id);

        $user->password = Hash::make($this->newPassword);

        if ($user->save()) {
            $this->reset(['currentPassword', 'newPassword', 'confirmPassword']);

            session()->flash('message',__('common.password_changed_success'));

            $this->dispatchBrowserEvent('passwordChanged');
        }
    }

    public function doPasswordsMatch($data)
    {
        $this->init($data);

        $this->validate([
            'newPassword' => ['required', new IsValidPassword()],
            'confirmPassword' => ['required', 'same:newPassword']
        ]);
    }

    public function init($data)
    {
        $this->currentPassword = $data['current_password'] ?? '';
        $this->newPassword = $data['password'] ?? '';
        $this->confirmPassword = $data['password_confirmation'] ?? '';
    }

}
