<?php

return [

    /*
    |--------------------------------------------------------------------------
    | List of Classes Representing Different Organization Types
    |--------------------------------------------------------------------------
    |
    | This value is an array containing the names of all organization classes
    | (i.e., that implement the DemocracyApps\MultiOrg\Organization interface.
    | By default, we assume a single class called Organization
    |
    */
    'organization_classes' => ['Organization'],

    /*
    |--------------------------------------------------------------------------
    | Permission Levels
    |--------------------------------------------------------------------------
    |
    | Each organization user is assigned a permission level (by default, 0-9)
    | that may be used to control access to data or actions. Access is strictly
    | increasing. A resource or action requiring level 5 is accessible to any user
    | with access level 5 or higher.
    |
    */
    'permission_levels' => 9,

    /*
    |--------------------------------------------------------------------------
    | User Table Name
    |--------------------------------------------------------------------------
    |
    | We assume a joining table linking users to organizations. This is the name
    | of the users table.
    */
    'user_table_name' => 'users'

];