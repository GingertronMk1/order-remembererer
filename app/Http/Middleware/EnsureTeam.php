<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureTeam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if ($user->isMemberOfATeam()) {
            if (is_null($user->current_team_id)) {
                $user->current_team_id = $user->allTeams()->first()->id;
                $user->save();
            }
            return $next($request);
        } else {
            return redirect()->route('teams.create');
        }
    }
}
