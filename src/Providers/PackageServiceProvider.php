<?php namespace DemocracyApps\MultiOrg\Providers;

/*
* This file is part of the DemocracyApps\multi-org package.
*
* Copyright DemocracyApps, Inc.
*
* See the LICENSE.txt file distributed with this source code for full copyright and license information.
*
*/

use DemocracyApps\MultiOrg\MultiOrgManager;
use Illuminate\Support\ServiceProvider;

class MultiOrgServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('DemocracyApps\MultiOrg\MultiOrgManager', function ($app) {
           return new MultiOrgManager();
        });
    }
    
        /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
