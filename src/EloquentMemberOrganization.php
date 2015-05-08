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
// EloquentMemberOrganization implements the MemberOrganization interface when the org is an Eloquent model
//

trait EloquentMemberOrganization
{

    private function getOrgMemberClass()
    {
        $suffix = "User";
        if (config('member-org.member_class_suffix')) $suffix = config('member-org.member_class_suffix');
        $orgMemberClassName = get_class($this) . $suffix;
        return new \ReflectionClass($orgMemberClassName);
    }

    private function getOrgIdName()
    {
        $c = new \ReflectionClass(get_class($this));
        return snake_case($c->getShortName()) . '_id';
    }

    /**
     * @param UserContract $user
     * @return OrganizationMember
     */
    public function getOrganizationMember (UserContract $user)
    {
        $memberClass = $this->getOrgMemberClass();
        $queryMethod = $memberClass->getMethod('query');
        $builder = $queryMethod->invoke(null);
        $member = $builder->where('user_id', '=', $user->getAuthIdentifier())->first();
        return $member;
    }

    /**
     * @param UserContract $user
     * @param integer $minimumRequired
     * @return bool
     */
    public function userHasAccess(UserContract $user, $minimumRequired)
    {
        /*
         * If user is configured with a superuser flag, see if they are
         * a superuser.
         */
        if (config('member-org.user_implements_superuser')) {
            if ($user->{config('member-org.user_superuser_column')}) return true;
        }

        /*
         * If users are required to confirm their accounts, check that they
         * are confirmed or that we're below the threshold that requires it
         */
        if (config('member-org.user_implements_confirmation')) {
            if ($minimumRequired > config('member.user_confirmation_required_threshold')) {
                if (!($user->{config('member-org.user_confirmation_column')})) return false;
            }
        }

        $member = $this->getOrganizationMember($user);
        if ($member != null) {
            if ($member->access >= $minimumRequired) return true;
        }
        return false;
    }

    // MAYBE DIAGNOSE NON-ACCESS?????


    /**
     * @param UserContract $user
     * @return integer
     */
    public function getUserAccess(UserContract $user)
    {
        $access = -1;
        $member = $this->getOrganizationMember($user);
        if ($member != null) $access = $member->access;
        return $access;
    }

    /**
     * @param UserContract $user
     * @return boolean
     */
    public function userIsMember(UserContract $user)
    {
        $member = $this->getOrganizationMember($user);
        if ($member != null) return true;
        return false;
    }

    /**
     * @param UserContract $user
     * @param integer $access
     * @return OrganizationUser
     * @throws \Exception
     */
    public function addMember(UserContract $user, $access)
    {
        if ($this->userIsMember($user)) throw new \Exception ("User already added as a member");
        $memberClass = $this->getOrgMemberClass();
        $member = $memberClass->newInstance();
        $member->user_id = $user->getAuthIdentifier();
        $orgIdName = $this->getOrgIdName();
        $member->{$orgIdName} = $this->id;
        $maxPermission = config('member-org.max_permission_level');
        if ($maxPermission == null) $maxPermission = 9;
        if ($access > $maxPermission) $access = $maxPermission;
        $member->access = $access;
        $member->save();
        return $member;
    }


    /**
     * @param UserContract $user
     * @return void
     * @throws \Exception
     */
    public function deleteMember(UserContract $user)
    {
        $member = $this->getOrganizationMember($user);
        if ($member == null) throw new \Exception("User is not a member of the organization");
        $member->delete();
    }

    /**
     * @param UserContract $user
     * @param $access
     * @return void
     * @throws \Exception
     */
    public function updateMember(UserContract $user, $access)
    {
        $member = $this->getOrganizationMember($user);
        if ($member == null) throw new \Exception("User is not a member of the organization");
        $maxPermission = config('member-org.max_permission_level');
        if ($maxPermission == null) $maxPermission = 9;
        if ($access > $maxPermission) $access = $maxPermission;
        $member->access = $access;
    }
}