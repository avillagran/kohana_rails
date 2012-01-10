<?php defined('SYSPATH') or die('No direct script access.');

class DateHelper {
		
	public static function parse_date($my_sql_string_date, $str_format) 
    {
        @list($date, $time) = explode(" ", $my_sql_string_date);
        @list($year, $month, $day) = explode("-", $date);
        @list($hour, $minute, $second) = explode(":", $time);
        @$unix_stamp = mktime($hour, $minute, $second, $month, $day, $year);
        
        return date($str_format, $unix_stamp);
    }
	
	public static function str_to_time($str_format, $str_time = "today")
    {
        $unix_stamp = strtotime($str_time, time());
        return date($str_format, $unix_stamp);        
    }
	
    public static function timezone_date($mysql_string_date, $str_format = "%Y-%m-%d %H:%M:%S")
    {
        @list($date, $time) = explode(" ", $mysql_string_date);
        @list($year, $month, $day) = explode("-", $date);
        @list($hour, $minute, $second) = explode(":", $time);
        @$unix_stamp = mktime($hour, $minute, $second, $month, $day, $year);

        return strftime( $str_format, $unix_stamp );
    }
}
