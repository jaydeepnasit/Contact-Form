<?php

require_once '../oops/config.php';
$UDF = new Config();

$json_data = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if( (isset($_POST['name']) && !empty(trim($_POST['name']))) && (isset($_POST['subject']) && !empty(trim($_POST['subject']))) && (isset($_POST['email']) && !empty(trim($_POST['email']))) && (isset($_POST['phone']) && !empty(trim($_POST['phone']))) && (isset($_POST['msg']) && !empty(trim($_POST['msg']))) ){

        $name = $UDF->htmlvalidation($_POST['name']);
        $subject = $UDF->htmlvalidation($_POST['subject']);
        $email = $UDF->htmlvalidation($_POST['email']);
        $phone = $UDF->htmlvalidation($_POST['phone']);
        $msg = $UDF->htmlvalidation($_POST['msg']);

        if( (strlen($name) >= 3 && strlen($name <= 100)) && (strlen($subject) >= 3 && strlen($subject <= 200)) && (strlen($msg) >= 3 && strlen($msg <= 5000)) && (strlen($email) <= 100) ){

            if( preg_match('/^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/', $name) && preg_match('/^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/', $subject) && preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email) && preg_match('/^(1\s?)?((\([0-9]{3}\))|[0-9]{3})[\s\-]?[\0-9]{3}[\s\-]?[0-9]{4}$/', $phone) ){

                $field_val['c_name'] = $name;
                $field_val['c_subject'] = $subject;
                $field_val['c_email'] = $email;
                $field_val['c_phone_no'] = $phone;
                $field_val['c_msg'] = $msg;

                $insert = $UDF->insert('contact_us', $field_val);

                if($insert){
                    $json_data['status'] = 200;
                    $json_data['msg'] = "Success";
                }
                else{
                    $json_data['status'] = 201;
                    $json_data['msg'] = "Issue Found";
                }

            }
            else{
                $json_data['status'] = 202;
                $json_data['msg'] = "Invalid Expression";
            }

        }
        else{
            $json_data['status'] = 203;
            $json_data['msg'] = "Invalid Format";
        }

    }
    else{
        $json_data['status'] = 204;
        $json_data['msg'] = "Invalid Format";
    }

}
else{
    $json_data['status'] = 205;
    $json_data['msg'] = "Invalid Request Method";
}

echo json_encode($json_data);

?>