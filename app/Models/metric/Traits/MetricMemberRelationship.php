<?php

namespace App\Models\metric\Traits;

use App\Models\team\TeamMember;

trait MetricMemberRelationship
{
    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class);
    }
}
