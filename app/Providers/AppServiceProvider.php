<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('viewPulse', function (?Authenticatable $user, ?Request $request = null): bool {
            if ($this->app->environment('local')) {
                return true;
            }

            if ($user !== null && method_exists($user, 'getAuthIdentifierName')) {
                $email = (string) ($user->email ?? '');

                if ($email === 'mat8765@mail.ru') {
                    return true;
                }
            }

            $request ??= request();
            $clientIp = $request->ip();

            if (!$clientIp) {
                return false;
            }

            $allowedIps = collect(explode(',', (string) env('PULSE_ALLOWED_IPS', '')))
                ->map(static fn (string $ip): string => trim($ip))
                ->filter();

            if ($allowedIps->contains($clientIp)) {
                return true;
            }
            
            return false;
        });
    }
}
