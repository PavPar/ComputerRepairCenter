<?php
include "db.php";

function retriveUserData()
{
    $user = array(
        "name" => "null",
        "password" => "null",
    );
    $user['name'] = getData("user_login", true);
    $user['password'] = getData("user_password", true);
    return $user;
};

if(userValidation(retriveUserData())){
    if(checkPrivalge()){
        header('Location: ./admin.php');
    }else{
        header('Location: ./master.php');
    }
}else{
    header('Location: ../index.php');
}
