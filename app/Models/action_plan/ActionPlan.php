<?php

namespace App\Models\action_plan;

use App\Models\action_plan\Traits\ActionPlanAttribute;
use App\Models\action_plan\Traits\ActionPlanRelationship;
use App\Models\deadline\Deadline;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class ActionPlan extends Model
{
    use ModelTrait, ActionPlanAttribute, ActionPlanRelationship;    

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'departments';

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
            $deadline = Deadline::where(['active' => 1, 'module' => 'ACTION-PLAN'])
            ->whereDate('date', '>=', date('Y-m-d'))
            ->latest()->first();

            $instance->fill([
                'tid' => $instance->next_tid,
                'user_id' => auth()->user()->id,
                'ins' => auth()->user()->ins,
                'deadline_id' => @$deadline->id,
            ]);
            return $instance;
        });

        static::addGlobalScope('ins', function ($builder) {
            // $builder->where('ins', auth()->user()->ins);
        });
    }
}
