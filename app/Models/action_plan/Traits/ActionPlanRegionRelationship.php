<?php

namespace App\Models\action_plan\Traits;

use App\Models\action_plan\ActionPlan;
use App\Models\action_plan\ActionPlanActivity;
use App\Models\region\Region;

trait ActionPlanRegionRelationship
{
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function action_plan()
    {
        return $this->belongsTo(ActionPlan::class);
    }

    public function plan_activity()
    {
        return $this->belongsTo(ActionPlanActivity::class, 'plan_activity_id');
    }
}
