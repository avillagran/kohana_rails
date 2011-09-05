<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Application extends Controller_KRTemplate {
	
	/**
	 * Define el título del sitio
	 */
	public $title;
	public $sub_title;
	public $menu;
	public $session;
	
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
		
		$this->session = Session::instance();
	}
	public function set_title($value)
	{
		$this->sub_title = ' :: '.$value;	
	}
	
	public function get_view($path=NULL)
	{
		if( $path == NULL )
		{
			$path = (strlen($this->request->directory()) > 0 ? $this->request->directory() . "/" : '') . $this->request->controller() . "/" . $this->request->action(); 	
		}
		$view = View::factory($path);
		$view->bind('notice', $notice);
				
		return $view;
	}
	public function set_view($view)
	{
		$this->template->content = $view;
	}
	/**
	 * 
	 * Imprime las cabezeras para permitir conexión via AJAX
	 */
	protected function allowed_header($is_allowed)
	{
		if($is_allowed)
			header('Access-Control-Allow-Origin: *');
	}
	
}
?>