<?php

namespace Database\Factories;

use App\Models\Consultation;
use App\Models\PatientProfile;
use App\Models\SpecialistProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsultationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Consultation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $patient = PatientProfile::orderByRaw('RAND()')->first();
        $specialist = SpecialistProfile::orderByRaw('RAND()')->first();

        return [
            'patient_profile_id' => $patient->id,
            'specialist_profile_id' => $specialist->id,
            'address_id' => $specialist->user->addresses->first()->id,
            'first_visit' => 1,
            'comments' => $this->faker->realText(),
        ];
    }
}
