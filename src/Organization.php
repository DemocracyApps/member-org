<?php namespace DemocracyApps\MultiOrg;
/*
* This file is part of the DemocracyApps\multi-org package.
*
* Copyright 2015 DemocracyApps, Inc.
*
* See the LICENSE.txt file distributed with this source code for full copyright and license information.
*
*/

use Illuminate\Contracts\Auth\Authenticatable as UserContract;


interface Organization {

    /**
     * @param UserContract $user
     * @return OrganizationMember
     */
    public function getOrganizationMember (UserContract $user);

    /**
     * @param UserContract $user
     * @param integer $minimumRequired
     * @return bool
     */
    public function userHasAccess(UserContract $user, $minimumRequired);

    /**
     * @param UserContract $user
     * @return integer
     */
    public function getUserAccess(UserContract $user);

    /**
     * @param UserContract $user
     * @return boolean
     */
    public function userIsMember(UserContract $user);

    /**
     * @param UserContract $user
     * @param integer $access
     * @return OrganizationUser
     * @throws \Exception
     */
    public function addMember(UserContract $user, $access);

    /**
     * @param UserContract $user
     * @return void
     * @throws \Exception
     */
    public function deleteMember(UserContract $user);

    /**
     * @param UserContract $user
     * @param $access
     * @return void
     * @throws \Exception
     */
    public function updateMember(UserContract $user, $access);
}