<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Model_user extends MY_Model{
    protected $_table = 'tbl_user';
    protected $primary_key = 'user_id';
    protected $return_type = 'array';
    protected $after_get = array('remove_sensitive_data');
    protected $before_create = array('prep_data');
    protected function remove_sensitive_data($user){
        unset($user['user_password']);
        unset($user['ip_address']);
        return $user;
    }
    protected function prep_data($user){
        $user['user_password'] = md5($user['user_password']);
        $user['ip_address'] = $this->input->ip_address();
//        $user['user_register_time']=date('m-d-Y H:i:s');
        return $user;
    }
}
