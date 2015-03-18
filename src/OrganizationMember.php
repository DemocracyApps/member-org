<?php namespace DemocracyApps\MultiOrg;
/*
* This file is part of the DemocracyApps\multi-org package.
*
* Copyright DemocracyApps, Inc.
*
* See the LICENSE.txt file distributed with this source code for full copyright and license information.
*
*/

use Illuminate\Contracts\Auth\Authenticatable as UserContract;


interface OrganizationMember
{
    /**
     * @return mixed
     */
    public function user();

    /**
     * @return mixed
     */
    public function organization();

    /**
     * @return integer
     */
    public function access();

    /**
     * @param integer $level
     * @return boolean
     */
    public function hasAccess($level);
}