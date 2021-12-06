<?php

namespace Kurhades\Thumbr;

use Config;
use Illuminate\Support\Facades\Storage;

class Thumbr {
    
    private static function ValidateConfig() {
        if(Config::get('thumbr.folder_name') == null) {
            throw new \Exception('thumbr : We need to run `php artisan vendor:publish --provider="Kurhades\Thumbr\ThumbrServiceProvider"` in order to get started with Thumbr. If you already have run this command, make sure you have configured the thumbr.php from config folder.');
        }
        
        if(Config::get('thumbr.disk') == null) {
            throw new \Exception('thumbr : Please configure `disk` variable in thumbr.php under config folder.');
        }
        
        if(!Storage::disk(Config::get('thumbr.disk'))->exists(Config::get('thumbr.folder_name'))) {
            throw new \Exception('thumbr : It seems `' . Config::get('thumbr.folder_name') .'` folder is not accessible by thumbr package.');
        }
        
        
    }
    
    private static function ValidateInputs($fileWithPath, $newFileName, $width, $height) {
        
        if (Storage::disk(Config::get('thumbr.disk'))->exists($fileWithPath)) {
            throw new \Exception('thumbr : Not able to locate the file.');
        }
        
        if (!is_numeric($width)){
            throw new \Exception('thumbr : `width` parameter accepts only numbers.');
        }
        
        if ($newFileName == null){
            throw new \Exception('thumbr : `fileName` parameter accepts string. It will be great we can we specify extension.');
        }
        
        if (!is_numeric($height) || $height != true){
            throw new \Exception('thumbr : `height` parameter accepts either numbers or bool `true`.');
        }
    }
    
    public static function CreateThumb($fileWithPath, $newFileName, $width, $height = true) {
        
        self::ValidateConfig();
        self::ValidateInputs($fileWithPath, $newFileName, $width, $height);
        
        $destinationFolderName = Config::get('thumbr.folder_name');
        $disk = Config::get('thumbr.disk');
        $urlImage = Config::get('thumbr.is_image_url');
        $finalPath = $destinationFolderName . '/' . $width . '/';
        
        if(Storage::disk($disk)->exists($finalPath . $newFileName)) {
            return Storage::disk($disk)->url($finalPath . $newFileName);
        }
        
        if($urlImage === false) {
            $file = Storage::disk($disk)->get($fileWithPath);
        } else {
            $file = file_get_contents($fileWithPath);
        }
        
        ob_start();
        $image = imagecreatefromstring($file);
        $height = $height === true ? (imagesy($image) * $width / imagesx($image)) : $height;
        $output = imagecreatetruecolor($width, $height);
        imagecopyresampled($output, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
        imagejpeg($output);
        $imageContents = ob_get_clean();
        ob_end_clean();
        
        Storage::disk($disk)->makeDirectory($finalPath);
        Storage::disk($disk)->put($finalPath . $newFileName, $imageContents);
        return Storage::disk($disk)->url($finalPath . $newFileName);
    }
    
}