<?php

namespace App\Models\action_plan\Traits;

use App\Models\action_plan\ActionPlanActivity;
use App\Models\action_plan\ActionPlanCohort;
use App\Models\agenda\Agenda;
use App\Models\deadline\Deadline;
use App\Models\item\ProposalItem;
use App\Models\narrative\Narrative;
use App\Models\participant_list\ParticipantList;
use App\Models\programme\Programme;
use App\Models\proposal\Proposal;

trait ActionPlanRelationship
{
    public function deadline()
    {
        return $this->belongsTo(Deadline::class);
    }

    public function agenda()
    {
        return $this->hasMany(Agenda::class);
    }

    public function participant_lists()
    {
        return $this->hasMany(ParticipantList::class);
    }

    public function narratives()
    {
        return $this->hasMany(Narrative::class);
    }

    public function activities()
    {
        return $this->hasManyThrough(ProposalItem::class, ActionPlanActivity::class, 'action_plan_id', 'id', 'id', 'activity_id');
    }

    public function activity()
    {
        return $this->hasOneThrough(ProposalItem::class, ActionPlanActivity::class, 'action_plan_id', 'id', 'id', 'activity_id');
    }

    public function plan_activity()
    {
        return $this->hasOne(ActionPlanActivity::class);
    }

    public function plan_activities()
    {
        return $this->hasMany(ActionPlanActivity::class);
    }

    public function plan_cohorts()
    {
        return $this->hasMany(ActionPlanCohort::class);
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
