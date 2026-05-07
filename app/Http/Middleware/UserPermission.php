<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class UserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string $type  The required user type (e.g., 'admin', 'editor')
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $overseerRoutes = [
            'storage.file_download',
            'home',
            'study_materials.index',
            'study_materials.show',
            'testimonials.index',
            'testimonials.show',
            'narratives.index',
            'narratives.show',
            'memberlists.index',
            'memberlists.show',
            'teams.index',
            'verification_teams',
            'verify_teams',
            'metrics.index',
            'metrics.get_data',
            'metrics.approve',
            'metrics.verified_team_members',
            'reports.metric_summary',
            'reports.metric_summary.post',
            'reports.team_member_summary',
            'reports.team_member_summary.post',
            'reports.team_size_summary',
            'reports.team_size_summary.post',
            'reports.team_report_card',
            'reports.team_report_card.post',
        ];

        $user = Auth::user();
        if ($user && $user->user_type === 'overseer') {
            // If current route is not in the allowed list, block access
            $currentRoute = Route::currentRouteName();
            if (!in_array($currentRoute, $overseerRoutes)) {
                return redirect('/home')->with('error', 'Access denied. You can only view index pages.');
            }
        }

        return $next($request);
    }
}