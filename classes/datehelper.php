<?php defined('SYSPATH') or die('No direct script access.');

class DateHelper {
	function parse_date($my_sql_string_date, $default_format) 
	{
		list($date, $time) = explode(" ", $my_sql_string_date);
		list($year, $month, $day) = explode("-", $date);
		list($hour, $minute, $second) = explode(":", $time);
		$unix_stamp = mktime($hour, $minute, $second, $month, $day, $year);
		
		return date($default_format, $unix_stamp);
	}
}
