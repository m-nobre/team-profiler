<?php
use Illuminate\Support\Facades\Route;




/*TeamProfiler Section Start

Note: This is an automated insert by TeamProfiler

- do not edit unless package removed as lines are counted -

The reasons this was required were that jetstream routes were loaded before and this is the only way it worked.
TODO:
- Avoid the need for this and replace with a proper solution

*/

if (class_exists("MNobre\TeamProfiler\Http\Middleware\RedirectTeamRoutes")) {
    
    if (Laravel\Jetstream\Jetstream::hasTeamFeatures()) {

        /* 
            Rename current jetstream routes to avoid conflict (avoided prefix group to not change endpoints) 
        */

        Route::get('/teams/create', [Laravel\Jetstream\Http\Controllers\Livewire\TeamController::class, 'create'])
            ->name('jetstream.teams.create');
        Route::get('/teams/{team}', [Laravel\Jetstream\Http\Controllers\Livewire\TeamController::class, 'show'])
            ->name('jetstream.teams.show');
        Route::put('/current-team', [Laravel\Jetstream\Http\Controllers\CurrentTeamController::class, 'update'])
            ->name('jetstream.current-team.update');    
        Route::get('/team-invitations/{invitation}', [Laravel\Jetstream\Http\Controllers\TeamInvitationController::class, 'accept'])
            ->middleware(['signed'])
            ->name('jetstream.team-invitations.accept');

        /* 
            Creating new routes with the naming convention pretended
        */

        Route::middleware(['web', 'auth', MNobre\TeamProfiler\Http\Middleware\RedirectTeamRoutes::class])
        ->group(function () {

            if ($noun = config('team-profiler.denomination', 'team')) {
    
                Route::get('/' . $noun . 's/create', [Laravel\Jetstream\Http\Controllers\Livewire\TeamController::class, 'create'])->name('teams.create');
                Route::get('/' . $noun . 's/{team}', [Laravel\Jetstream\Http\Controllers\Livewire\TeamController::class, 'show'])->name('teams.show');
                Route::put('/current-' . $noun, [Laravel\Jetstream\Http\Controllers\CurrentTeamController::class, 'update'])->name('current-team.update');
            
                Route::get('/' . $noun . '-invitations/{invitation}', [Laravel\Jetstream\Http\Controllers\TeamInvitationController::class, 'accept'])
                    ->middleware(['signed'])
                    ->name('team-invitations.accept');
            }
        });
    
    }
}


/* End of section TeamProfiler*/