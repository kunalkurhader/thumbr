# thumbr
This is laravel package where you can create image thumbnail on the fly and reuse it.


## Installation

Install thumbr with composer

```bash
composer require kunalkurhader/thumbr
```
To copy the config file, lets publish with following command

```bash
php artisan vendor:publish --provider="Kurhades\Thumbr\ThumbrServiceProvider"
```

## Configuration options
Configuration file will be located under config folder

```php
<?php

return [
    //folder name where we will be storing thumbs images inside storage/app/public
    'folder_name' => 'thumbs',
    //mention the disk where we will be storing the file Ex : Storage, s3, azure etc
    'disk' => 'public',
    //if we are loading image from url local, s3, azure etc then its `true` else `false`
    'is_image_url' => false,
];
```

## How to use?

```php
//in controller
use Kurhades\Thumbr\Thumbr;
```

```php
//in blade file in case we are loading file from URL
/*
* Parameters : 
* 1. source Image (with path or URL)
* 2. thumb image name Image
* 3. width of the image
* 4. height of the image
*/

<img src="{{Thumbr::CreateThumb("https://DOMAINURL/image.jpg", "ocean23.jpeg", 100, 80)}}">

//in blade file in case we are loading file from storage
<img src="{{Thumbr::CreateThumb("folder/path/ocean.jpeg", "ocean23.jpeg", 100, 80)}}">
```