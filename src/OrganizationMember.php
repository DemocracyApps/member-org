<?php namespace DemocracyApps\MultiOrg;

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