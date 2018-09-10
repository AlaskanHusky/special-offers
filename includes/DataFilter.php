<?php

class DataFilter
{
    public static function convertToString($raw_data)
    {
        $trimmed_string = trim($raw_data);
        return !is_string($trimmed_string) ? strval($trimmed_string) : $trimmed_string;
    }

    public static function convertToFloat($raw_data)
    {
        return !is_float($raw_data) ? (float)$raw_data : $raw_data;
    }

    public static function convertToDate($raw_data)
    {
        $date_time = explode(' ', $raw_data);
        //
        if (count($date_time) !== 2) {
            return false;
        }

        $date = explode('-', $date_time[0]);
        if (count($date) !== 3) {
            return false;
        }

        $year = self::convertToInt($date[0]);
        $month = self::convertToInt($date[1]);
        $day = self::convertToInt($date[2]);

        if (!checkdate($month, $day, $year)) {
            return false;
        }

        $time = explode(':', $date_time[1]);
        if (count($time) !== 2) {
            return false;
        }

        $hours = self::convertToInt($time[0]);
        $minutes = self::convertToInt($time[1]);

        if (($hours > 23 && $hours < 0) || ($minutes > 59 && $minutes < 0)) {
            return false;
        }

        return sprintf('%u-%02d-%02d %02d:%02d', $year, $month, $day, $hours, $minutes);
    }

    public static function convertToInt($raw_data)
    {
        return !is_int($raw_data) ? (int)$raw_data : $raw_data;
    }

    public static function sanitizeString($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}