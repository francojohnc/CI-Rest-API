<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller {
     function __construct()
    {
        parent::__construct();
    }

    public function index(){
        echo 'welcome';
        echo date('m-d-Y H:i:s');
    }
}
