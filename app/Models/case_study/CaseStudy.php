<?php

namespace App\Models\case_study;

use App\Models\case_study\Traits\CaseStudyAttribute;
use App\Models\case_study\Traits\CaseStudyRelationship;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    use ModelTrait, CaseStudyAttribute, CaseStudyRelationship;

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'case_studies';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [
        'full_name',
        'age_group_id',
        'tid', 
        'programme_id', 
        'date', 
        'title', 
        'situation', 
        'intervention', 
        'impact', 
        'image1',
        'image2',
        'image3',
        'caption1',
        'caption2',
        'caption3',
        'user_id', 
        'ins'
    ];

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
            $instance->user_id = auth()->user()->id;
            $instance->ins = auth()->user()->ins;
            $instance->tid = CaseStudy::max('tid') + 1;
            return $instance;
        });

        static::addGlobalScope('ins', function ($builder) {
            $builder->where('ins', auth()->user()->ins);
        });
    }
}
