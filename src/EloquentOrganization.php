<?php namespace DemocracyApps\MultiOrg;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;

/*
 * EloquentOrganization implements the Organization interface when the org is an Eloquent model
 */
trait EloquentOrganization
{

    private function getOrgUserClass()
    {
        $orgUserClassName = get_class($this) . "User";
        return new \ReflectionClass($orgUserClassName);
    }

    private function getOrgIdName()
    {
        $c = new \ReflectionClass(get_class($this));
        return snake_case($c->getShortName()) . '_id';
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
//        $userObject = $userClass->newInstance();
//        dd($userObject);
//        $modelClass = get_class($userObject);
//        dd($modelClass);
    /**
     * @param UserContract $user
     * @return boolean
     */
    public function userIsMember(UserContract $user)
    {
        $userClass = $this->getOrgUserClass();

        $queryMethod = $userClass->getMethod('query');
        $builder = $queryMethod->invoke(null);
        $user = $builder->where('user_id', '=', $user->getAuthIdentifier())->first();
        if ($user != null) return true;
        return false;
    }

    /**
     * @param UserContract $user
     * @param $access
     * @param array $parameters
     * @return mixed
     * @throws Exception
     */
    public function addUser(UserContract $user, $access, array $parameters = null)
    {
        if ($this->userIsMember($user)) throw new \Exception ("User already added");
        $userClass = $this->getOrgUserClass();
        $orgUser = $userClass->newInstance();
        $orgUser->user_id = $user->getAuthIdentifier();
        $orgIdName = $this->getOrgIdName();
        $orgUser->{$orgIdName} = $this->id;
        $orgUser->access = $access;
        $orgUser->save();
        return $orgUser;
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