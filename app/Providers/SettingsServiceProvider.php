<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (!app()->runningInConsole()) {
            if (\Request::getHost() == config("system.volunteerwakefield_url")) {
                $settings = Cache::rememberForever(
                    "settings_volunteer-wakefield",
                    function () {
                        $settings = \App\Models\Setting::where(
                            "slug",
                            "volunteer-wakefield"
                        )->first();
                        return $settings ? $settings->toArray() : [];
                    }
                );
            } else {
                $settings = Cache::rememberForever(
                    "settings_community-wakefield",
                    function () {
                        $settings = \App\Models\Setting::where(
                            "slug",
                            "community-wakefield"
                        )->first();
                        return $settings ? $settings->toArray() : [];
                    }
                );
            }

            config()->set("settings", $settings);
        }
    }
}
