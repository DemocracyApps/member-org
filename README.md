# multi-org
Laravel application support for multiple org types, each with own users with multiple permission levels. Organization 
and OrganizationMember present an interface, while EloquentOrganization and EloquentOrganizationMember are traits that provide 
a full implementation when added to an Eloquent model.


## Installation

Begin by installing this package through Composer.

    {
        "require": {
            "democracyapps/multi-org": "dev-master"
        }
    }

Add the service provider to app.php


    // app/config/app.php
    
    'providers' => [
        '...',
        'DemocracyApps\MultiOrg\MultiOrgServiceProvider',
    ];

