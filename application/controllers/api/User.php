<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class User extends REST_Controller {

    function __construct() {
        parent::__construct();
    }

    //header
    //X-API-KEY 123456
    //http://localhost/CodeIgniter-3.0.4/api/user/user?id=1
    public function user_get() {
        //declare model
        $this->load->model('Model_user');
        //get from url
        $user_id = $this->get('id');
        if ($user_id) {
            //get user by id to database 
            $user = $this->Model_user->get_by(array('user_id' => $user_id));
            if (isset($user['user_id'])) {
                //get data with active status
                $this->response(array('status' => 'success', 'message' => $user, 'status' => 1));
            } else {
                $this->response(array('status' => 'failure', 'message' => 'No users were found'), REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            //get all user to database 
            $user = $this->Model_user->get_all();
            if (isset($user)) {
                //get data with active status
                $this->response(array('status' => 'success', 'message' => $user, 'status' => 1));
            } else {
                $this->response(array('status' => 'failure', 'message' => 'No users were found'), REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
    //insert data
    public function user_post() {
        //declare model
        $this->load->model('Model_user');
        //get post data array
        $data = $this->post();
        //check if email is exist
        $isEmail = $this->Model_user->get_by(array('user_email' => $data['user_email']));
        if (!$isEmail) {
            //insert to database and get new ID
            $user_id = $this->Model_user->insert($data);
            if ($user_id) {
                $this->response(array('status' => 'success', 'message' => 'created'));
            } else {
                $this->response(array('status' => 'failure', 'message' => 'error'), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $this->response(array('status' => 'failure', 'message' => 'email already exist'), REST_Controller::HTTP_CONFLICT);
        }
    }

    //update data
    public function user_put() {
        //declare model
        $this->load->model('Model_user');
        //get put data array
        $data = $this->put();
        //get id
        $user_id = $data['user_id'];
        //check if want to update email
        if (isset($data['user_email'])) {
            //check if email is exist
            $isEmail = $this->Model_user->get_by(array('user_email' => $data['user_email']));
            if (!$isEmail) {
                //call update function
                $this->update($user_id, $data);
            } else {
                $this->response(array('status' => 'failure', 'message' => 'email already exist'), REST_Controller::HTTP_CONFLICT);
            }
        } else {
            //call update function
            $this->update($user_id, $data);
        }
    }

    public function user_delete($id) {
//        declare model
        $this->load->model('Model_user');
//        delete return true or false
        $isDelete = $this->Model_user->delete($id);
        if ($isDelete) {
            $this->response(array('status' => 'success', 'message' => 'deleted'));
        } else {
            $this->response(array('status' => 'failure', 'message' => 'error'), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function update($id, $data) {
        //update to database return true or false
        $isUpdate = $this->Model_user->update($id, $data);
        if ($isUpdate) {
            $this->response(array('status' => 'success', 'message' => 'updated'));
        } else {
            $this->response(array('status' => 'failure', 'message' => 'error'), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
