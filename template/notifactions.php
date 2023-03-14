<?php
        ?>
        <div class="col-xl-12" style="background: rgb(233,244,234);">
            <?php 
                if($_SESSION['jobme_portal_type'] == "employee"){
                    $get_Hire_Requests = get_hire_request($_SESSION['jobme_portal_userID']);
                    ?>
                        <h5 class="pt-1 mt-2"> <?php echo "Hire Request: ". sizeof($get_Hire_Requests) ?> </h5> 
                    <?php
                } if($_SESSION['jobme_portal_type'] != "employee"){
                    $get_requests = get_job_request($_SESSION['jobme_portal_userID']);
                    ?>
                        <h5 class="pt-1 mt-2"> <?php echo "Job Request: ". sizeof($get_requests) ?> </h5> 
                    <?php
                }

            ?>
            <div class="p-0 m-0 mt-2 mb-1 p-2">
            <?php
                if($_SESSION['jobme_portal_type'] == "employee"){
                    employee_Notifications($get_Hire_Requests);
                }else if($_SESSION['jobme_portal_type'] != "employee"){
                    employer_Notifications($get_requests);
                }

            ?>
            </div>
        </div>
    <?php
?>