
      <!-- Not Worable COde           -->
      <ul class="dropdown-menu" style="width: 100px; position: absolute;">
        <?php 
          
          $get_requests = get_job_request($_SESSION['jobme_portal_userID']);
          if($get_requests != null){
            foreach($get_requests as $request){
              ?>
              <li class=" bg-dark p-3 m-1 text-light">
              <?php
                
              $getNotifcationSenderInfo = getUserByID($request[3]);
              $getNotificationJobInfo = getJobByID($request[1]);

              echo $getNotifcationSenderInfo[0][1] . " " . $getNotifcationSenderInfo[0][2];
              echo "<br>";
              echo "<br>";
              echo "Job_Title: " +$getNotificationJobInfo[0][1];
              echo "<br>";
              echo "Job_Descritption: " +$getNotificationJobInfo[0][2];
              echo "<button class='btn btn-success' onclick='window.location.href = \"https://jobme.pk\"'>APPROVE</button>";
              echo "<button class='btn btn-warning' onclick='window.location.href = \"https://jobme.pk\"'>DECLINE</button>";
              
                ?>
                </li>
              <?php
            }
          }else {
            echo "<a href='#'><li>No Request Have u</li></a>";
          }                
        ?>
      </ul>
      <!-- Not WOrabke COde -->

      <!-- Employee Code -->
       <!-- if($get_Hire_Requests !=null){ 
            //   foreach($get_Hire_Requests as $hire_request){
            //     $company = get_CompnayByID($hire_request[2]);

            //     echo "<p class='font-weight-bolder p-1 m-0'> $hire_request[4] </p>";//JobTitle
            //     echo  "<p class='m-0' style='color:green;'>". $hire_request[5] . ": &nbsp;&nbsp; PkR: ".$hire_request[6] ."<br>";
            //     if($company != null){
            //       echo  "<p> ". $company[0][1] ."</p>";
            //     }else{
            //       echo "<br>";
            //     }          

            //     echo "<button class='btn btn-success' onclick=redirectTo('?page=approved_hireRequest&To_UserID=".$hire_request[1]."&From_UserID=".$hire_request[2]."');>APPROVE</button>";
            //     echo "&nbsp; &nbsp; <button class='btn btn-warning' onclick=redirectTo('?page=decline_hirerequest&To_UID=". $hire_request[1] ."&From_UID=". $hire_request[2]."')>DECLINE</button><hr>";

            //   }
            // } -->
      <!-- Employee Code -->

      <!-- Employer Code -->
        <!-- foreach($get_requests as $request){
           ?> -->
          <!-- //   <a class="dropdown-item waves-effect waves-light mb-1" href="#" style="border-radius: 5px; background: RGB(222, 222, 222);"> -->
              <?php
          //   $getNotifcationSenderInfo = getUserByID($request[3]);
          //   $getNotificationJobInfo = getJobByID($request[1]);
          //   if($getNotifcationSenderInfo != null && $getNotificationJobInfo != null){
          //     $getUserImage = "resources\images\JobMe.png";
          //     echo "<img class='rounded-lg mt-1' src=' ". $getUserImage ."' width='50' height='50'>";                  
          //     echo "&nbsp; &nbsp;" . $getNotifcationSenderInfo[0][1] . " " . $getNotifcationSenderInfo[0][2];
          //     echo "<br>";
          //     echo "Job_Title: <br>" .$getNotificationJobInfo[0][1] . "<br>";
          //     echo "Job_Description: <br>" .$getNotificationJobInfo[0][2] ."<br><br>";
                
          //     echo "<button class='btn btn-success' onclick='window.location.href = \"?page=approved_request&SenderUID=". $getNotifcationSenderInfo[0][0]."&Request_JID=".$getNotificationJobInfo[0][0]." \"'>APPROVE</button>";
          //     echo "&nbsp; &nbsp; <button class='btn btn-warning' onclick='window.location.href = \"?page=decline_request&SenderUID=". $getNotifcationSenderInfo[0][0]."&Request_JID=".$getNotificationJobInfo[0][0]." \"'>DECLINE</button>";
          //   }
          //   ?>
              <!-- </a> -->
              <?php
          
          // }

  // <ul class="dropdown-menu" style="width: 100px; position: absolute;">
  //           <?php 
              
  //             $get_requests = get_job_request($_SESSION['jobme_portal_userID']);
  //             if($get_requests != null){
  //               foreach($get_requests as $request){
  //                 ?>
  <!-- //                 <li class=" bg-dark p-3 m-1 text-light"> -->
  <!-- //                 <?php 
  //                 $getNotifcationSenderInfo = getUserByID($request[3]);
  //                 $getNotificationJobInfo = getJobByID($request[1]);

  //                 echo $getNotifcationSenderInfo[0][1] . " " . $getNotifcationSenderInfo[0][2];
  //                 echo "<br>";
  //                 echo "<br>";
  //                 echo "<button class='btn btn-success' onclick='window.location.href = \"https://jobme.pk\"'>APPROVE</button>";
  //                 echo "<button class='btn btn-warning' onclick='window.location.href = \"https://jobme.pk\"'>DECLINE</button>";
                  
  //                  ?>
  //                  </li>
  //                 <?php
  //               }
  //             }else {
  //               echo "<a href='#'><li>No Request Have u</li></a>";
  //             }                
  //           ?>
  //         </ul>