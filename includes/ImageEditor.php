<?php


class ImageEditor
{
    public static function resizeImage($file, $path, $ext, $w = 300, $h = 200, $crop = false)
    {
        if ($ext === 'image/jpeg') {
            $src = imagecreatefromjpeg($file);
        } else {
            $src = imagecreatefrompng($file);
        }
        // Size of the old image
        $old_w = imagesx($src);
        $old_h = imagesy($src);
        // Resolution of the image
        $res = $old_w / $old_h;
        // Cut part of image
        if ($crop) {
            if ($old_w > $old_h) {
                $old_w = ceil($old_w - ($old_w * abs($res - $w / $h)));
            } else {
                $old_h = ceil($old_h - ($old_h * abs($res - $w / $h)));
            }
            $new_w = $w;
            $new_h = $h;
        // Reduce to the set size
        } else {
            if ($w / $h > $res) {
                $new_w = $h * $res;
                $new_h = $h;
            } else {
                $new_h = $w / $res;
                $new_w = $w;
            }
        }
        // Create blank image with a black background
        $dst = imageCreateTrueColor($new_w, $new_h);
        // Copy and resize the image
        imageCopyResampled($dst, $src, 0, 0, 0, 0, $new_w, $new_h, $old_w, $old_h);
        if ($ext === 'image/jpeg') {
            imagejpeg($dst, $path, 100);
        } else {
            imagepng($dst, $path, 9);
        }
        // Freeing memory
        imagedestroy($dst);
    }
}