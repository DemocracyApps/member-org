<?php namespace DemocracyApps\MultiOrg;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;

/*
 * EloquentOrganization implements the Organization interface when the org is an Eloquent model
 */
trait EloquentOrganization
{
    private $orgUserClassName = null;
    private $orgUserTableName = null;

    private function getOrgUserClassName()
    {
        if ($this->orgUserClassName == null) {
            $orgClass = $this->get_class();
            $this->orgUserClassName = $orgClass . "User";
            $this->orgUserTableName = snake_case($this->orgUserClassName);
        }
        return $this->orgUserClassName;
    }

    private function getOrgUserClass()
    {
        return new \ReflectionClass($this->getOrgUserClassName());
    }

    private function getOrgUserTableName() {
        if ($this->orgUserTableName == null) $this->getOrgUserClassName();
        return $this->orgUserTableName;
    }

    public function hasAccess(User $user, $minimumRequired)
    {

    }

    /**
     * @param UserContract $user
     * @param integer $minimumLevel
     * @return boolean
     */
    public function userHasAccess(UserContract $user, $minimumLevel)
    {
        // TODO: Implement userHasAccess() method.
    }

    /**
     * @param UserContract $user
     * @return mixed
     */
    public function getUserAccess(UserContract $user)
    {
        // TODO: Implement getUserAccess() method.
    }

    /**
     * @param UserContract $user
     * @return boolean
     */
    public function userIsMember(UserContract $user)
    {
        // TODO: Implement userIsMember() method.
    }

    /**
     * @param UserContract $user
     * @param $access
     * @param array $parameters
     * @return mixed
     */
    public function addUser(UserContract $user, $access, array $parameters = null)
    {
        // TODO: Implement addUser() method.
        $userClass = $this->getOrgUserClass();
        $orgUser = $userClass->newInstance();
        $orgUser->user_id = $user->getAuthIdentifier();
        $orgUser->org_id = $this->id;
        $orgUser->access = $access;
        $orgUser->save();
    }

    /**
     * @param UserContract $user
     * @return mixed
     */
    public function deleteUser(UserContract $user)
    {
        // TODO: Implement deleteUser() method.
    }

    /**
     * @param UserContract $user
     * @param $access
     * @param array $parameters
     * @return mixed
     */
    public function updateUser(UserContract $user, $access, array $parameters = null)
    {
        // TODO: Implement updateUser() method.
    }
}