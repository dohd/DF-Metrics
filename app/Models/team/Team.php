<?php

namespace App\Models\team;

use App\Models\ModelTrait;
use App\Models\team\Traits\TeamAttribute;
use App\Models\team\Traits\TeamRelationship;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use ModelTrait, TeamAttribute, TeamRelationship;    

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'teams';

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
            $model->tid = Team::max('tid')+1;
            $model->user_id = auth()->user()->id;
            $model->ins = auth()->user()->ins;
            return $model;
        });

        static::addGlobalScope('id', function ($builder) {
            $user = auth()->user();
            if ($user && in_array($user->user_type, ['shepherd', 'overseer']) && $user->userTeams->isNotEmpty()) {
                $builder->whereIn('id', $user->userTeams->pluck('team_id'));
            }
        });
    }
}
