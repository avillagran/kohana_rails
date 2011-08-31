<?php defined('SYSPATH') or die('No direct script access.');

class UrlHelpers {
	public static function link_to($url_or_route, $title=NULL, $attributes=NULL)
    {
        return HTML::anchor(Helpers::get_url($url_or_route), $title, $attributes);
    }
	public static function domain($url)
	{
		if( $url == NULL OR strlen($url) < 2 )
			return "";
				
		$parsed = parse_url($url); 
		$hostname = $parsed['host']; 

		return $hostname; 
	}

}
