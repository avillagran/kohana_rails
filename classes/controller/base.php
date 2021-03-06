<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Base extends Controller {
	
	/**
	 * @param Request $request
	 * @param Response $response
	 * @return Auth
	 */
	protected $auth;
	
	public function __construct(Request $request, Response $response)
	{
		$this->auth = Auth::instance();
		parent::__construct($request, $response);
		
	}
	
	protected function params()
	{
		return Helpers::params();
	}
	protected function param($name, $default = NULL)
	{
		return Helpers::param($name, $default);
	}
	protected function notice($type, $message)
	{
		Notice::add($type, $message);
	}
	protected function valid_token()
	{
		return $this->param('token') == Security::token();
	}
	protected function save_and_validate_model($model, $values, $extra_validation = TRUE, $remote = FALSE)
	{
		$valid = ( $remote ? $remote : $this->valid_token() );
		
		try
		{
			if($valid && $extra_validation)
			{
				$model->values($values);
				$model->save();
				$created = true;
			}
			else
				$valid = false;
		}
		catch(ORM_Validation_Exception $e)
		{
			$this->notice(Notice::VALIDATION, Helpers::get_validation_errors(($e->errors('models'))));
			$valid = false;
		}
		
		return $valid;
	}
	protected function to_json($data)
	{
		return json_encode($data);
	}
	protected function orm_to_json($data)
	{
		$data = $data->as_array();
		
		$output = array();
		
		foreach ($data as $key => $value)
		{
		   $output[$key] = $value->as_array();
		}
		
		return $this->to_json($output);
	}
	protected function redirect($url_or_route)
	{
		$this->request->redirect(Helpers::get_url($url_or_route));
	}
	protected function is_post_method()
	{
		return $this->request->method() == HTTP_Request::POST;
	}
	protected function is_get_method()
	{
		return $this->request->method() == HTTP_Request::GET;
	}
}