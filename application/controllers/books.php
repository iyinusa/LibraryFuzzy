<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Books extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->model('user'); //load MODEL
		$this->load->helper('text'); //for content limiter
		$this->load->helper('url'); //for content limiter
		$this->load->library('form_validation'); //load form validate rules
		$this->load->library('image_lib'); //load image library
		
		//mail config settings
		$this->load->library('email'); //load email library
		//$config['protocol'] = 'sendmail';
		//$config['mailpath'] = '/usr/sbin/sendmail';
		//$config['charset'] = 'iso-8859-1';
		//$config['wordwrap'] = TRUE;
		
		//$this->email->initialize($config);
    }
	
	public function index() {
		if($this->session->userdata('logged_in')==FALSE){ 
			redirect(base_url().'login/', 'location');
		}
		
		//check for update
		$get_id = $this->input->get('edit');
		if($get_id != ''){
			$gq = $this->user->query_rec_single('id', $get_id, 'bz_book');
			foreach($gq as $item){
				$data['e_id'] = $item->id;
				$data['e_author_id'] = $item->author_id;
				$data['e_pub_id'] = $item->pub_id;
				$data['e_dept_id'] = $item->dept_id;
				$data['e_title'] = $item->title;
				$data['e_details'] = $item->details;
				$data['e_isbn'] = $item->isbn;
				$data['e_pages'] = $item->pages;
				$data['e_edition'] = $item->edition;
				$data['e_year'] = $item->year;
				$data['e_doc'] = $item->doc;
			}
		}
		
		//check record delete
		$del_id = $this->input->get('del');
		if($del_id != ''){
			if($this->user->delete_rec('id', $del_id, 'bz_book') > 0){
				$data['err_msg'] = '<div class="alert alert-info"><h5>Deleted</h5></div>';
			} else {
				$data['err_msg'] = '<div class="alert alert-info"><h5>There is problem this time. Try later</h5></div>';
			}
		}
		
		//check if ready for post
		if($_POST){
			$book_id = $_POST['book_id'];
			$author_id = $_POST['author_id'];
			$pub_id = $_POST['pub_id'];
			$dept_id = $_POST['dept_id'];
			$title = $_POST['title'];
			$details = $_POST['details'];
			$isbn = $_POST['isbn'];
			$pages = $_POST['pages'];
			$edition = $_POST['edition'];
			$year = $_POST['year'];
			$edoc = $_POST['edoc'];
			$doc = '';
			$error = FALSE;
			
			//Upload code
			$config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'pdf|doc|docx';
			
			$this->load->library('upload', $config);
			
			if(!$this->upload->do_upload('doc')){
				$doc = $this->upload->display_errors();
				$error = TRUE;
			} else {
				$docall = $this->upload->data();
				$doc = $docall['file_name'];
			}
			
			if($error == TRUE && $book_id == '') {
				$data['err_msg'] = '<div class="alert alert-info"><h5>'.$doc.'</h5></div>';
			} else {
				if($error == FALSE){$edoc = $doc;}
				//check for update
				if($book_id != ''){
					$upd_data = array(
						'author_id' => $author_id,
						'pub_id' => $pub_id,
						'dept_id' => $dept_id,
						'title' => $title,
						'details' => $details,
						'isbn' => $isbn,
						'pages' => $pages,
						'edition' => $edition,
						'year' => $year,
						'doc' => $edoc
					);
					
					if($this->user->update_rec('id', $book_id, 'bz_book', $upd_data) > 0){
						$data['err_msg'] = '<div class="alert alert-info"><h5>Successfully</h5></div>';
					} else {
						$data['err_msg'] = '<div class="alert alert-info"><h5>No Changes Made</h5></div>';
					}
				} else {
					$reg_data = array(
						'author_id' => $author_id,
						'pub_id' => $pub_id,
						'dept_id' => $dept_id,
						'title' => $title,
						'details' => $details,
						'isbn' => $isbn,
						'pages' => $pages,
						'edition' => $edition,
						'year' => $year,
						'doc' => $doc
					);
					
					if($this->user->reg_rec('bz_book', $reg_data) > 0){
						$data['err_msg'] = '<div class="alert alert-info"><h5>Successfully</h5></div>';
					} else {
						$data['err_msg'] = '<div class="alert alert-info"><h5>There is problem this time. Try later</h5></div>';
					}
				}	
			}
		}
		
		//query uploads
		$data['allup'] = $this->user->query_rec('bz_book');
		$data['allpublisher'] = $this->user->query_rec('bz_publisher');
		$data['allauthor'] = $this->user->query_rec('bz_author');
		$data['alldepartment'] = $this->user->query_rec('bz_department');
		
		$data['log_username'] = $this->session->userdata('log_username');
	  
	  	$data['title'] = 'Books';
		$data['page_act'] = 'book';

	  	$this->load->view('designs/header', $data);
		$this->load->view('designs/leftmenu', $data);
	  	$this->load->view('book', $data);
	  	$this->load->view('designs/footer', $data);
	}
}