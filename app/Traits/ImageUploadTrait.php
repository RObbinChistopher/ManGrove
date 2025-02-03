<?php

namespace App\Traits;

use Illuminate\Http\Request;
use File;

trait ImageUploadTrait
{
    public function Uploadimage(Request $request, $input_name, $path)
    {
        if ($request->hasFile($input_name)) {
            $image = $request->{$input_name};
            $ext = $image->getClientOriginalExtension();
            $image_name = 'media_' . uniqid() . '.' . $ext;
            $image->move(public_path($path), $image_name);

            return $path . '/' . $image_name;
        }
    }
    public function UploadMulitpleimage(Request $request, $input_name, $path)
    {

        $ImagesPath = [];
        if ($request->hasFile($input_name)) {
            $images = $request->{$input_name};

            foreach ($images  as $image) {
                $ext = $image->getClientOriginalExtension();
                $image_name = 'media_' . uniqid() . '.' . $ext;
                $image->move(public_path($path), $image_name);

                $ImagesPath[] = $path . '/' . $image_name;
            }

            return $ImagesPath;
        }
    }

    public function Updateimage(Request $request, $input_name, $path, $oldpath = null)
    {
        if ($request->hasFile($input_name)) {
            // Delete old image if exists
            if ($oldpath && File::exists(public_path($oldpath))) {
                File::delete(public_path($oldpath));
            }

            // Store new image
            $image = $request->file($input_name);
            $ext = $image->getClientOriginalExtension();
            $image_name = 'media_' . uniqid() . '.' . $ext;
            $image->move(public_path($path), $image_name);

            return $path . '/' . $image_name;
        }

        // Return old path if no new file is uploaded
        return $oldpath;
    }
    // delete exists file 

    public function deleteupload($path)
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
