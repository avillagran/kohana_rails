<?php defined('SYSPATH') or die('No direct script access.');

class Helpers {
    public static function or_str($first=NULL, $replace="")
	{
		if(!is_string($first))
			return $replace;
		
		if(is_null($first) || strlen($first) == 0)
			$first = $replace;
		
		return $first;
	}
    public static function link_to($url_or_route, $title=NULL, $attributes=NULL)
    {
        return UrlHelpers::link_to($url_or_route, $title, $attributes);
    }
	/**
	 * Render partial with possible variables
	 * $vars = array( 'name' => $name )
	 * 
	 * return String
	 */
	public static function render_partial($path, $vars = array() )
	{
		$view = View::factory($path);
		$str = "Partial file not exists";
		
		if($view)
		{
			if( count($vars) > 0 )
			{
				foreach($vars as $k => $v)
				{
					$view->$k = $v; 
				}
			}
			
			$str = $view->render();
		}
		
		return $str;
	}
    public static function get_url($url_or_route)
	{
		try {
            if($url_or_route != '/' && substr($url_or_route, 0, 1) != '/' )
                $url_or_route = Route::url($url_or_route);
        } catch (Exception $exc) { }
		
		$url_or_route = str_replace("/index.php/", "/", $url_or_route);
		
		return $url_or_route;
	}
	public static function cache_url($uri = null, $params = null)
	{
		if($uri == null) $uri = Request::detect_uri();
		if($params == null) $params = Helpers::params();
		
		$url = $uri;
		foreach($params as $k => $v)
		{
			if($k != "_")
			{
				$url .= ($url == $uri ? '?' : '&') . $k . "=" . urlencode($v);
			}
		}
		if($url[0] == "/") $url = substr($url, 1);
		return $url; 
	}
	public static function clear_url_hash($url)
	{
		$tmp = explode('#',$url);
		return $tmp[0];
	}
	/**
	 * Return a string if $is_in is the same request path as current
	 */
	public static function current_string($is_in, $current_string = 'class="current"')
	{
		$route = Helpers::get_url($is_in);

		$curr_route = array_search(Request::current()->route(), Route::all());
		$curr_route = Helpers::get_url($curr_route);
				
		return $route == $curr_route ? $current_string : '';
	}
	
    public static function current_controller()
    {
        $val = array_search(Request::current()->route(), Route::all());
        $val = str_replace('/', '', $val);
        
        //$val = '/'.$val;
        
        return $val;
    }
    public static function thumbnail($original_path, $options=NULL)
	{
		$config = "";
		if( $options != NULL )
		{
			$config = $options;
		}
		
		return (strlen($config) > 0 ? 'imagefly/'.$config.'/' : '').$original_path;
	}
	public static function image_thumbnail($file, $options=NULL, $attributes=NULL)
	{
		return HTML::image(Helpers::thumbnail($file, $options), $attributes);
	}
	public static function label_field($name, $label, $attributes=NULL)
	{
		return Form::label(Helpers::name_to_id($name), $label);
	}
	public static function text_field($name, $label, $value=NULL, $label_attributes=NULL, $input_attributes=array())
	{
		$str = Helpers::label_field($name, $label, $label_attributes);
		
		$input_attributes['id'] = Helpers::name_to_id($name);
		$str .= " " . Form::input($name, $value, $input_attributes);
		
		return $str;
	}
	public static function password_field($name, $label, $value=NULL, $label_attributes=NULL, $input_attributes=array())
	{
		$str = Helpers::label_field($name, $label, $label_attributes);
		
		$input_attributes['id'] = Helpers::name_to_id($name);
		$str .= " " . Form::password($name, $value, $input_attributes);
		
		return $str;
	}
	public static function hidden_field($name, $value, $attributes = NULL)
	{
		return Form::hidden($name, $value, $attributes);
	}
	public static function token_field($name, $attributes = NULL)
	{
		return Helpers::hidden_field($name, Security::token(true), $attributes);
	}
	public static function cycle($array, $context = null)
	{
		global $cycles;
		if (!$context)
			$context = 'default';
		if (!isset($cycles[$context]))
			$cycles[$context] = 0;
		return $array[$cycles[$context]++ % count($array)];
	}
	public static function name_to_id($name)
	{
		$name = str_replace("[", "_", $name);
		$name = str_replace("]", "", $name);
		return $name;
	}
	public static function params()
	{
		$params = array();
		if($_GET) $params = array_merge($params, $_GET);
		if($_POST) $params = array_merge($params, $_POST);
		
		return $params;
	}
	public static function param($name, $default = NULL)
	{
		$params = Helpers::params();
		$rtrn = $default;
		
		if(isset($params[$name]))
		{
			$rtrn = $params[$name];
		}
		
		return $rtrn;
	}
	public static function get_validation_errors($errors)
	{
		$str = "<ul>";
		foreach($errors as $error)
		{
			$str .= '<li>'.$error.'</li>';
		}
		return $str."</ul>";
	}
	public static function config_value($group, $name)
	{
		return Arr::get(Kohana::config($group), $name, NULL);
	}
}
?>