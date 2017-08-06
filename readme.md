# Active State

[![Total Downloads](https://poser.pugx.org/pyaesone17/active-state/downloads)](https://packagist.org/packages/pyaesone17/active-state)
[![License](https://poser.pugx.org/pyaesone17/active-state/license)](https://packagist.org/packages/pyaesone17/active-state)
[![Latest Stable Version](https://poser.pugx.org/pyaesone17/active-state/v/stable)](https://packagist.org/packages/pyaesone17/active-state)
[![Monthly Downloads](https://poser.pugx.org/pyaesone17/active-state/d/monthly)](https://packagist.org/packages/pyaesone17/active-state)

> Simple Laravel Active Checker For Request Url

Sometimes you want to check the request url is active or not For the following purpose.
Especially for backend sidebar.

![Bilby Stampede](http://s22.postimg.org/acwm89mf5/Selection_011.png)

Basically we do like this.
```blade
<li class="sidebar {{ Request::is('post') ? 'active' : 'no' }} ">Post</li>
<li class="sidebar {{ Request::is('page') ? 'active' : 'no' }} ">Page</li>
```
It would be nice if we can make shorter. right ?
```blade
<li class="sidebar {{ active_check('post') }} ">Post</li>
<li class="sidebar {{ active_check('page') }} ">Page</li>
```

## Installation
Install with `composer`:

Laravel 5.4 and above
```
composer require pyaesone17/active-state:^1.1.1
```
Laravel 5.3 and below
```
composer require pyaesone17/active-state:^0.0.2
```

And add the service provider in `config/app.php`
```php
'providers' => [
    ........,
    Pyaesone17\ActiveState\ActiveStateServiceProvider::class,
]
```

If you want to use the facade, add this to your facades in `config/app.php`

```php
'aliases' => [
    ........,
    'Active' => Pyaesone17\ActiveState\ActiveFacade::class,
]

```
To publish configuration file
```
php artisan vendor:publish --provider="Pyaesone17\ActiveState\ActiveStateServiceProvider"
```

## Usage

It will check against  whether your request is `www.url.com/data`
If the request match this url . It will return the default value from config file.
The default value for true state is `"active"` and false is `"no"`. You can configure on active.php .

```blade
{{ Active::check('data') }} 
```
To check the exact url.
```blade
{{ Active::check('data') }} // check request is www.url.com/data
```

To check the url deeply , just pass the `true` value as second parameter.
```blade
{{ Active::check('data',true) }}  // check request is www.url.com/data || www.url.com/data/*
```
OR
```blade
{{ Active::check(['data','post','categories']) }}  // check request is www.url.com/data || www.url.com/post || www.url.com/categories
```
```blade
{{ Active::check(['data','post','categories'],true) }} // check request is www.url.com/data/* || // check request is www.url.com/post/* || www.url.com/categories/*
```

To change the return value in runtime, just pass the the third and fourth parameter.

```blade
{{ Active::check('data',true,'truth','fake') }} // it will override the value from config file.
```
Or you can even use helper function.
```blade
{{ active_check('data') }}
```
You can also use this package for conditional displaying data.
In some case, You need to render some part of template depends on request.

```blade
@ifActiveUrl('data')
    <p>Foo</p>
@else
    <p>Bar and Bazz</p>
@endIfActiveUrl

```

## Advance Usage and Above version 1.1.1

To check the route name is.
```blade
{{ Active::checkRoute('users.index') }} // check request url route name is "users.index"
```

OR
```blade
{{ Active::checkRoute(['users.index','users.show', 'users.edit']) }} // check request url route name is "users.index" or "users.show" or "users.edit"
```

Sometimes passing multiple routename as parameters is cubersome. You can simple do like this
```blade
{{ Active::checkRoute('users.*') }} 
```

Ofcousre you may change the return value in runtime as second and third params.
```blade
{{ Active::checkRoute('users.index','routeIsActive','routeNotActive') }} 
```
OR
```blade
{{ Active::checkRoute(['users.index','users.show'],'routeIsActive','routeNotActive') }} 
```

For helper function.
```blade
{{ active_route('users.comments.*') }} 
```

Yes it is also avaialable in blade.

```blade
@ifActiveRoute('users.index')
    <p>Foo</p>
@else
    <p>Bar and Bazz</p>
@endIfActiveRoute

```

To check the url with the exact same query paramter value.
```blade
{{ Active::checkQuery('users?gender=male') }} // check request is www.url.com/users?gender=male
```
OR
```blade
{{ Active::checkQuery(['users?gender=male','users?status=married']) }} // check request is www.url.com/users?gender=male or www.url.com/users?status=married
```

Ofcousre you may change the return value in runtime as second and third params.
```blade
{{ Active::checkQuery(['users?gender=male','itIsMale','Ah it is wonder woman') }} 
```
OR
```blade
{{ Active::checkQuery(['users?gender=male','users?status=married'],'male or married','nothing') }} 
```

For helper function.
```blade
{{ active_query('users?gender=male') }} 
```

Yes it is also avaialable in blade.

```blade
@ifActiveQuery(['users?gender=male','users?status=married'])
    <p>Foo</p>
@else
    <p>Bar and Bazz</p>
@endIfActiveQuery
```
## Notes
Everytime u update package, you have to run "php artisan view:clear" for blade directives.

## Configuration

You can configure the return value of active state.

```php
return [

    // The default  value if the request match given action
    'active_state'      =>  'active',

    // The default  value if the request match given action
    'inactive_state'    =>  'no'

];
