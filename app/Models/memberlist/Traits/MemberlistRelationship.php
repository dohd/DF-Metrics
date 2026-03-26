<?php

namespace App\Models\memberlist\Traits;

use App\Models\dfname\DFName;
use App\Models\memberlist\MemberlistItem;
use App\Models\memberlist\MemberMinistry;
use App\Models\team\Team;

trait MemberlistRelationship
{
    public function memberMinistries()
    {
        return $this->hasMany(MemberMinistry::class);
    }

    public function team()
    {
        return $this->hasOne(Team::class);
    }

    public function items()
    {
    	return $this->hasMany(MemberlistItem::class);
    }

    public function dfname()
    {
        return $this->belongsTo(DFName::class);
    }
}
