<?php

class SpecialOffers
{
    const MIN_WP_VERSION = '3.1';

    const PLUGIN_NAME = 'special-offers';

    public function pluginActivation()
    {
        // Check Wordpress version
        if (version_compare($GLOBALS['wp_version'], self::MIN_WP_VERSION, '<')) {
            wp_die('This plugin requires WordPress version' . self::MIN_WP_VERSION . 'or higher.');
        }
        self::autoload();
        // Create plugin table in database
        try {
            OfferRequester::createTable();
        } catch (Exception $e) {
            wp_die($e->getMessage());
        }
        // Create image directory
        FileHelper::createDirectory(plugin_dir_path(__DIR__) . '/img');
    }

    public function pluginDeactivation()
    {
        remove_menu_page('specoff');
    }

    public function init()
    {
        self::autoload();
        // Add plugin menu item
        add_action('admin_menu', ['SpecialOffers', 'addAdminMenu']);
        add_shortcode('specoff', ['SpecialOffers', 'addShortcode']);
        // Allows to add shortcodes in widgets
        add_filter('widget_text', 'do_shortcode');
        // Add plugin script to pages
        add_action('wp_enqueue_scripts', ['SpecialOffers', 'connectScript']);
        add_action('wp_enqueue_scripts', ['SpecialOffers', 'connectOfferStyle']);
    }

    function addAdminMenu()
    {
        // Get identifier of plugin page
        $page = add_menu_page('Special Offers', 'Special Offers', 8, 'specoff', ['SpecialOffers', 'addOffer'], 'dashicons-cart', "81.9");
        // Connect styles when the plugin page is called
        add_action('admin_print_styles-' . $page, ['SpecialOffers', 'connectAdminStyle']);
    }

    function addOffer()
    {
        require_once plugin_dir_path(__DIR__) . '/views/add_form.php';
        if (isset($_POST['specoff'])) {
            try {
                OfferService::saveOffer();
            } catch (Exception $e) {
                $errors[] = $e->getMessage();
            }
        }
    }

    function connectAdminStyle()
    {
        $style = plugins_url(self::PLUGIN_NAME . '/css/offer-form.css');
        $rand = mt_rand();
        wp_enqueue_style('specoff-form', $style, [], $rand);
    }

    function connectOfferStyle()
    {
        $style = plugins_url(self::PLUGIN_NAME . '/css/offer.css');
        $rand = mt_rand();
        wp_enqueue_style('specoff-form', $style, [], $rand);
    }

    function connectScript()
    {
        $script = plugins_url(self::PLUGIN_NAME . '/js/ajax_viewport.js');
        $rand = mt_rand();
        wp_enqueue_script('ajax-viewport', $script, [], $rand);
    }

    function addShortcode($atts, $content = null)
    {
        try {
            $props = OfferService::fromShortcode($atts['id']);
            $props['offer_image'] = plugins_url(self::PLUGIN_NAME . '/img/') . $props['offer_image'];
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
        ob_start();
        require_once plugin_dir_path(__DIR__) . '/views/special_offer.php';
        return ob_get_clean();
    }

    static function autoload()
    {
        spl_autoload_register(function ($class_name) {
            require_once $class_name . '.php';
        });
    }
}