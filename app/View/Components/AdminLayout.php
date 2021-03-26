<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminLayout extends Component
{
    public array $modules = [];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->modules = [
            [
                'name' => 'Especialistas',
                'icon' => '<i class="fas fa-user-md"></i>',
                'permission' => 'doctors_read',
                'sub-modules' => [
                    [
                        'name' => __('specialists.specialists_list'),
                        'uri' => route('doctors.index'),
                        'list_class' => request()->routeIs('doctors.*') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('doctors.*') ? 'text-white' : '',
                        'permission' => 'doctors_read',
                    ],
                    [
                        'name' => __('specialists.specialists_changes'),
                        'uri' => route('changes.index'),
                        'list_class' => request()->routeIs('changes.*') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('changes.*') ? 'text-white' : '',
                        'permission' => 'doctors_manage_changes',
                    ],
                ],
                'dropdown-variable' => 'isSpecialistsMenuOpen',
                'dropdown-click-event' => 'toggleSpecialistsMenu'
            ],
            [
                'name' => 'Pacientes',
                'icon' => '<i class="fas fa-user-injured"></i>',
                'permission' => 'patients_read',
                'sub-modules' => [
                    [
                        'name' => __('patients.patients_list'),
                        'uri' => route('patients.index'),
                        'list_class' => request()->routeIs('patients.*') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('patients.*') ? 'text-white' : '',
                        'permission' => 'patients_read',
                    ],
                ],
                'dropdown-variable' => 'isPatientsMenuOpen',
                'dropdown-click-event' => 'togglePatientsMenu'
            ],
            [
                'name' => 'Servicios',
                'icon' => '<i class="fas fa-star-of-life"></i>',
                'permission' => 'services_read',
                'sub-modules' => [
                    [
                        'name' => __('services.services_list'),
                        'uri' => route('services.index'),
                        'list_class' => request()->routeIs('services.index') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('services.index') ? 'text-white' : '',
                        'permission' => 'services_read',
                    ],
                    [
                        'name' => __('services.new_service'),
                        'uri' => route('services.create'),
                        'list_class' => request()->routeIs('services.create') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('services.create') ? 'text-white' : '',
                        'permission' => 'services_create',
                    ],
                ],
                'dropdown-variable' => 'isServicesMenuOpen',
                'dropdown-click-event' => 'toggleServicesMenu'
            ],
            [
                'name' => 'Especialidades',
                'icon' => '<i class="fas fa-book-medical"></i>',
                'permission' => 'specialities_read',
                'sub-modules' => [
                    [
                        'name' => __('specialities.specialities_list'),
                        'uri' => route('specialities.index'),
                        'list_class' => request()->routeIs('specialities.index') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('specialities.index') ? 'text-white' : '',
                        'permission' => 'specialities_read',
                    ],
                    [
                        'name' => __('specialities.new_speciality'),
                        'uri' => route('specialities.create'),
                        'list_class' => request()->routeIs('specialities.create') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('specialities.create') ? 'text-white' : '',
                        'permission' => 'specialities_create',
                    ],
                ],
                'dropdown-variable' => 'isSpecialitiesMenuOpen',
                'dropdown-click-event' => 'toggleSpecialitiesMenu'
            ],
            [
                'name' => __('diseases.diseases'),
                'icon' => '<i class="fas fa-viruses"></i>',
                'permission' => 'diseases_read',
                'sub-modules' => [
                    [
                        'name' => __('diseases.diseases_list'),
                        'uri' => route('diseases.index'),
                        'list_class' => request()->routeIs('diseases.index') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('diseases.index') ? 'text-white' : '',
                        'permission' => 'diseases_read',
                    ],
                    [
                        'name' => __('diseases.new_disease'),
                        'uri' => route('diseases.create'),
                        'list_class' => request()->routeIs('diseases.create') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('diseases.create') ? 'text-white' : '',
                        'permission' => 'diseases_create',
                    ],
                ],
                'dropdown-variable' => 'isDiseasesMenuOpen',
                'dropdown-click-event' => 'toggleDiseasesMenu'
            ],
            [
                'name' => 'Metodos de pago',
                'icon' => '<i class="fas fa-money-check-alt"></i>',
                'permission' => 'payment_methods_read',
                'sub-modules' => [
                    [
                        'name' => __('payment-methods.pm_list'),
                        'uri' => route('payment-methods.index'),
                        'list_class' => request()->routeIs('payment-methods.index') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('payment-methods.index') ? 'text-white' : '',
                        'permission' => 'payment_methods_read',
                    ],
                    [
                        'name' => __('payment-methods.new_pm'),
                        'uri' => route('payment-methods.create'),
                        'list_class' => request()->routeIs('payment-methods.create') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('payment-methods.create') ? 'text-white' : '',
                        'permission' => 'payment_methods_create',
                    ],
                ],
                'dropdown-variable' => 'isPaymentMethodsMenuOpen',
                'dropdown-click-event' => 'togglePaymentMethodsMenu'
            ],
            [
                'name' => 'Medidas de seguridad',
                'icon' => '<i class="fas fa-head-side-mask"></i>',
                'permission' => 'security_measures_read',
                'sub-modules' => [
                    [
                        'name' => __('security-measures.pm_list'),
                        'uri' => route('security-measures.index'),
                        'list_class' => request()->routeIs('security-measures.index') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('security-measures.index') ? 'text-white' : '',
                        'permission' => 'security_measures_read',
                    ],
                    [
                        'name' => __('security-measures.new_sm'),
                        'uri' => route('security-measures.create'),
                        'list_class' => request()->routeIs('security-measures.create') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('security-measures.create') ? 'text-white' : '',
                        'permission' => 'security_measures_create',
                    ],
                ],
                'dropdown-variable' => 'isSecurityMeasuresMenuOpen',
                'dropdown-click-event' => 'toggleSecurityMeasuresMenu'
            ],
            [
                'name' => 'Configuración',
                'icon' => '<i class="fas fa-cogs"></i>',
                'permission' => 'config_read',
                'sub-modules' => [
                    [
                        'name' => __('config.users'),
                        'uri' => route('config.users.index'),
                        'list_class' => request()->routeIs('config.users.*') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('config.users.*') ? 'text-white' : '',
                        'permission' => 'users_read',
                    ],
                    [
                        'name' => __('config.roles'),
                        'uri' => route('config.roles.index'),
                        'list_class' => request()->routeIs('config.roles.*') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('config.roles.*') ? 'text-white' : '',
                        'permission' => 'roles_read',
                    ],
                    [
                        'name' => __('config.permissions'),
                        'uri' => route('config.permissions.index'),
                        'list_class' => request()->routeIs('config.permissions.*') ? 'bg-brand-color' : '',
                        'anchor_class' => request()->routeIs('config.permissions.*') ? 'text-white' : '',
                        'permission' => 'permissions_read',
                    ],
                ],
                'dropdown-variable' => 'isConfigMenuOpen',
                'dropdown-click-event' => 'toggleConfigMenu'
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('layouts.admin');
    }
}