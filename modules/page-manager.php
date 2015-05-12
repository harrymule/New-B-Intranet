<?php 

class page_manager extends data_manager {
	
	private $url;
	
	function page_manager(){
		$url = $_GET;
		$request_type = isset($_POST['request_type']) ? $_POST['request_type'] : false;
		
		($request_type == 'ajax_page') ? $this->open_ajax_page() : false;
		($request_type == 'ajax_form') ? $this->open_form() : false;
		($request_type == 'ajax_file') ? $this->open_file() : false;
		($request_type == 'ajax_post') ? $this->ajax_post() : NULL;
		
		}
	
	function get_url(){
		return $_REQUEST;
		}
	
	
	function make_url($string){
		return $string;
		}
	
	function get_page(){
		$url = $this->get_url();
		$page = isset($url['page']) ? $url['page'] : false; 
		return $page;
		}
		
	function ajax_post(){
		global $input_manager;
		echo $input_manager->responce ;
		exit;;
		}
	function open_ajax_page(){
		$filename = isset($_POST['pagename']) ? $_POST['pagename'] : false;
		$filename = strtolower($filename);
		$filename = str_replace('.php','',$filename);
		$filename .= '.php';
		$dir = 'views/pages/';
		$error_file = 'views/pages/home.php';
		$filename = $dir.$filename;
		$check = file_exists($filename);
		$check ? include $filename : include $error_file;
		exit;
		}
	
	function open_page(){
		$filename = $this->get_page();
		$filename = strtolower($filename);
		$filename = str_replace('.php','',$filename);
		$filename .= '.php';
		$dir = 'views/pages/';
		$error_file = 'views/pages/home.php';
		$filename = $dir.$filename;
		$check = file_exists($filename);
		$check ? include $filename : include $error_file;
		return $check;
		}
	
	function open_file($filename = false){
		//sleep(4	);
		$filename = $filename  ? $filename : false;
		$filename = (!$filename and isset($_POST['filename'])) ? $_POST['filename'] : $filename;
		$filename = strtolower($filename);
		$filename = str_replace('.php','',$filename);
		$filename .= '.php';
		$dir = 'views/file/';
		$error_file = 'views/includes/error.php';
		$filename = $dir.$filename;
		$check = file_exists($filename);
		$check ? include $filename : include $error_file;
		
		exit;
		}	
		
		function open_form($filename = false){
		//sleep(4	);
		$filename = $filename  ? $filename : false;
		$filename = (!$filename and isset($_POST['filename'])) ? $_POST['filename'] : $filename;
		$filename = strtolower($filename);
		$filename = str_replace('.php','',$filename);
		$filename .= '.php';
		$dir = 'views/forms/';
		$error_file = 'views/includes/error.php';
		$filename = $dir.$filename;
		$check = file_exists($filename);
		$check ? include $filename : include $error_file;
		
		exit;
		}
	
	
	function include_file($filename){
		$filename = strtolower($filename);
		$filename = str_replace('.php','',$filename);
		$filename .= '.php';
		$dir = 'views/includes/';
		$error_file = 'views/includes/error.php';
		$filename = $dir.$filename;
		$check = file_exists($filename);
		$check ? include $filename : include $error_file;
		return $check;
		}
	
	function is_page($page){
		$page = $this->get_url();
		return $page['page'] == 'home' ? true : false;
		}
	
	}

