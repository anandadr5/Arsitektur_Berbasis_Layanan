<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Hospital extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Hospital_model', 'hospital');

        $this->methods['index_get']['limit'] = 10;
    }
    
    public function index_get()
    {
        $id = $this->get('id');
        if($id == null) {
            $hospital = $this->hospital->getHospital();
        } else {
            $hospital = $this->hospital->getHospital($id);
        }
        
        if ($hospital) {
            $this->response([
                'status' => true,
                'data' => $hospital
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found!'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if( $id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if( $this->hospital->deleteHospital($id) > 0) {
                // ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted'
                ], REST_Controller::HTTP_OK);
            } else {
                // id not found
                $this->response([
                    'status' => false,
                    'message' => 'id not found!'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'id' => $this->post('id'),
            'hospital_name' => $this->post('hospital_name'),
            'address' => $this->post('address'),
            'phone' => $this->post('phone')

        ];

        if( $this->hospital->createHospital($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'new hospital has been created'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'hospital_name' => $this->put('hospital_name'),
            'address' => $this->put('address'),
            'phone' => $this->put('phone')
        ];

        if( $this->hospital->updateHospital($data, $id) > 0){
            $this->response([
                'status' => true,
                'message' => 'data hospital has been updated'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to update data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}