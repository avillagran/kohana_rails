<?php defined('SYSPATH') or die('No direct script access.');

class Helpers {
    
    public static function link_to($url_or_route, $title=NULL, $attributes=NULL)
    {
        try {
            if($url_or_route != '/')
                $url_or_route = Route::url($url_or_route);
        } catch (Exception $exc) { }

        return HTML::anchor($url_or_route, $title, $attributes);
    }
    
    public static function current_controller()
    {
        $val = array_search(Request::current()->route(), Route::all());
        $val = str_replace('/', '', $val);
        
        $val = '/'.$val;
        
        return $val;
    }
    
}
?>