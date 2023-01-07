<?php

namespace App\Helpers;


use Illuminate\Support\Facades\File;

class ImageUploadHelper
{
    public static function imageUpload($files)
    {
        $image_path = 'uploads/' . date('Y') . '/' . date('m');

        if(!File::exists(public_path() . "/" . $image_path)){
            File::makeDirectory(public_path() . "/" . $image_path, 0777, true);
        }

        $extension = $files->getClientOriginalExtension();
        $destination_path = public_path() . '/' . $image_path;
        $file_name = uniqid() . '.' . $extension;
        $files->move($destination_path, $file_name);

        return $image_path . '/' . $file_name;
    }

}
