<?php

class SpecialOffers
{
    const MIN_WP_VERSION = '3.1';

    const PLUGIN_NAME = 'special-offers';

    const AJAX_ACTION = 'get_offer';

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
        add_action('wp_enqueue_scripts', ['SpecialOffers', 'connectOfferStyle']);
        // Add plugin script to pages
        add_action('wp_enqueue_scripts', ['SpecialOffers', 'connectScript']);
        // Activate AJAX hook
        add_action('wp_ajax_' . self::AJAX_ACTION, ['SpecialOffers', 'getOfferAjax']);
        // Activate hook for unauthorized user
        add_action('wp_ajax_nopriv_' . self::AJAX_ACTION, ['SpecialOffers', 'getOfferAjax']);
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
        wp_enqueue_style('specoff-admin', $style, [], $rand);
    }

    function connectOfferStyle()
    {
        $style = plugins_url(self::PLUGIN_NAME . '/css/offer.css');
        $rand = mt_rand();
        wp_enqueue_style('specoff-offer', $style, [], $rand);
    }

    function connectScript()
    {
        $script = plugins_url(self::PLUGIN_NAME . '/js/loader.js');
        $rand = mt_rand();
        wp_enqueue_script('specoff-loader', $script, ['jquery'], $rand, true);
    }

    function addShortcode($atts, $content = null)
    {
        $id = $atts['id'];
        // Passed to AJAX function required data
        wp_localize_script('specoff-loader', 'ajaxParams',
            [
                // For frontend (not admin)
                'url' => admin_url('admin-ajax.php'),
                'action' => self::AJAX_ACTION,
                'id' => $id,
            ]
        );
        ob_start();
        echo '<div class="offer-wrapper"></div>';
        return ob_get_clean();
    }

    function getOfferAjax()
    {
        try {
            $props = OfferService::fromShortcode($_POST['offer_id']);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
        $props['offer_image'] = plugins_url(self::PLUGIN_NAME . '/img/') . $props['offer_image'];

        ob_start();
        require_once plugin_dir_path(__DIR__) . '/views/special_offer.php';
        echo ob_get_clean();
        wp_die();
    }

    static function autoload()
    {
        try {
            spl_autoload_register(function ($class_name) {
                require_once $class_name . '.php';
            });
        } catch (Exception $e) {
            wp_die($e->getMessage());
        }
    }
}