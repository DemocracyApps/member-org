<?php namespace DemocracyApps\MemberOrg;

/*
* This file is part of the DemocracyApps\member-org package.
*
* Copyright 2015 DemocracyApps, Inc.
*
* See the LICENSE.txt file distributed with this source code for full copyright and license information.
*
*/

class Version {
    const version = "1.0.0";

    public static function getVersion()
    {
        return self::version;
    }
}