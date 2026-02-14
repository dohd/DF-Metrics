<?php

namespace App\Models\action_plan\Traits;

use App\Models\action_plan\ActionPlan;
use App\Models\action_plan\ActionPlanActivity;
use App\Models\cohort\Cohort;

trait ActionPlanCohortRelationship
{
    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

    public function plan_activity()
    {
        return $this->belongsTo(ActionPlanActivity::class, 'plan_activity_id');
    }

    public function action_plan()
    {
        return $this->belongsTo(ActionPlan::class);
    }
}
