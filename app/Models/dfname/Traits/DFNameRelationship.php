<?php

namespace App\Models\dfname\Traits;

use App\Models\dfzone\DFZone;

trait DFNameRelationship
{
    public function dfzone()
    {
    	return $this->belongsTo(DFZone::class);
    }
}
