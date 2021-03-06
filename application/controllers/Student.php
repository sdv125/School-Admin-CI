<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class student extends CI_Controller {

    public function studentAdd()
    {
        $submit = $this->input->post('submit',TRUE);
        if ($submit == "Submit"){
            $data['NAME'] = $this->input->post('name',TRUE);
            $data['FNAME'] = $this->input->post('father',TRUE);
            $data['CONTACT'] = $this->input->post('phone',TRUE);
            $data['ROLL'] = $this->input->post('roll',TRUE);
            $data['CLASS'] = $this->input->post('class',TRUE);
            $data['ADDRESS'] = $this->input->post('address',TRUE);
            $data['ACADFEE']=-1;
            $data['CONVFEE']=-1;
            $this->_insert($data);
        }
    }
    public function search(){
        $this->load->view('navbar');
        $this->load->view('search');
    }

    public function home(){

        $this->load->view('webnav');
        $this->load->view('home');

        $this->load->view('webfooter');
    }
    public function services(){
        $this->load->view('webnav');
        $this->load->view('services');
        $this->load->view('webfooter');
    }
    public function events(){
        $this->load->view('webnav');
        $this->load->view('events');
        $this->load->view('webfooter');
    }
    public function gallery(){
        $this->load->view('webnav');
        $this->load->view('gallery');
        $this->load->view('webfooter');
    }
    public function mail(){
        $this->load->view('webnav');
        $this->load->view('mail');
        $this->load->view('webfooter');
    }
//    public function short_codes(){
//        $this->load->view('webnav');
//        $this->load->view('short_codes');
//        $this->load->view('webfooter');
//        }

    public function single(){
        $this->load->view('webnav');
        $this->load->view('single');
        $this->load->view('webfooter');
    }


    public function unpaidList(){
        $list=array();
        $query = "select * from students";
        $return = $this->_custom_query($query);
        foreach ($return->result() as $k){
            $tst=$k->ACADFEE;
            if($tst != NULL && $tst!='-1') {
                $date1 = date_create("30-" . $tst);
                $date2 = date_create("now");
                $diff = date_diff($date1, $date2);
                $result = $diff->m;
                if ($result>3){
                    array_push($list, $k->id);
                }
            }
        }
        $sql = 'SELECT * FROM `students` WHERE `id` IN (' . implode(',', array_map('intval', $list)) . ')';
        $return = $this->_custom_query($sql);
        $data['return']=$return;
//        echo "<pre>";print_r($return->result());
        $this->load->view('navbar');
        $this->load->view('unpaidFee',$data);

    }


    public function updateConvFee(){
        $submit=$this->input->post('submit',TRUE);
        if ($submit=="Submit"){
            $mon=$this->input->post('mon');
            $year=$this->input->post('year');
            $acadDate=$mon."-".$year;
            $roll=$this->input->post('rollno',TRUE);
            $query = "UPDATE students SET CONVFEE='".$acadDate."' WHERE ROLL='".$roll."'";
            $this->_custom_query($query);
            echo "<script language=\"javascript\">alert('Fee updated Successfully');</script>";

        }
    }

    public function updateFee(){
        $submit=$this->input->post('submit',TRUE);
        if ($submit=="Submit"){
            $mon=$this->input->post('mon');
            $year=$this->input->post('year');
            $acadDate=$mon."-".$year;
            $roll=$this->input->post('rollno',TRUE);
            $query = "UPDATE students SET ACADFEE='".$acadDate."' WHERE ROLL='".$roll."'";
            $this->_custom_query($query);
            echo "<script language=\"javascript\">alert('Fee updated Successfully');</script>";

        }
    }
    public function findStudent()
    {

        $submit=$this->input->post('submit',TRUE);
        if($submit== "FIND BY ROLL NUMBER");
        {
            $roll=$this->input->post('roll',TRUE);
            $query = "select * from students where ROLL = '$roll'";
            $return = $this->_custom_query($query);
            foreach ($return->result() as $row)
            {
                $data['id'] = $row->id;
                $data['NAME'] = $row->NAME;
                $data['FNAME'] = $row->FNAME;
                $data['CONTACT'] = $row->CONTACT;
                $data['ROLL'] = $row->ROLL;
                $data['CLASS'] = $row->CLASS;
                $data['ADDRESS'] = $row->ADDRESS;
                $data['ACADFEE'] = $row->ACADFEE;
                $data['CONVFEE'] = $row->CONVFEE;
            }
            $this->load->view('navbar');
            $this->load->view('studentView',$data);
        }
    }
    function _custom_query($mysql_query)
    {
        $this->load->model('User_model');
        $query = $this->User_model->_custom_query($mysql_query);
        return $query;
    }
    function _insert($data)
    {
        $this->load->model('User_model');
        $this->User_model->_insert($data);
    }
    function get_where($id)
    {
        if (!is_numeric($id)) {
            die('Non-numeric variable!');
        }

        $this->load->model('User_model');
        $query = $this->User_model->get_where($id);
        return $query;
    }
}
