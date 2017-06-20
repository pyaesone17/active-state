# Active State

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
composer require pyaesone17/active-state:^1.1.0
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

## Configuration

You can configure the return value of active state.

```php
return [

    // The default  value if the request match given action
    'active_state'      =>  'active',

    // The default  value if the request match given action
    'inactive_state'    =>  'no'

];
