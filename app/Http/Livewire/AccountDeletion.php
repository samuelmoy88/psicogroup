<?php

namespace App\Http\Livewire;

use App\Jobs\NotifyUserDeletionCode;
use App\Models\UserDeletion;
use Carbon\Carbon;
use Livewire\Component;
use function Symfony\Component\String\u;

class AccountDeletion extends Component
{
    public string $modal;

    protected array $listeners = ['sendVerificationCode', 'deleteAccount'];

    public bool $codeHasBeenSent = false;

    public string $verificationCode = '';

    protected $rules = [
        'verificationCode' => 'required|min:6|max:6'
    ];

    protected $messages = [
        'verificationCode.required' => 'El código de verificación es obligatorio',
        'verificationCode.min' => 'El código de verificación es de 6 caracteres',
        'verificationCode.max' => 'El código de verificación no es válido',
    ];

    public function mount($modal)
    {
        $this->modal = $modal;
    }

    public function render()
    {
        return view('livewire.account-deletion');
    }

    public function sendVerificationCode()
    {
        $userDeletion = new UserDeletion();

        $userDeletion->generateCode();

        $userDeletion->user_id = auth()->user()->id;

        $userDeletion->save();

        $this->codeHasBeenSent = true;

        dispatch(new NotifyUserDeletionCode(auth()->user(), $userDeletion->verification_code));
    }

    public function deleteAccount()
    {
        if (!$this->validateCode()) {
            return false;
        }

        $user = auth()->user();

        auth()->logout();

        if (!$user->delete()) {
            return false;
        }

        return $this->redirect(route('front.home'));
    }

    private function validateCode()
    {
        $this->validate();

        $now = strtotime('now');

        $latestCode = UserDeletion::where('user_id', auth()->user()->id)
            ->latest()
            ->first();

        if ($this->verificationCode == $latestCode->verification_code && $now <= strtotime($latestCode->valid_until)) {
            return true;
        } else {
            $this->addError('mismatch', __('common.token_mismatch'));
            $this->reset('verificationCode');
            return false;
        }
    }
}
