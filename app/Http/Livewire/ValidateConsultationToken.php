<?php

namespace App\Http\Livewire;

use App\Models\Consultation;
use Livewire\Component;

class ValidateConsultationToken extends Component
{
    public Consultation $consultation;

    public string $token = '';

    protected $listeners = ['confirm'];

    public bool $validated = false;

    protected $rules = [
        'token' => 'required|min:6|max:6'
    ];

    protected $messages = [
        'token.required' => 'El código de verificación es obligatorio',
        'token.min' => 'El código de verificación es de 6 caracteres',
        'token.max' => 'El código de verificación no es válido',
    ];

    public function mount(Consultation $consultation)
    {
        $this->consultation = $consultation;
    }

    public function confirm()
    {
        $this->validate();

        if ($this->token == $this->consultation->verification->token) {
            $this->consultation->verified = 1;
            $this->consultation->update();
            $this->validated = true;
            $this->consultation->notifyRequestConfirmation();
        } else {
            $this->addError('mismatch', __('common.token_mismatch'));
            $this->reset('token');
        }
    }


    public function render()
    {
        return view('livewire.validate-consultation-token');
    }
}
