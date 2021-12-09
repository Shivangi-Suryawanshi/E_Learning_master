<?php
if (!function_exists('getImageByPath')) {

    function getImageByPath($db_path, $dimension, $given_path)
    {
        if ($db_path)
            $file_path = pathinfo($db_path);
        else
            return null;
        $output = "";
        $dir_name = $file_path['dirname'];
        $base_name = $file_path['basename'];
        $extension = $file_path['extension'];
        $file_name = $file_path['filename'];
        $image_sizes = Config::get('constants.image_sizes');
        $key_exist = array_key_exists($dimension, $image_sizes);

        if ($key_exist) {
            $size = $image_sizes[$dimension];
            $width = $size[0];
            $height = $size[1];
            $allowed = true;
        } else {
            $allowed = false;
        }
        if ($allowed) {

            $destination_img_name = $dir_name . '/' . $file_name . '-' . $width . 'x' . $height . '.' . $extension;
            $output = url('media') . '/' . $given_path . '/' . $destination_img_name;
            $path = url('media/'.$given_path);
            $path_dir = public_path('media/');

            $ful_path = $path . '/' . $destination_img_name;
            $month = date("n");
            $year = date("Y");

            if (!is_dir($path_dir . $year . '/' . $month)) {
                mkdir($path_dir . $year . '/' . $month, 0775, true);
            }
            $check_exist = public_path('media/'.$given_path.'/'.$destination_img_name);
            if (file_exists($check_exist)) {

                $output = $ful_path;
            } else {
                $destination_img_name = $dir_name . '/' . $file_name . '-' . $width . 'x' . $height . '.' . $extension;
                $destination_path = public_path('media/' . $given_path . "/" . $destination_img_name);
                $original_path = url('media/' . $given_path) . '/' . $db_path;
                $tempOrginal_path = public_path("media/" . "$given_path" . "/") . $dir_name . '/' . $file_name . '.' . $extension;

                if (file_exists($tempOrginal_path)) {
//                    dd('here');
                    img_resize($original_path, $destination_path, $width, $height, $extension);
                    $output = url('media') . '/' . $given_path . '/' . $destination_img_name;


                } else {
                    $output = url('media') . '/' . $given_path . '/' . $destination_img_name;

                }
            }
        } else {
            $output = url('media') . '/' . $given_path . '/' . $db_path;
        }
        return ($output);
    }

}
if (!function_exists('getImageByPathOnly')) {

    function getImageByPathOnly($db_path, $dimension, $given_path)
    {
        if ($db_path)
            $file_path = pathinfo($db_path);
        else
            return null;
        $output = "";
        $dir_name = $file_path['dirname'];
        $base_name = $file_path['basename'];
        $extension = $file_path['extension'];
        $file_name = $file_path['filename'];
        $image_sizes = Config::get('constants.image_sizes');
        $key_exist = array_key_exists($dimension, $image_sizes);

        if ($key_exist) {
            $size = $image_sizes[$dimension];
            $width = $size[0];
            $height = $size[1];
            $allowed = true;
        } else {
            $allowed = false;
        }
        if ($allowed) {

            $destination_img_name = $dir_name . '/' . $file_name . '-' . $width . 'x' . $height . '.' . $extension;
            $output = url('media') . '/' . $given_path . '/' . $destination_img_name;
            $path = url('media/'.$given_path);
            $path_dir = public_path('media/');

            $ful_path = $path . '/' . $destination_img_name;
            $month = date("n");
            $year = date("Y");


            $output = $ful_path;

        } else {
            $output = url('media') . '/' . $given_path . '/' . $db_path;
        }
        return ($output);
    }

}

function img_resize($target, $newcopy, $w, $h, $ext)
{
//dd($target);
    $ext = exif_imagetype($target);
    list($w_orig, $h_orig) = getimagesize($target);
    $img = "";
    if ($ext == 1) {
        $img = imagecreatefromgif($target);
    } else if ($ext == 3) {
        $img = imagecreatefrompng($target);
    } else if ($ext == 6) {
        $img = imagecreatefrombmp($target);
    } else {
        $img = imagecreatefromjpeg($target);
    }

    $source_aspect_ratio = $w_orig / $h_orig;
    $desired_aspect_ratio = $w / $h;

    if ($source_aspect_ratio > $desired_aspect_ratio) {
        //
        // Triggered when source image is wider
        //
        $temp_height = $h;
        $temp_width = (int)($h * $source_aspect_ratio);
    } else {
        //
        // Triggered otherwise (i.e. source image is similar or taller)
        //
        $temp_width = $w;
        $temp_height = (int)($w / $source_aspect_ratio);
    }

    //
    // Resize the image into a temporary GD image
    //

    $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
    if ($ext == 3) {
        imageAlphaBlending($temp_gdim, false);
        imageSaveAlpha($temp_gdim, true);
    }

    imagecopyresampled(
        $temp_gdim, $img, 0, 0, 0, 0, $temp_width, $temp_height, $w_orig, $h_orig
    );

    //
    // Copy cropped region from temporary image into the desired GD image
    //

    $x0 = ($temp_width - $w) / 2;
    $y0 = ($temp_height - $h) / 2;

    $desired_gdim = imagecreatetruecolor($w, $h);
    if ($ext == 3) {//png
        imageAlphaBlending($desired_gdim, false);
        imageSaveAlpha($desired_gdim, true);
    }
    imagecopy(
        $desired_gdim, $temp_gdim, 0, 0, $x0, $y0, $w, $h
    );

    //
    // Render the image
    // Alternatively, you can save the image in file-system or database
    //


    if ($ext == 3) {
        header('Content-Type: image/png');
        imagepng($desired_gdim, $newcopy);
        //imagepng($desired_gdim);
    } else {
        header('Content-type: image/jpeg');
        imagejpeg($desired_gdim, $newcopy, 80);
        //   imagejpeg($desired_gdim);
    }
}

if (!function_exists('image_upload')) {

    function image_upload($request, $attached_to_item = 'profilepic', $attached_to_id = 1, $file_name = 'profile_file')
    {
        //$image = $request->file('profile_file');
        $image = $request->file($file_name);
        $path = public_path('media/original/');
        $filename = $image->getClientOriginalName();
        $ext = $image->getClientOriginalExtension();
        $filename2 = str_replace('.' . $ext, '', $filename);
        $file_partial_path = set_file_name($path, $filename2, $ext);
        $file_path = $path . $file_partial_path;
        //$request->file('profile_file')->move(substr($file_path,0, strrpos($file_path,'/' )),substr($file_partial_path, strrpos($file_partial_path,'/' )+1));
        $request->file($file_name)->move(substr($file_path, 0, strrpos($file_path, '/')), substr($file_partial_path, strrpos($file_partial_path, '/') + 1));
        $media = new \App\Media();
        $media->attached_to_id = $attached_to_id;
        $media->attached_to_item = $attached_to_item;
        $media->title = $filename;
        $media->file_name = $file_partial_path;
        $media->user_id = 0;
        $media->protected = 0;

        $media->save();

        return ($media);
    }

}

if (!function_exists('array_image_upload')) {

    function array_image_upload($file, $attached_to_item = 'profilepic', $attached_to_id = 1)
    {

        $path = public_path('media/original/');

        $filename = $file->getClientOriginalName();

        $ext = $file->getClientOriginalExtension();

        $filename2 = str_replace('.' . $ext, '', $filename);

        $file_partial_path = set_file_name($path, $filename2, $ext);

        $file_path = $path . $file_partial_path;

        $file->move(substr($file_path, 0, strrpos($file_path, '/')), substr($file_partial_path, strrpos($file_partial_path, '/') + 1));

        $media = new \App\Media();

        $media->attached_to_id = $attached_to_id;

        $media->attached_to_item = $attached_to_item;

        $media->title = $filename;

        $media->file_name = $file_partial_path;

        $media->user_id = 0;

        $media->protected = 0;

        $media->save();

        return ($media);
    }

}
if (!function_exists('ImageUploadWithPath')) {

    function ImageUploadWithPath($file, $given_path = 'images')
    {

        $path = public_path("media/" . "$given_path" . "/");

        $filename = $file->getClientOriginalName();

        $ext = $file->getClientOriginalExtension();

        $filename2 = str_replace('.' . $ext, '', $filename);

        $file_partial_path = set_file_name($path, $filename2, $ext);

        $file_path = $path . $file_partial_path;

        $file->move(substr($file_path, 0, strrpos($file_path, '/')), substr($file_partial_path, strrpos($file_partial_path, '/') + 1));

        return $file_partial_path;


    }

}

if (!function_exists('set_file_name')) {

    function set_file_name($path, $filename, $ext)
    {
        //

        $file_extention = $ext;

        $filename = str_replace($file_extention, '', $filename);

        $file_name = str_slug($filename) . '.' . $file_extention; // preg_replace("/\s+/", "_", $filename);
        $month = date("n");
        $year = date("Y");

        if (!is_dir($path . $year . '/' . $month)) {
            mkdir($path . $year . '/' . $month, 0775, true);
        }
        $filename = $year . '/' . $month . '/' . $file_name;
        if (!file_exists($path . $filename)) {

            return $filename;
        }

        $filename = str_replace('.' . $file_extention, '', $filename);

        $new_filename = '';
        for ($i = 1; $i < 100; $i++) {
            if (!file_exists($path . $filename . $i . '.' . $file_extention)) {
                $new_filename = $filename . $i . '.' . $file_extention;
                break;
            }
        }
        if ($new_filename == '') {
            $this->set_error('upload_bad_filename');
            return FALSE;
        } else {
            return $new_filename;
        }
    }


}
if (!function_exists('uploadImage')) {

    function uploadImage($path, $file)
    {
        $path = public_path($path);
        $filename = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $filename2 = str_replace('.' . $ext, '', $filename);
        $file_partial_path = set_file_name($path, $filename2, $ext);
        $file_path = $path . $file_partial_path;
        $file->move(substr($file_path, 0, strrpos($file_path, '/')), substr($file_partial_path, strrpos($file_partial_path, '/') + 1));
        return $file_partial_path;
    }

}

if (!function_exists('flushImage')) {

    function flushImage($id = null, $folder = null, $delete = 0)
    {
        $image = \App\PropertyImage::find($id);
        $image_sizes = Config::get('constants.image_sizes');
        if ($image) {

            foreach ($image_sizes as $key => $val) {
                $path = getImageByPathOnly($image->image, $key, $folder);
                $path =  str_replace(url('/'),public_path(),$path);
                if (file_exists($path)) {
                    unlink($path);
                }

            }
            if ($delete) {
                $path = getImageByPathOnly($image->image, '', $folder);
                $path =  str_replace(url('/'),public_path(),$path);
                if (file_exists($path)) {
                    unlink($path);
                }
                $image->delete();
                return 1;
            }
        }
    }
}