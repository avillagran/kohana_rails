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
	public static function get_route(array $params)
	{
		
		$found = NULL;
		
		$found = self::search_route($params);
		
		if($found == NULL && isset($params['action']))
		{
			unset($params['action']);
			$found = self::search_route($params);
		}
		
		return $found == NULL ? 'default' : $found;
	}
	private static function search_route($params)
	{
		$routes = Route::all();
		foreach($routes as $name => $route)
		{
			if($route->matches( Request::$initial->uri($params) ) && $name != "default" )
				return $name;
		}
		return NULL;
	}

}
