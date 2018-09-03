<?php
// If ABSPATH is not defined, then the code is called from outside
// WP_UNINSTALL_PLUGIN constant indicates that the plugin is removed from plugins menu
if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

specoff_delete_table();
specoff_delete_images();

function specoff_delete_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "so_offers";

    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}

function specoff_delete_images()
{
    $dir_name = __DIR__ . '/img';

    if (file_exists($dir_name)) {
        if (!rmdir($dir_name)) {
            specoff_delete_dir($dir_name);
        }
    }
}

function specoff_delete_dir($dir_name)
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