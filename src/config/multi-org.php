<?php

return [

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
    | Additional Permission Factors
    |--------------------------------------------------------------------------
    |
    */

    'user_implements_superuser' => true,
    'user_superuser_column' => 'superuser',
    'user_implements_confirmation' => false,
    'user_confirmation_column' => 'confirmed',
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