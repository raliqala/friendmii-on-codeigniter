<?php
	/**
	 * 
	 */
	class Pages extends CI_Controller{

		public function view($page = 'home'){
		  if (!empty($this->session->userdata('user_id')) && $this->session->userdata('logged_in') == true) {
            redirect('posts');
          }
			if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
				show_404();
			}

			$data['title'] = ucfirst($page);
			$data['navbar'] = 'templates/navbar';

			$this->load->view('templates/header');
			$this->load->view('pages/'.$page, $data);
			$this->load->view('templates/footer');

		}


	}
