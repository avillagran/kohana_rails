<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Application extends Controller_KRTemplate {
	
	/**
	 * Define el título del sitio
	 */
	public $title;
	public $sub_title;
	public $menu;
	protected $config;
	
	public function before()
    {
    	parent::before();
		
		$this->config = Kohana::config('website');
		
		Cookie::$salt = $this->config['cookie_salt'];
		
		$this->title = $this->config['site_name'];
		
		// Defino como variable del controlador el $title
		View::bind_global('title', $this->title);
		View::bind_global('sub_title', $this->sub_title);
		
		$this->menu = $this->config['menu'];
		View::bind_global('menu', $this->menu);
	    
	}
	public function set_title($value)
	{
		$this->sub_title = ' :: '.$value;	
	}
	
	public function get_view($path=NULL)
	{
		if( $path == NULL )
		{
			$path = $this->request->controller() . "/" . $this->request->action(); 	
		}
		$view = View::factory($path);
		
		$notice	= 	Notice::render(Notice::INFO).
					Notice::render(Notice::ERROR).
					Notice::render(Notice::WARNING).
					Notice::render(Notice::VALIDATION).
					Notice::render(Notice::SUCCESS);
		 
		$view->bind('notice', $notice);
		$view->bind('errors', $errors);
		
		return $view;
	}
	
}
?>