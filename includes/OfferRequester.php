<?php

class OfferRequester
{
    public static function addOne($props)
    {
        global $wpdb;
        $table_name = self::getTableName();
        self::checkConnection();
        $success = $wpdb->insert(
            $table_name,
            [
                'offer_title' => $props['title'], 'offer_description' => $props['description'],
                'offer_category' => $props['category'], 'offer_image' => $props['image_name'],
                'regular_price' => $props['regular_price'], 'special_price' => $props['special_price'],
                'offer_date' => $props['datetime']
            ],
            ['%s', '%s', '%s', '%s', '%f', '%f', '%s']
        );
        if ($success === false) {
            throw new \Exception('Database request failed: could not add row!');
        }
    }

    public static function findOneById($id)
    {
        global $wpdb;
        $table_name = self::getTableName();
        self::checkConnection();
        $sql = esc_sql('SELECT * FROM '. $table_name . ' WHERE offer_id = '. $id);
        $row = $wpdb->get_row($sql, ARRAY_A);
        if ($row === null) {
            throw new \Exception('Database request failed: could not get the row!');
        }
        return $row;
    }

    public static function updateOneById($props)
    {
        global $wpdb;
        $table_name = self::getTableName();
        self::checkConnection();
        $success = $wpdb->update(
            $table_name,
            [
                'offer_title' => $props['title'], 'offer_description' => $props['description'],
                'offer_category' => $props['category'], 'offer_image' => $props['image_name'],
                'regular_price' => $props['regular_price'], 'special_price' => $props['special_price'],
                'offer_date' => $props['datetime']
            ],
            ['offer_id' => $props['id']],
            ['%s', '%s', '%s', '%s', '%f', '%f', '%s'],
            ['%d']
        );
        if ($success === false || $success === 0) {
            throw new \Exception('Database request failed: could not update row!');
        }
    }

    public static function deleteOneById($id)
    {
        global $wpdb;
        $table_name = self::getTableName();
        self::checkConnection();
        $success = $wpdb->delete($table_name, ['offer_id' => $id], ['%d']);
        if ($success === 0) {
            throw new \Exception('Database request failed: could not delete row!');
        }
    }

    public static function findAll()
    {
        global $wpdb;
        $table_name = self::getTableName();
        self::checkConnection();
        $sql = esc_sql('SELECT * FROM ' . $table_name);
        $rows = $wpdb->get_results($sql, ARRAY_A);
        if ($rows === []) {
            throw new \Exception('Database request failed: could not get the data!');
        }
        return $rows;
    }

    public static function createTable()
    {
        global $wpdb;
        $table_name = self::getTableName();
        self::checkConnection();
        if ($wpdb->get_var("SHOW TABLES LIKE $table_name") != $table_name) {
            $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
	            `offer_id` INT(4) NOT NULL AUTO_INCREMENT,
	            `offer_title` VARCHAR(100) NOT NULL,
	            `offer_description` VARCHAR(500) NULL DEFAULT NULL,
	            `offer_category` VARCHAR(100) NOT NULL,
	            `offer_image` VARCHAR(10) NOT NULL,
	            `regular_price` FLOAT UNSIGNED NOT NULL,
	            `offer_date` VARCHAR(16) NOT NULL,
	            `special_price` FLOAT UNSIGNED NOT NULL,
	            PRIMARY KEY (`offer_id`))
                COLLATE='utf8_general_ci'
                ENGINE=MyISAM;";
            $success = $wpdb->query($sql);
            if ($success === false) {
                throw new \Exception('Database request failed: could not create table!');
            }
        }
    }

    public static function deleteTable()
    {
        global $wpdb;
        self::checkConnection();
        $table_name = self::getTableName();
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }

    private static function checkConnection()
    {
        global $wpdb;
        //Failed to the database connection
        if (!empty($wpdb->error)) {
            wp_die($wpdb->error);
        }
    }

    private static function getTableName()
    {
        global $wpdb;
        return $wpdb->prefix . "so_offers";
    }
}