<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Level;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define("operator", function ($user) {
            return $user->userHasLevelNotActive->level->name === Level::OPERATOR;
        });
        Gate::define("ketuaP4mp", function ($user) {
            return $user->userHasLevel?->level->name === Level::KETUA_P4MP;
        });
        Gate::define("lead", function ($user) {
            return $user->userHasLevel?->level->name === Level::KETUA_P4MP;
        });
        Gate::define("anggota", function ($user) {
            return $user->userHasLevel?->level->name === Level::ANGGOTA_AUDITOR;
        });
        Gate::define("auditee", function ($user) {
            return $user->userHasLevel?->level->name === Level::AUDITEE;
        });
        Gate::define("jurusan", function ($user) {
            return $user->userHasLevel?->level->name === Level::JURUSAN;
        });
    }
}
