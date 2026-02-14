<?php

namespace App\Models\proposal\Traits;

use App\Models\action_plan\ActionPlan;
use App\Models\agenda\Agenda;
use App\Models\attendance\Attendance;
use App\Models\budget\Budget;
use App\Models\donor\Donor;
use App\Models\item\ProposalItem;
use App\Models\log_frame\LogFrame;
use App\Models\narrative\Narrative;
use App\Models\participant_list\ParticipantList;
use App\Models\region\Region;

trait ProposalRelationship
{
    public function budget()
    {
        return $this->hasOne(Budget::class);
    }

    public function agenda()
    {
        return $this->hasMany(Agenda::class);
    }

    public function narratives()
    {
        return $this->hasMany(Narrative::class);
    }

    public function action_plans()
    {
        return $this->hasMany(ActionPlan::class);
    }

    public function log_frame()
    {
        return $this->hasOne(LogFrame::class);
    }

    public function participant_lists()
    {
        return $this->hasMany(ParticipantList::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function items()
    {
        return $this->hasMany(ProposalItem::class)->orderBy('row_index', 'asc');
    }

    public function objectives()
    {
        return $this->hasMany(ProposalItem::class)->where('is_obj', 1)->orderBy('row_index', 'asc');
    }
    
    public function activites()
    {
        return $this->hasMany(ProposalItem::class)->where('is_obj', 0)->orderBy('row_index', 'asc');
    }
}
