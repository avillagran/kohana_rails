<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_KRTemplate extends Controller_Base {
		/**
	 * @var  View  page template
	 */
	public $template = 'template';

	/**
	 * @var  boolean  auto render template
	 **/
	public $auto_render = TRUE;

	/**
	 * Loads the template [View] object.
	 */
	public function before()
	{
		if ($this->auto_render === TRUE)
		{
			// Load the template
			$view = View::factory($this->template);
			
			$notices_arr = Notice::as_array(); 
			
			$notice = "";
			
			foreach($notices_arr as $key => $item)
			{
				$notice .= '<div class="notification '.$key.'">';
				foreach($item as $msg)
				{
					$notice .= $msg['message'];
				}
				$notice .= '</div>';
				
				Notice::clear($key);
			}
				
			/*
				Notice::render(Notice::INFO).
				Notice::render(Notice::ERROR).
				Notice::render(Notice::WARNING).
				Notice::render(Notice::VALIDATION).
				Notice::render(Notice::SUCCESS);
			 */
		 
			$view->bind('notice', $notice);

			$this->template = $view; 
		}

		return parent::before();
	}

	/**
	 * Assigns the template [View] as the request response.
	 */
	public function after()
	{
		if ($this->auto_render === TRUE)
		{
			$this->response->body($this->template->render());
		}

		return parent::after();
	}
	
}