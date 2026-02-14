<?php

namespace App\Models\memberlist\Traits;

use App\Models\dfname\DFName;
use App\Models\memberlist\MemberlistItem;

trait MemberlistRelationship
{
    public function items()
    {
    	return $this->hasMany(MemberlistItem::class);
    }

    public function dfname()
    {
        return $this->belongsTo(DFName::class);
    }
}
