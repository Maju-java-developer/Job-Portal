<?php
    include_once('../inc/session.php');

    unset($_SESSION['jobme_portal_Valid']);
    unset($_SESSION['jobme_portal_userID']);
    unset($_SESSION['jobme_portal_userName']);
    unset($_SESSION['jobme_portal_address']);
    unset($_SESSION['jobme_portal_email']);
    unset($_SESSION['jobme_portal_type']);
    unset($_SESSION['jobme_portal_menu']);

    session_destroy();

    header('Location: /index/jobme_portal/?page=login');
?>