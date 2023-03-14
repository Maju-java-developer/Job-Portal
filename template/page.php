<?php

    if(isset($_SESSION['jobme_portal_Valid'])){
        if($_SESSION['jobme_portal_Valid'] == true){
            if(isset($_GET['page'])){
                if($_GET['page'] == 'main'){
                    include_once('main.php');
                }
                else if($_GET['page'] == 'PostNewJob'){
                    include_once('PostNewJob.php');
                }
                else if($_GET['page'] == 'PostNewCompany'){
                    include_once('PostNewCompany.php');
                }
                else if ($_GET['page'] == "PostNewResume"){
                    include_once('PostNewResume.php');
                }
                else if ($_GET['page'] == "availabelResumes"){
                    include_once('AvailabelResumes.php');
                }
                else if ($_GET['page'] == "availableCompanies"){
                    include_once("template/availableCompanies.php");
                }
                else if ($_GET['page'] == "notifications"){
                    include_once("template/notifactions.php");
                }
                else if($_GET['page'] == 'send_request'){
                    sendRequest();
                }
                else if ($_GET['page'] == 'cancel_request'){
                    cancelRequest();
                }
                else if($_GET['page'] == "approved_request"){
                    approve_job_request();
                }
                else if ($_GET['page'] == "decline_request"){
                    decline_request();
                }
                else if($_GET['page'] == "delete_job"){
                    delete_job();
                }
                else if($_GET['page'] == "update_job"){
                    updateJob();
                }
                else if($_GET['page'] == "hire_request"){
                    hire_request();
                }
                else if($_GET['page'] == "approved_hireRequest"){
                    approved_hire_reqeust();
                }
                else if($_GET['page'] == "cancel_hireRequest"){
                    cancel_hire_request();
                }
                else if($_GET['page'] == "decline_hirerequest"){
                    cancel_hire_request();
                }
                else if($_GET['page'] == 'logout'){    
                    $_SESSION['menu'] = 'Logged_Out';
                    header('Location: template/logout.php');
                }else{
                    include_once('main.php');
                }
            }else{
                include_once('main.php');
            }
        }
    }else{
        $_SESSION['jobme_portal_menu'] = 'Logged_Out';
        include_once('authenticate.php');
    }
?>