# member-org
Laravel application support for multiple org types, each with own users with multiple permission levels. Organization 
and OrganizationMember present an interface, while EloquentMemberOrganization and EloquentOrganizationMember are traits that provide 
a full implementation when added to an Eloquent model.

The package is quite simple. It's most useful when a platform must support multiple types of organizations and organization members at the same time.


## Instructions For Use

### Installation

Begin by installing this package through Composer.

```json
{
    "require": {
        "democracyapps/member-org": "dev-master"
    }
}
```

Add the service provider to app.php

```php
    // app/config/app.php
    
    'providers' => [
        '...',
        'DemocracyApps\MemberOrg\MemberOrganizationServiceProvider',
    ];
```

(note that the service provider is currently only needed if you wish to publish the configuration file in order to change the defaults.

The only requirement right now is that the user class obey Laravel's Authenticable contract. 

Note that the EloquentOrganizationMember train only has stubs for the OrganizationMember 
interface (unlike EloquentMemberOrganization). I am holding off until I better understand requirements for it (if any).

### Applying to an Organization

Let's assume that you have a *Company* class to which you wish to apply this package and that *Company* is a subclass of Eloquent Model:

```php
    class Company extends Model
    {
     ...
    }
```
    
Change the class to implement the Organization interface and make use of the EloquentOrganization trait:

```php
    use DemocracyApps\MemberOrg\EloquentMemberOrganization;
    use DemocracyApps\MemberOrg\Organization;

    class Company implements MemberOrganization
    {
        use EloquentMemberOrganization;
        ...
    }
```
    
In addition, create a *CompanyMember* class (NOTE: the 'Member' part of the name is required. An option in the configuration file will
allow it to be set to something different.):

```php
    use DemocracyApps\MemberOrg\EloquentOrganizationMember;
    use DemocracyApps\MemberOrg\OrganizationMember;

    class CompanyMember implements OrganizationMember
    {
        use EloquentOrganizationMember;
        ...
    }
```

and create a migration for it. It is required to have three columns:

```
    user_id (foreign key referring to the 'id' column of your users table)
    company_id (foreign key referring to the 'id' column of your companies table)
    access (an integer)
```

None of the columns may be null. Note that the second column must be named with the snake_case version of your organization class with '_id" appended.

### Configuration Parameters

There are three main parameters and a few auxiliary ones. If you wish to change the defaults, add the service provider, run

    php artisan vendor:publish

and edit 'config/member-org.php'.

#### max_permission_level (default: 9)

Permissions are simple - each organization member is assigned an access level between 0 and *max_permission_level*. 
Pages and resources in your application can be assigned required access levels and users with access below the
required level will fail the userHasAccess test. 
 
I typically begin by assigning only two levels, 0 for no privileges and 9 for administrators, leaving
intermediate values available for later use.

#### user_implements_superuser (default: false)

If set to true, the package expects the user table to contain a boolean column which, if true, makes the user a "superuser" who
always has access to any resource or page. By default, the column name is assumed to be 'superuser', but this can be changed 
in the configuration file.

#### user_implements_confirmation (default: false)

If set to true, the package expects that the application requires users to verify their accounts in some way and that they should
not gain full privileges until they do. Their status should be indicated in a boolean column in the user table (by default the
column name is assumed to be 'confirmed', but this can be changed in the configuration file). 

The *user_confirmation_required_threshold* (default:0) specifies the maximum privilege level they may have before verifying their
accounts. Thus, a full administrator (access=9) would remain restricted to access level 0 by default until verification is completed.

### Basic Use

So far I am making use of the package in two simple ways. First, I use the Organization's *addMember* method to create
organization users (this creates the entry in the database). Second, I use the Organization's *userHasAccess* method
in route middleware to restrict access to organization pages (generally admin pages).

Here is a concrete example of a middleware class for company admin pages. In the route, the company ID is in the 2nd route segment.

```php
    class VerifyCompanyAccess {
    
    	/**
    	 * Check that user is logged in and allowed access to this page
    	 *
    	 * @param  \Illuminate\Http\Request  $request
    	 * @param  \Closure  $next
    	 * @return mixed
    	 */
    	public function handle($request, Closure $next)
    	{
            if (\Auth::guest()) return redirect()->guest('/auth/login');
    
            $id = $request->segment(2);
            $company = Company::find($id);
    
            if ($company == null) {
                return redirect('/');
            }
    
            if (! $company->userHasAccess(\Auth::user(), 9)) {
                return redirect('/');
            }
    
    		return $next($request);
    	}
    
    }
```

## Problems and Plans
 
This module is being used for a couple products in active development and will probably evolve. If you find bugs or have
requests for features, create an issue here, find me on Twitter (@ejaxon) or submit a pull request.

