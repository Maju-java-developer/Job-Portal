<?php

// ----------- Constants -----------

if(isset($_GET['page'])){
    if($_GET['page'] == 'login'){
        include_once('login.php');
    }else if($_GET['page'] == 'register'){
        include_once('register.php');
    }else{
        include_once('login.php');
    }
}else{
    include_once('login.php');
}

?>