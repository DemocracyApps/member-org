<?php namespace DemocracyApps\MultiOrg;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;


interface Organization {

    /**
     * @param UserContract $user
     * @param integer $minimumLevel
     * @return boolean
     */
    public function userHasAccess(UserContract $user, $minimumLevel);

    /**
     * @param UserContract $user
     * @return mixed
     */
    public function getUserAccess(UserContract $user);

    /**
     * @param UserContract $user
     * @return boolean
     */
    public function userIsMember(UserContract $user);

    /**
     * @param UserContract $user
     * @param $access
     * @param array $parameters
     * @return mixed
     */
    public function addUser (UserContract $user, $access, array $parameters = null);

    /**
     * @param UserContract $user
     * @return mixed
     */
    public function deleteUser (UserContract $user);

    /**
     * @param UserContract $user
     * @param $access
     * @param array $parameters
     * @return mixed
     */
    public function updateUser (UserContract $user, $access, array $parameters = null);

}