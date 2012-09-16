<?php 
class Model_Automatify {
	
	public static $per_page_default = 10;
	protected $per_page;
	protected $model;
	protected $order;
	protected $pagination;
	protected $search_columns;
	protected $search_query;
	protected $offset;
	protected $sort_capabilities = array();
	
	public function __construct($model, $search, $order = array('id' => 'DESC')) {
		$per_page = Request::initial()->query('perpage');
		$user_order = Request::initial()->query('order');
		$user_order_type = Request::initial()->query('order_type');
		$this->model = $model;
		$this->search_columns = $search;
		$this->sortCapabilities();
		if(empty($user_order) || empty($user_order_type)) {
			$this->order = $order;
		}
		else {
			if(in_array($user_order, $this->sort_capabilities) && 
			in_array(strtolower($user_order_type), array('asc', 'desc'))) {
				$this->order = array($user_order => $user_order_type);
			}
			else {
				$this->order = $order;
			}
		}
		$this->search_query = Request::initial()->query('search_query');
		$this->per_page = Model_Automatify::perPageFilter($per_page);
		$this->configurePagination();
		$this->getRowsForCurrentPage();
		if(Request::initial()->is_ajax()) $this->ajax();
	}
	
	protected function configurePagination() {
		$config = array(
			'current_page'      => array('source' => 'query_string', 'key' => 'page'),
			'total_items'    	=> $this->searchConditions(),
			'items_per_page' 	=> $this->per_page
		);
		$pagination = Pagination::factory($config);
		$this->offset = $pagination->offset;
		$this->pagination = $pagination;
	}
	
	public function getRowsForCurrentPage() {
		$this->model
			->limit($this->per_page)
			->offset($this->offset); 
		if(!empty($this->search_query)) {
			foreach($this->search_columns as $column) {
				$this->model = $this->model->where($column, 'like', '%'.$this->search_query.'%');
			}
		}
		foreach($this->order as $by => $order) {
			$this->model = $this->model->order_by($by, $order);
		}
	}
	
	public function searchConditions() {
		if(!empty($this->search_query)) {
			foreach($this->search_columns as $column) {
				$this->model = $this->model->where($column, 'like', '%'.$this->search_query.'%');
			}
		}
		return $this->model->count_all();
	}
	
	public function __toString() {
		return $this->pagination->__toString();
	}
	
	public function all() {
		return $this->model->find_all();
	}
	
	private function ajax() {
		$response = array();
		$response['data'] = (string)View::factory(Request::initial()->controller().'/data_table')->set('items', $this->all());
		$response['pagination'] = $this->pagination->__toString();
		$order_table = array_keys($this->order);
		$order_type = array_values($this->order);
		if(strtolower($order_type[0]) == 'desc') { $order_to_show = 'asc';	}
		else { $order_to_show = 'desc';	}
		$response['order'] = Request::initial()->current()->uri().URL::query(array('order' => $order_table[0], 'order_type' => $order_to_show));
		echo json_encode($response);
		die();
	}
	
	public static function perPageFilter($per_page) {
		switch($per_page) {
			case 10:
			case 20:
			case 50:
				return $per_page;
			break;
			default:
				return self::$per_page_default;
			break;
		}	
	}
	
	public function sortCapabilities() {
		$columns = $this->model->table_columns();
		foreach($columns as $column => $info) {
			array_push($this->sort_capabilities, $column);
		}
	}
	
	public function sortHeader($name, $table) {
		if(!in_array($table, $this->sort_capabilities)) {
			die('Column '.$table.' dont exists in this db table');
		}
		$order = array_values($this->order);
		if(strtolower($order[0]) == 'desc') {
			$order_to_show = 'asc';
		}
		else {
			$order_to_show = 'desc';
		}
		return html::anchor(Request::initial()->current()->uri().URL::query(array('order' => $table, 'order_type' => $order_to_show)), $name, array('class' => 'sortHeader'));
	}
}