<?php

class Member extends MX_Controller
{
    var $dtable = 'tbl_member';

    function __construct()
    {
        // PHP Version 5.4
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }

        $postdata = json_decode(file_get_contents("php://input"));
        if(is_object($postdata))
        {
            $this->restapi->__postdata($postdata);
        }

        $this->restapi->__auth();
        $this->load->model('member_model');
    }

    function save()
    {


        if($_POST)
        {
            
            $username = $this->input->post('username');
            $name = $this->input->post('name');
            $email  = $this->input->post('email');
            $password  = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');
            $phone    = $this->input->post('phone');
            $address  = $this->input->post('address');
            $zipcode = $this->input->post('zip');
            $city = $this->input->post('city');
            $gender = $this->input->post('gender');
            $about = $this->input->post('about');
            $member_type = $this->input->post('member_type');
            $join_date =  $this->input->post('join_date');
            $active = $this->input->post('active');
            $verification = $this->input->post('verification');

            $dt1 =[
                'name ' => $name,
                'username' => $username,
                'fullname' => $name,
                'email' => $email,
                'password' => md5($password),
                'profile_pic' => '1',
                'phone' => $phone,
                'address' => $address,
                'city' => $city,
                'zip'  => $zipcode,
                'gender'=> $gender,
                'about' => $about,
                'member_type' => $member_type,
                'join_date'   => $join_date,
                'active'    => $active,
                'last_online' => null,
                'visit'  => '1',
                'verification' => '1'];

                try{
                    $option = $this->user_validation($this->input->post());
                    if(!is_array($option)){
                        throw new Exception("user validation error", 1);    
                    }
                }
                catch(Exception $e){
                    $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt1));
                }
                if ($option['state'] == 0) {
                    $this->validation->error_message($option);
                return false;
                }
             $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }
        $this->__rest()->__response($data, $status);

    }        

    function update()
    {
        if($_POST)
        {
            
        $dt1 =[
            'name ' => $this->input->post('name'),
            'username' => $this->input->post('username'),
            'fullname' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'profile_pic' => '1',
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address'),
            'city' => $this->input->post('city'),
            'zip'  => $this->input->post('zipcode'),
            'gender'=> $this->input->post('gender'),
            'about' => $this->input->post('about'),
            'join_date'   => $this->input->post('join_date'),
            'active'    => $this->input->post('active'),
            'last_online' => null];

            $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt1,
                                                  'where' => array('id_member' => $this->input->post('idx'))));
            if ($option['state'] == 0) {

                $this->validation->error_message($option);
                return false;
            }

           

            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

    function delete()
    {
 
        if($_POST)
        {
            $option = $this->member_model->__delete($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

    function disable()
    {
        if($_POST)
        {
            $option = $this->member_model->__disable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

    function enable()
    {
        if($_POST)
        {
            $option = $this->member_model->__enable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }
    function checkUsername($username = ''){
        $query  = ['page' => '1','limit' => '10','search'=> $username];
        $find  = $this->excurl->reqCurl('me',$query)->data[0];
        if(count ($find) > 0 ) {
            return true;
        }
        return false;

    }
    function user_validation($data = array()){
        $option['state'] = 1;
        $option['add_message'] = ['xcss'=> 'boxfailed','affected'=> 1];
        $select = array('username');

        if($this->input->post('uname')){
            $where = array('username'=> $this->input->post('uname'));
            $res = [];

            if(count($this->member_model->findUser($this->dtable,$where,$select)) > 0 ){
                $res  = ['xcss' => 'boxfailed','message'=> 'username exist'];
            }else{
                $res  = ['xcss'=> 'boxsuccess','message'=> 'doesn\'t exist'];
            }
            echo  json_encode($res);
            exit;
        }
        $where  = array('username'=> $data['username']);
        
        if($data['password'] !== $data['cpassword']){
            $option['message'] ='your password confirmation doesn\'t match ';
        }
        elseif(count($this->member_model->findUser($this->dtable,$where,$select)) > 0 ){
            $option['message'] =  'username exist ';
        }
        else{
            return true;
        }

        return $option; 
    }
}