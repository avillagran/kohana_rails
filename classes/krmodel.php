<?php defined('SYSPATH') or die('No direct access allowed.');

abstract class Krmodel extends ORM {
		
	public function create(Validation $validation = NULL)
	{
		
		if( Arr::get($this->list_columns(), 'created_at', NULL) != NULL )
			$this->set('created_at', new Database_Expression('CURRENT_TIMESTAMP()'));
		
		if( Arr::get($this->list_columns(), 'updated_at', NULL) != NULL )
			$this->set('updated_at', new Database_Expression('CURRENT_TIMESTAMP()'));
		
		parent::create($validation);
	}
	public function update(Validation $validation = NULL)
	{
		if( Arr::get($this->list_columns(), 'updated_at', NULL) != NULL )
			$this->set('updated_at', new Database_Expression('CURRENT_TIMESTAMP()'));
	
		parent::update($validation);
	}
}