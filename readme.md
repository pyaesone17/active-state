#Active State
Simple Laravel Active Checker For Request Url

Sometimes you want to check the request url is active or not For the following purpose.
Especially for backend sidebar.

![Bilby Stampede](http://s22.postimg.org/acwm89mf5/Selection_011.png)

Basically we do like this.

```html
<li class="sidebar {{ Request::is('post') ? 'active' : 'no' }} ">Post</li>
<li class="sidebar {{ Request::is('page') ? 'active' : 'no' }} ">Page</li>
```
It would be nice if we can make shorter. right ?
```html
<li class="sidebar {{ Active::check('post') }} ">Post</li>
<li class="sidebar {{ Active::check('page') }} ">Post</li>
```

#Installation
To install Package
```
composer require pyaesone17/active-state
```

To publish configuration file
```
php artisan vendor:publish
```

Register Service Provider

```
	[
	  	......,
      	Pyaesone17\ActiveState\ActiveStateServiceProvider::class,

    ],
```
```
Register Facade alias
	[	
		........,
		'Active' => Pyaesone17\ActiveState\ActiveFacade::class,

	]
```
#Usage1

It will check against  whether your request is `www.url.com/data`
If the request match this url . It will return the default value from config file.
The default value for true state is `"active"` and false is `"no"`. You can configure on active.php .
```php
{{ Active::check('data') }} 
```
To check the exact url.
```php
{{ Active::check('data') }} // check request is www.url.com/data
```

To check the url deeply , just pass the `true` value as second parameter.
```php
{{ Active::check('data',true) }}  // check request is www.url.com/data || www.url.com/data/*
```

To change the return value in runtime, just pass the the third and fourth parameter.

```php
{{ Active::check('data',true,'truth','fake') }} // it will override the value from config file.
```
Or you can even use helper function.
```
{{ active_check('data') }}
```

#Usage2
You can even use this package for conditional displaying data.
In some case, You need to render some part of template depends on request.

```php

@ifActiveUrl('data')

	<p>Foo</p>

@else
	
	<p>Bar</p>

@endIfActiveUrl

```

#Config

You can configure the return value of active state.

```php

return [

	// The default  value if the request match given action
	'active_state'		=>	'active',
	
	// The default  value if the request match given action
	'inactive_state'	=>	'no'

];
