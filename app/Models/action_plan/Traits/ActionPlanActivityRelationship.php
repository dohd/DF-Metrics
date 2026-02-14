<?php

namespace App\Models\action_plan\Traits;

use App\Models\action_plan\ActionPlan;
use App\Models\action_plan\ActionPlanCohort;
use App\Models\action_plan\ActionPlanRegion;
use App\Models\cohort\Cohort;
use App\Models\item\ProposalItem;
use App\Models\region\Region;

trait ActionPlanActivityRelationship
{
    public function activity()
    {
        return $this->belongsTo(ProposalItem::class, 'activity_id');
    }

    public function regions()
    {
        return $this->hasManyThrough(Region::class, ActionPlanRegion::class, 'plan_activity_id', 'id', 'id', 'region_id');
    }

    public function activity_cohort()
    {
        return $this->hasOne(ActionPlanCohort::class, 'plan_activity_id');
    }

    public function cohort()
    {
        return $this->hasOneThrough(Cohort::class, ActionPlanCohort::class, 'plan_activity_id', 'id', 'id', 'cohort_id');
    }

    public function cohorts()
    {
        return $this->hasManyThrough(Cohort::class, ActionPlanCohort::class, 'plan_activity_id', 'id', 'id', 'cohort_id');
    }

    public function action_plan()
    {
        return $this->belongsTo(ActionPlan::class);
    }
}
