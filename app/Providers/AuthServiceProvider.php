<?php
namespace App\Providers;

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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate untuk view: hanya pemilik data atau admin
        Gate::define('view', function ($user, $model) {
            return $user->id === $model->user_id || $user->is_admin;
        });

        // Gate untuk update: hanya pemilik data atau admin
        Gate::define('update', function ($user, $model) {
            return $user->id === $model->user_id || $user->is_admin;
        });

        // Gate untuk delete: hanya pemilik data atau admin
        Gate::define('delete', function ($user, $model) {
            return $user->id === $model->user_id || $user->is_admin;
        });

        //Gate untuk manage calculations: hanya admin
        Gate::define('manage-calculations', function ($user) {
            return $user->hasRole('admin');
        });
    }
}