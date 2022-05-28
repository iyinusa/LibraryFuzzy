<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->model('user'); //load MODEL
		$this->load->helper('text'); //for content limiter
		$this->load->library('form_validation'); //load form validate rules
		
		//mail config settings
		$this->load->library('email'); //load email library
		//$config['protocol'] = 'sendmail';
		//$config['mailpath'] = '/usr/sbin/sendmail';
		//$config['charset'] = 'iso-8859-1';
		//$config['wordwrap'] = TRUE;
		
		//$this->email->initialize($config);
    }
	
	public function index() {
		if($_POST){
			$pub_id = $_POST['pub_id'];
			$dept_id = $_POST['dept_id'];
			$author_id = $_POST['author_id'];
			$query = $_POST['query'];
			
			if($query == ''){
				$data['search'] = $this->user->query_search_all();
			} else {
				$data['search'] = $this->user->query_search($pub_id, $author_id, $dept_id, $query);
				$data['e_pub_id'] = $pub_id;
				$data['e_author_id'] = $author_id;
				$data['e_dept_id'] = $dept_id;
			}
			
			//compute records relevance
			$records = $this->user->query_search_all();
			$total = 0;
			if(!empty($records)){
				//sum up all records view
				foreach($records as $rec){
					$total += $rec->view;
				}
				
				//compute and update each record
				foreach($records as $rec){
					$rel = 0;
					$rel = ($rec->view / $total) * 100;
					
					$upd_data = array(
						'relevance' => $rel
					);
					$this->user->update_rec('id', $rec->id, 'bz_book', $upd_data);
				}
			}
		}
		
		$data['allpublisher'] = $this->user->query_rec('bz_publisher');
		$data['allauthor'] = $this->user->query_rec('bz_author');
		$data['alldepartment'] = $this->user->query_rec('bz_department');
		
		$data['title'] = app_name;

	  	$this->load->view('designs/hm_header', $data);
	  	$this->load->view('welcome', $data);
	  	$this->load->view('designs/hm_footer', $data);
	}
}