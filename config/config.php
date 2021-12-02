<?php

return [
    //folder name where we will be storing thumbs images inside storage/app/public
    'folder_name' => 'thumbs',
    //mention the disk where we will be storing the file Ex : local, s3, azure etc
    'disk' => 'local',
    //if we are loading image from url local, s3, azure etc
    'is_image_url' => false,
];