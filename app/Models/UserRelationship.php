<?php

namespace App\Models;

use App\Models\company\Company;
use App\Models\team\Team;

trait UserRelationship
{
    public function teams()
    {
        return $this->hasManyThrough(Team::class, UserTeam::class, 'user_id', 'id', 'id', 'team_id')->withoutGlobalScopes();
    }

    public function userTeams()
    {
        return $this->hasMany(UserTeam::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'ins');
    }
}
