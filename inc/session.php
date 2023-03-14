<?php
    ob_start();
    session_start();

    if(!isset($_SESSION['jobme_portal_menu'])){
        $_SESSION['jobme_portal_menu'] = 'Logged_Out';
    }

?>