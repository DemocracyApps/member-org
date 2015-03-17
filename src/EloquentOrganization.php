<?php namespace DemocracyApps\MultiOrg;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;

/*
 * EloquentOrganization implements the Organization interface when the org is an Eloquent model
 */
trait EloquentOrganization implements Organization
{

    private function getOrgMemberClass()
    {
        $orgMemberClassName = get_class($this) . "User";
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
        $hasAccess = false;
        $member = $this->getOrganizationMember($user);
        if ($member != null) {
            if ($member->access >= $minimumRequired) $hasAccess = true;
        }
        return $hasAccess;
    }

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
        $member->access = $access;
    }
}