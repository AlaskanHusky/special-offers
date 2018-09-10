<?php


class FileHelper
{
    public static function saveImage($temp_path, $path)
    {
        // copy() is used, because move_uploaded_file() lock file in Windows
        copy($temp_path, $path);
        chmod($path, 0644);
    }

    public static function checkFile($path)
    {
        $exts = ['image/jpeg', 'image/png'];
        $real_ext = mime_content_type($path);

        if (in_array($real_ext, $exts)) {
            return true;
        }

        return false;
    }

    public static function getFileExt($type)
    {
        $ext = null;
        switch ($type) {
            case 'image/jpeg':
                $ext = '.jpeg';
                break;
            case 'image/png':
                $ext = '.png';
                break;
        }

        return $ext;
    }

    public static function deleteFile($path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public static function createDirectory($path)
    {
        if(!file_exists($path)) {
            mkdir($path, 0700);
        }
    }

    public static function deleteDirectory($dir_name)
    {
        $iterator = new RecursiveDirectoryIterator($dir_name);
        $files = new RecursiveIteratorIterator(
            $iterator, RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $file) {
            if (in_array($file->getFilename(), ['..', '.'])) {
                continue;
            }

            ($file->isDir()) ? rmdir($file) : unlink($file);
        }

        rmdir($dir_name);
    }
}