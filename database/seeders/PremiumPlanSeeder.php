<?php

namespace Database\Seeders;

use App\Models\PremiumPlan;
use App\Models\PremiumPlanFeatures;
use Illuminate\Database\Seeder;

class PremiumPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $premiumPlans = [
            [
                'title' => 'Básico para profesionales',
                'payment_frequency' => 'yearly',
                'price' => 0,
                'order' => 1,
                'features' => [
                    [
                        'title' => 'Indica tus especialidades',
                        'order' => 1
                    ],
                    [
                        'title' => 'Explica a tus pacientes que patologías tratas',
                        'order' => 2
                    ],
                    [
                        'title' => 'Añade consultorios ilimitados *',
                        'order' => 3,
                        'description' => '<small>* Para que tus pacientes te encuentren más fácilmente</small>'
                    ],
                ],
            ],
            [
                'title' => 'Premium para profesionales',
                'description' => '<p class="mb-4">Destaca sobre el resto, se más visible y llega más fácil a tus pacientes</p><p>Lo mismo del plan básico para profesionales más:</p>',
                'payment_frequency' => 'yearly',
                'price' => 72000,
                'order' => 2,
                'features' => [
                    [
                        'title' => 'Añade tus redes sociales',
                        'order' => 1
                    ],
                    [
                        'title' => 'Explícale a tus pacientes donde has estudiado',
                        'order' => 2
                    ],
                    [
                        'title' => 'Comparte tus premios, distinciones y certificados',
                        'order' => 3,
                    ],
                    [
                        'title' => 'Indica tu experiencia laboral',
                        'order' => 4,
                    ],
                    [
                        'title' => 'Comparte los idiomas en los que atiendes a tus pacientes',
                        'order' => 5,
                    ],
                ],
            ],
            [
                'title' => 'Premium para centros médicos',
                'description' => '<p>Servicio exclusivo para potenciar la visibilidad de tu clínica o centro</p>',
                'payment_frequency' => 'yearly',
                'price' => 150000,
                'order' => 3,
                'features' => [
                    [
                        'title' => 'Añade ilimitados profesionales a tu centro',
                        'order' => 1
                    ],
                    [
                        'title' => 'Añade tus redes sociales',
                        'order' => 2
                    ],
                    [
                        'title' => 'Comparte tus premios y publicaciones',
                        'order' => 3,
                    ],
                    [
                        'title' => 'Comparte los idiomas en los que atiendes a tus pacientes',
                        'order' => 4,
                    ],
                    [
                        'title' => 'Comparte tu perfil de Psico-Group a través de nuestro widget',
                        'order' => 5,
                    ],
                    [
                        'title' => 'Añade hasta 5 * profesionales que trabajen en tu centro a tu plan premium',
                        'order' => 6,
                        'description' => '<small>* Para más profesionales <a href="#" class="text-blue-500 cursor-pointer underline">contacta</a> con nosotros</small>'
                    ],
                ],
            ],
        ];

        foreach ($premiumPlans as $plan) {
            /** @var PremiumPlan $plan */
            $features = $plan['features'];
            unset($plan['features']);
            $plan = PremiumPlan::create($plan);
            foreach ($features as $feature) {
                $plan->features()->save(new PremiumPlanFeatures($feature));
            }

        }
    }
}
