<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notfound extends CI_Controller {

	public function index()
	{
		$data['title']="Error 404";
		$data['subtitle']="Page Not Found";
		$data['vie_isi']="view_404";
		$data['descripcion']="descripcion web";

		$this->load->view('view_404',$data);
	}
}