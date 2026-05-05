<?php

namespace App\Models\memberlist\Traits;

use App\Models\age_group\AgeGroup;
use App\Models\department\Department;
use App\Models\memberlist\MemberMinistry;
use App\Models\ministry\Ministry;
use App\Models\team\TeamMember;

trait MemberlistItemRelationship
{
    public function teamMember()
    {
        return $this->hasOne(TeamMember::class, 'memberlist_item_id');
    }

    public function memberMinistries()
    {
        return $this->hasMany(MemberMinistry::class);
    }

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
