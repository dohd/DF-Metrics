<?php

namespace App\Models\memberlist\Traits;

use App\Models\age_group\AgeGroup;
use App\Models\department\Department;
use App\Models\ministry\Ministry;

trait MemberlistItemRelationship
{
    public function ministry()
    {
    	return $this->belongsTo(Ministry::class);
    }

    public function department()
    {
    	return $this->belongsTo(Department::class);
    }

    public function age_group()
    {
    	return $this->belongsTo(AgeGroup::class);
    }
}
