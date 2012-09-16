kohana-automatify
=================

Kohana automatify model which allowes you to build very easy listing items pages.

Instalation
-----------	

For now this don't work as an module for kohana, you must do it manualy.

To install it, place following files in exact directories:

	* automatify.php -> classes/model/
	* norecords.php  -> views/helpers/
	* pagination.php -> views/helpers/
	* perpage.php    -> views/helpers/perpage.php
	* search.php     -> views/helpers/search.php
	* pagination.js  -> media/js (or any other directory with your js files)

Each controller must have a view directory e.g. Users controller must have a directory "users" in views which must contain min. two files:
1. index.php - main index file which will render as a partial the data_table.php file.

	<?php echo View::factory('users/data_table')->set('items', $pagination->all());?>

2. data_table.php - which contains just the data, in example in a table rows

3. In the controller place those few lines:

	$orm = ORM::factory('user'); // load the table orm
	$search = array('name'); // set on which column(s) you want to search
	$sort = array('id' => 'ASC'); // set the default sorting 
	//(key is the column, value is the sorting type: ASC or DESC)
		
	//And pass the needed instance to the view
	$this->template->content = View::factory('users/index');
	$this->template->content->pagination = new Model_Automatify($orm, $search, $sort);

The rest is in the code. Thats all.
