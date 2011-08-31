## Kohana Rails

Kohana helpers and classes for use like Rails

## Required modules
	- Imagefly: https://github.com/avillagran/imagefly
	- Notice: https://github.com/loonies/kohana-notice

## Installation
	$ git submodule add git@github.com:avillagran/kohana_rails.git modules/kohana_rails
	$ git submodule update --init
	
## Using Controller_Application

	class Controller_Site extends Controller_Application {
	
		public function action_index()
		{
			$view = $this->get_view(); // by default: ControllerName/ActionName -> site/index
	
			$this->template->content = $view; // Required
		}
	
	}
