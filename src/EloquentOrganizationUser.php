<?php namespace DemocracyApps\MultiOrg;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;

/*
 * EloquentOrganization implements the Organization interface when the org is an Eloquent model
 */
trait EloquentOrganizationUser
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