<?php

namespace App\Models;

use App\Events\CacheEntity;
use App\Http\Requests\PremiumPlanRequest;
use App\Traits\Cachable;
use App\Traits\FormatDates;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\Money;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PremiumPlan extends Model
{
    use HasFactory, FormatDates, Sortable, Cachable;

    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 0;

    protected $fillable = ['title', 'description', 'payment_mode', 'payment_mode', 'price', 'currency', 'discount', 'discount_until', 'order'];

    protected $casts = [
        'price' => Money::class
    ];

    protected $dispatchesEvents = [
        'saved' => CacheEntity::class
    ];

    public function features() : HasMany
    {
        return $this->hasMany(PremiumPlanFeatures::class, 'premium_id', 'id');
    }

    public function paymentFrequencies() : BelongsToMany
    {
        return $this->belongsToMany(
            PaymentFrequency::class,
            'premium_plan_payment_frequency',
            'premium_plan_id',
            'payment_frequency_id',
        )->withTimestamps();
    }

    public function getStatusLabelAttribute() : string
    {
        switch ($this->attributes['status']) {
            case 0:
                $label = __('premium-plans.status_inactive');
                break;
            default:
                $label = __('premium-plans.status_active');
                break;
        }

        return $label;
    }

    public function getStates(): array
    {
        return [
            self::STATE_ACTIVE => __('premium-plans.status_active'),
            self::STATE_INACTIVE => __('premium-plans.status_inactive')
        ];
    }

    public function new(PremiumPlanRequest $request): bool
    {
        $this->fill($request->all());

        $this->currency = 'PEN';

        $wasSaved = $this->save();

        $this->paymentFrequencies()->attach($request->get('paymentFrequency'));

        return $wasSaved;
    }

    public function commitChanges(PremiumPlanRequest $request): bool
    {
        $this->fill($request->all());

        $this->setDefaultCurrency();

        $this->paymentFrequencies()->sync($request->get('paymentFrequency'));

        // Features
        if ($request->get('feature')) {
            foreach ($request->get('feature') as $key => $feature) {
                if (!$feature['title']) continue;
                $dbFeature = PremiumPlanFeatures::updateOrCreate(
                    ['id' => $key, 'premium_id' => $this->id],
                    $feature
                );

                $this->features()->save($dbFeature);
            }

        }
        if ($request->get('new_feature')) {
            foreach ($request->get('new_feature') as $feature) {
                if (!$feature['title']) continue;
                $this->features()->create($feature);
            }

        }
        if ($request->get('featureToDelete')) {
            foreach (explode(',', $request->get('featureToDelete')) as $award) {
                $dbFeature = PremiumPlanFeatures::find($award);
                $dbFeature->delete();
            }
        }

        return $this->update();
    }

    public function cache()
    {
        foreach (self::all() as $premiumPlan) {
            foreach ($premiumPlan->toArray() as $attribute => $value) {
                $plans[$premiumPlan->id][$attribute] = $value;
            }
            $plans[$premiumPlan->id]['features'] = $premiumPlan->features->toArray();
            $plans[$premiumPlan->id]['paymentFrequencies'] = $premiumPlan->paymentFrequencies->toArray();
            $plans[$premiumPlan->id]['is_yearly'] = $premiumPlan->paymentFrequencies->contains('frequency',\App\Services\PaymentFrequency::YEARLY_PAYMENT);
            $plans[$premiumPlan->id]['is_monthly'] = $premiumPlan->paymentFrequencies->contains('frequency',\App\Services\PaymentFrequency::MONTHLY_PAYMENT);
        }
        cache()
            ->store(config('cache.default'))
            ->set(
                self::class,
                collect($plans),
                now()->addDays(5)
            );
    }

    public function remove()
    {
        if ($this->features) {
            $this->features()->delete();
        }

        if ($this->paymentFrequencies) {
            $this->paymentFrequencies()->detach();
        }

        return $this->delete();
    }

    public function getDiscountUntilInputFormatAttribute() : string
    {
        return date('Y-m-d\TH:i:s', strtotime($this->attributes['discount_until']));
    }

    private function setDefaultCurrency() : void
    {
        $this->attributes['currency'] = 'PEN';
    }
}
