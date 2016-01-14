#Active State
Simple Laravel Active Checker For Request Url

#Installation
To install Package
```
composer require pyaesone17/active-state
```

To publish configuration file
```
php artisan vendor:publish
```

#Usage
It will check against  whether your request is `www.url.com/data`
If the request match this url . It will return the default value from config file.
```php
{{ \Active::check('data') }} 
```
Exact Check
```php
{{ \Active::check('data') }} // check request is www.url.com/data
```

If you want to check the url deeply , just pass the `true` value as second parameter.
```php
{{ \Active::check('data',true) }}  // check request is www.url.com/data || www.url.com/data/*
```



