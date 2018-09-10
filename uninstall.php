<?php
// If ABSPATH is not defined, then the code is called from outside
// WP_UNINSTALL_PLUGIN constant indicates that the plugin is removed from plugins menu
if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

require_once __DIR__ . '/includes/OfferRequester.php';
require_once __DIR__ . '/includes/FileHelper.php';

OfferRequester::deleteTable();

$img_dir = __DIR__ . '/img';

if (file_exists($img_dir)) {
    if (!rmdir($img_dir)) {
        FileHelper::deleteDirectory($img_dir);
    }
}