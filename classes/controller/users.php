<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Users extends Controller_Template {
	public $template = 'template';

	public function action_index()
	{
		$orm = ORM::factory('user');
		$search = array('name');
		$sort = array('id' => 'ASC');
		
		$this->template->content = View::factory('users/index');
		$this->template->content->pagination = new Model_Automatify($orm, $search, $sort);
	}

}
