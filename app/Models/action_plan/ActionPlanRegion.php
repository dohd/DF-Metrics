<?php

namespace App\Models\action_plan;

use App\Models\action_plan\Traits\ActionPlanRegionRelationship;
use Illuminate\Database\Eloquent\Model;

class ActionPlanRegion extends Model
{
    use ActionPlanRegionRelationship;    

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'action_plan_regions';

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

        static::creating(function ($instance) {
            return $instance;
        });
    }
}
