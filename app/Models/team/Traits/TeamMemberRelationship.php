<?php

namespace App\Models\team\Traits;

use App\Models\memberlist\MemberlistItem;
use App\Models\metric\MetricMember;
use App\Models\team\VerifyMember;

trait TeamMemberRelationship
{
    public function memberlistItem()
    {
        return $this->belongsTo(MemberlistItem::class, 'memberlist_item_id');
    }

    public function metricMembers()
    {
        return $this->hasMany(MetricMember::class);
    }

    public function verify_members()
    {
        return $this->hasMany(VerifyMember::class);
    }
}
