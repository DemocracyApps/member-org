<?php namespace DemocracyApps\MemberOrg;
/*
* This file is part of the DemocracyApps\member-org package.
*
* Copyright 2015 DemocracyApps, Inc.
*
* See the LICENSE.txt file distributed with this source code for full copyright and license information.
*
*/

use Illuminate\Contracts\Auth\Authenticatable as UserContract;

//
// EloquentOrganizationMember implements the OrganizationMember interface when the org and user are Eloquent model
//
trait EloquentOrganizationMember
{

    /**
     * @return mixed
     */
    public function user()
    {
        // TODO: Implement user() method.
    }

    /**
     * @return mixed
     */
    public function organization()
    {
        // TODO: Implement organization() method.
    }

    /**
     * @return integer
     */
    public function access()
    {
        // TODO: Implement access() method.
    }

    /**
     * @param integer $level
     * @return boolean
     */
    public function hasAccess($level)
    {
        // TODO: Implement hasAccess() method.
    }
}