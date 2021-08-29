<?php

namespace App\Models;

use App\Events\CacheEntity;
use App\Traits\Cachable;
use App\Traits\FormatDates;
use App\Traits\ScopeActives;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingFeedback extends Model
{
    use HasFactory, FormatDates, Sortable, ScopeActives, Cachable;

    protected $guarded = ['id'];

    protected $dispatchesEvents = [
        'saved' => CacheEntity::class
    ];

    const TYPE_POSITIVE = 'positive';
    const TYPE_NEGATIVE = 'negative';

    public function ratings()
    {
        return $this->belongsToMany(
            Rating::class,
            'rating_rating_feedback',
            'rating_feedback_id',
            'rating_id'
        );
    }

    public function canBeDeleted()
    {
        return $this->ratings->count() < 1 ? true : false;
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 2:
                $label = __('rating-feedback.status_inactive');
                break;
            case 3:
                $label = __('rating-feedback.status_deleted');
                break;
            default:
                $label = __('rating-feedback.status_active');
                break;
        }

        return $label;
    }

    public function getTypeLabelAttribute()
    {
        switch ($this->type) {
            case 'negative':
                $label = __('rating-feedback.type_negative');
                break;
            default:
                $label = __('rating-feedback.type_positive');
                break;
        }

        return $label;
    }

    public function getTypes()
    {
        return [
            self::TYPE_POSITIVE => __('rating-feedback.type_positive'),
            self::TYPE_NEGATIVE => __('rating-feedback.type_negative'),
        ];
    }

    public function getStateLabelAttribute()
    {
        return (new self)->getTypes()[$this->state];
    }

    public function scopePositive($query)
    {
        return $query->where('type', 'positive');
    }

    public function scopeNegative($query)
    {
        return $query->where('type', 'negative');
    }
}
