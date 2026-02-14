<?php

namespace App\Models\testimonial;

use App\Models\ModelTrait;
use App\Models\testimonial\Traits\TestimonialAttribute;
use App\Models\testimonial\Traits\TestimonialRelationship;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use ModelTrait, TestimonialAttribute, TestimonialRelationship;

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'testimonials';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [];

    /**
     * Default values for model fields
     * @var array
     */
    protected $attributes = [];

    /**
     * Dates
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Guarded fields of model
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Constructor of Model
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->tid = Testimonial::max('tid') + 1;
            if (auth()->id()) {
                $model->user_id = auth()->user()->id;
                $model->ins = auth()->user()->ins;
            }
            return $model;
        });

        static::addGlobalScope('ins', function ($builder) {
            if (auth()->id()) {
                $builder->where('ins', auth()->user()->ins);                
            }
        });
    }
}
