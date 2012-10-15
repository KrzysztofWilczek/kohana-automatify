kohana-automatify
=================

Kohana automatify module which allowes you to build very easy listing items pages.

Instalation
-----------	

To install it add Automatify module to Kohana application. Copy media/js/pagination.js to your app js folder. Last step - write few lines of code and add Automatify functions.

Usage
-----

For every controller where youn need have ajax pagination create _list.php. This list view will contains description of elements list created by pagination.
In your index.php - main action view of elements list - use render partial methods:

<pre>
	<?= View::factory('users/_list')->set('items', $pagination->all());?>
</pre>

Remember _list.php only contains roules of data display

In your controller create query and configure automatify pagination:

<pre>

        $query = $query = DB::select('*')->from('users');
	$search = array('title'); // set on which column(s) you want to search
	$sort = array('id' => 'ASC'); // set the def sort (key is the column, value is the sorting type)
	$this->template->body = View::factory('users/index');
	$this->template->body->pagination = new Automatify($query, $search, $sort);
</pre>

The rest is in the code. Thats all.
