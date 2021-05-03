<?php

namespace App\Models;

use App\Http\Requests\AddressRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Address extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['paymentMethods', 'services', 'accessibility'];

    const TYPE_PHYSICAL = 'physical';
    const TYPE_ONLINE = 'online';

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'addresses_users',
            'address_id',
            'user_id'
        );
    }

    public function accessibility()
    {
        return $this->belongsToMany(
            AddressAccessibility::class,
            'addresses_address_accessibilities',
        );
    }

    public function services()
    {
        return $this->belongsToMany(
            SpecialistProfileServices::class,
            'addresses_services_specialist',
            'address_id',
            'specialist_profile_service_id'
        );
    }

    public function insuranceSupport()
    {
        return $this->belongsTo(InsuranceSupport::class);
    }

    public function securityMeasures()
    {
        return $this->belongsToMany(
            SecurityMeasures::class,
            'addresses_security_measures',
    'address_id',
            'security_measure_id'
            );
    }

    public function paymentMethods()
    {
        return $this->belongsToMany(
            PaymentMethod::class,
            'addresses_payment_methods'
            );
    }

    public function onlinePlatforms()
    {
        return $this->belongsToMany(
            OnlineConsultationPlatform::class,
            'addresses_online_consultation_platforms',
            'address_id',
            'online_consultation_platform_id'
            );
    }

    public function getPracticeLabelAttribute()
    {
        return $this->is_private ? __('common.private_practice') : __('common.medical_center');
    }

    public function getWebSite()
    {
        if (!Str::contains(strtolower($this->web_site),'https://')) {
            return 'https://' . str_replace(['http://', 'http', '//'], '', $this->web_site);
        }

        return $this->web_site;
    }

    public function new(AddressRequest $request)
    {
        /** @var Address $address */
        $address = self::create($request->all());

        if ($request->accessibility) {
            foreach ($request->accessibility as $accessibility) {
                $address->accessibility()->attach($accessibility);
            }
        }

        if ($request->paymentMethods) {
            foreach ($request->paymentMethods as $paymentMethod) {
                $address->paymentMethods()->attach($paymentMethod);
            }
        }

        /*if ($request->services) {
            foreach ($request->services as $service_id => $service) {
                auth()->user()->profile->toggleService($service_id, $service);
                $this->toggleServices($service_id, $service);
            }
        }

        if ($request->customServices) {
            foreach ($request->customServices as $service_id => $service) {
                auth()->user()->profile->toggleService($service_id, $service);
                $this->toggleServices($service_id, $service);
            }
        }*/


        if ($request->securityMeasures) {
            foreach ($request->securityMeasures as $securityMeasure) {
                $address->securityMeasures()->attach($securityMeasure);
            }
        }

        if ($request->onlinePlatforms) {
            foreach ($request->onlinePlatforms as $onlinePlatform => $value) {
                $this->toggleOnlinePlatform($onlinePlatform, $value);
            }
        }

        auth()->user()->addresses()->attach($address->id);

    }

    public function edit(AddressRequest $request)
    {
        /** @var Address $address */
        $this->update($request->all());

        if ($request->accessibility) {
            foreach ($request->accessibility as $accessibility => $value) {
                $this->toggleAccessibility($accessibility, $value);
            }
        }

        if ($request->paymentMethods) {
            foreach ($request->paymentMethods as $paymentMethod => $value) {
                $this->togglepaymentMethods($paymentMethod, $value);
            }
        }

        if ($request->services) {
            foreach ($request->services as $service => $value) {
                $this->toggleServices($service, $value);
            }
        }

        if ($request->securityMeasures) {
            foreach ($request->securityMeasures as $securityMeasure => $value) {
                $this->toggleSecurityMeasure($securityMeasure, $value);
            }
        }

        if ($request->onlinePlatforms) {
            foreach ($request->onlinePlatforms as $onlinePlatform => $value) {
                $this->toggleOnlinePlatform($onlinePlatform, $value);
            }
        }
    }

    protected function toggleAccessibility($accessibility_id, $value)
    {
        if (!$this->accessibility->contains($accessibility_id) && $value) {
            return $this->accessibility()->attach($accessibility_id);
        }

        if ($this->accessibility->contains($accessibility_id) && $value == '0') {
            return $this->accessibility()->detach($accessibility_id);
        }
    }

    protected function togglePaymentMethods($payment_method_id, $value)
    {
        if (!$this->paymentMethods->contains($payment_method_id) && $value) {
            return $this->paymentMethods()->attach($payment_method_id);
        }

        if ($this->paymentMethods->contains($payment_method_id) && $value == '0') {
            return $this->paymentMethods()->detach($payment_method_id);
        }
    }

    /*protected function toggleServices($service_id, $data)
    {
        if (!$this->services->contains($service_id) && isset($data['service_id'])) {
            return $this->services()->attach($service_id);
        }

        if ($this->services->contains($service_id) && !isset($data['service_id'])) {
            return $this->services()->detach($service_id);
        }
    }*/

    protected function toggleSecurityMeasure($security_measure_id, $value)
    {
        if (!$this->securityMeasures->contains($security_measure_id) && $value) {
            return $this->securityMeasures()->attach($security_measure_id);
        }

        if ($this->securityMeasures->contains($security_measure_id) && $value == '0') {
            return $this->securityMeasures()->detach($security_measure_id);
        }
    }

    protected function toggleOnlinePlatform($online_consultation_platform_id, $value)
    {
        if (!$this->onlinePlatforms->contains($online_consultation_platform_id) && $value) {
            return $this->onlinePlatforms()->attach($online_consultation_platform_id);
        }

        if ($this->onlinePlatforms->contains($online_consultation_platform_id) && $value == '0') {
            return $this->onlinePlatforms()->detach($online_consultation_platform_id);
        }
    }
}
