<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Application extends Controller_Template {
	
	/**
	 * Define el título del sitio
	 */
	public $title;
	public $sub_title;
	public $menu;
	private $config;
	
	public function before()
    {
    	parent::before();
		
		$this->config = Kohana::config('website');
		
		$this->title = $this->config['site_name'];
		
		// Defino como variable del controlador el $title
		View::bind_global('title', $this->title);
		View::bind_global('sub_title', $this->sub_title);
		
		$this->menu = $this->config['menu'];
		View::bind_global('menu', $this->menu);
	    
	}
	public function setTitle($value)
	{
		$this->sub_title = ' :: '.$value;	
	}
	
	public function getView($path=NULL)
	{
		if( $path == NULL )
		{
			$path = $this->request->controller() . "/" . $this->request->action(); 	
		}
		return View::factory($path);
	}
	public function params()
	{
		return Helpers::params();
	}
	public function param($name)
	{
		return Helpers::param($name);
	}
}
?>