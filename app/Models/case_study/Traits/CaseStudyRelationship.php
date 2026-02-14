<?php

namespace App\Models\case_study\Traits;

use App\Models\programme\Programme;

trait CaseStudyRelationship
{
    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }
}
