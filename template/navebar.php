<?php
      $conn = MySQlconnection();
      $MenuQuery = "SELECT * FROM menus;";
      $resultMenu = $conn->query($MenuQuery) or die("Error: " . $conn->error);

      $rows = $resultMenu->fetch_all(PDO::FETCH_ASSOC);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">JobME.pk</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
        
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php
      foreach($rows as $row){
        if(isset($_SESSION['jobme_portal_menu'])){
          // echo "<h1 style='color: white;'>". $_SESSION['menu'] ."</h1>";
          if($row[5] == $_SESSION['jobme_portal_menu']){
            $menuTitle = explode(",",$row[1]);
            $menuLinks = explode(",",$row[3]);
            
            for($i = 0; $i <sizeof($menuTitle); $i++){
              if(strpos($menuTitle[$i],"|") === false ){
                if($i == 0){
                  echo "<li class='nav-item active'>
                  <a class='nav-link'href='". $menuLinks[$i] ."'>$menuTitle[$i]<span class='sr-only'>(current)</span></a>
                  </li>";
                }else {
                  if($menuTitle[$i] == "Notifications"){
                    ?>
                    <script>
                      if(getDocWidth() > 480){
                      }else{
                        document.writeln("<?php echo "<li class='nav-item'><a class='  nav-link' href='". $menuLinks[$i] ."'>". $menuTitle[$i] ."<span class='sr-only'>(current)</span></a></li>";?>");
                      }
                    </script>
                    <?php
                    // echo "<li class='nav-item'>
                    // <a class='  nav-link' href='". $menuLinks[$i] ."'><script>document.writeln(getDocWidth());</script><span class='sr-only'>(current)</span></a>
                    // </li>";
                  }else{
                    echo "<li class='nav-item'>
                    <a class='  nav-link' href='". $menuLinks[$i] ."'>$menuTitle[$i]<span class='sr-only'>(current)</span></a>
                    </li>";
                  }
                }
              }else {
                $SubTitleMenu = explode("|", $menuTitle[$i]);
                $subMenulinks = explode("|", $menuLinks[$i]);

                echo"<li class='nav-item dropdown'>";
                for($x = 0; $x < sizeof($SubTitleMenu); $x++){
                  if($x == 0){
                    echo "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> " .
                    $SubTitleMenu[$x] 
                    ."</a>";
                    echo "<div class='dropdown-menu' aria-labelledby='navbarDropdown'>";
                  }

                  if($x < sizeof($SubTitleMenu) && $x != 0){
                    if($_SESSION['jobme_portal_type'] == "employee"){
                      if ($SubTitleMenu[$x] != " Available Resumes " && $SubTitleMenu[$x] != " Post New Job " && $SubTitleMenu[$x] != " Post New Company "){
                        echo "<a class='dropdown-item' href=' ". $subMenulinks[$x]." '>$SubTitleMenu[$x]</a>";
                      }

                    }else if($_SESSION['jobme_portal_type'] == "employer"){
                      if ($SubTitleMenu[$x] != " Post New Resume " && $SubTitleMenu[$x] != " Post New Company"){
                        echo "<a class='dropdown-item' href=' ". $subMenulinks[$x]." '>$SubTitleMenu[$x]</a>";
                      }
                    }else if($_SESSION['jobme_portal_type'] == "admin"){
                      if ($SubTitleMenu[$x] != " Post New Resume "){
                        echo "<a class='dropdown-item' href=' ". $subMenulinks[$x]." '>$SubTitleMenu[$x]</a>";
                      }
                    }

                  }

                  if($x == sizeof($SubTitleMenu)-1){
                    echo "</div>";
                  }
                }
              }
                echo "</li>";
              }
            }
          }
        }
      ?>
    </ul>

    <?php
    if(isset($_SESSION['jobme_portal_Valid'])){
      if(isset($_SESSION['jobme_portal_Valid']) == true){
    ?>
    <div class="form-inline my-2 my-lg-0">
      <?php
        if(isset($_GET['page'])){
          if($_GET['page'] == "availableJobs"){
            ?>
              <input class="form-control mr-sm-2" id="search" type="search" name="search" placeholder="Search Jobs" aria-label="Search">
              <button class="btn btn-secondary my-2 my-sm-0 mr-lg-1" name="searchBtn" onclick="getJobSearchValue()">Search</button>
            <?php
          }else if($_GET['page'] == "availabelResumes"){
            ?>
              <input class="form-control mr-sm-2" id="search" type="search" name="resumeSsearch" placeholder="Search Resumes" aria-label="Search">
              <button class="btn btn-secondary my-2 my-sm-0 mr-lg-1" name="resumeSearchBtn" onclick="getResumeSearchValue()">Search</button>
            <?php    
          }else {
            ?>
              <input class="form-control mr-sm-2" id="search" type="search" name="search" placeholder="Search Job" aria-label="Search">
              <button class="btn btn-secondary my-2 my-sm-0 mr-lg-1" name="searchBtn" onclick="getJobSearchValue()">Search</button>
            <?php
          }      
        } 
      ?>
    </div>
    <?php

    // if($_SESSION['jobme_portal_type'] != "employee"){
      ?>
        <div class="dropdown m-0 p-0">
        <div class="collapse navbar-collapse" id="navbarSupportedContent-5">
       
          <ul class="navbar-nav ml-auto nav-flex-icons">
            <li class="nav-item avatar dropdown">
              <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <span class="badge badge-danger ml-2">
                <?php
                if($_SESSION['jobme_portal_type'] != "employee"){
                    $get_requests = get_job_request($_SESSION['jobme_portal_userID']);
                    echo sizeof($get_requests);
                  }else if($_SESSION['jobme_portal_type'] == "employee"){
                    $get_Hire_Requests = get_hire_request($_SESSION['jobme_portal_userID']);
                    echo sizeof($get_Hire_Requests);
                  }
                  ?>
                </span>
                <i class="fas fa-bell"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-lg-right dropdown-secondary p-1" aria-labelledby="navbarDropdownMenuLink-5">
              <p class='m-1'>From Notifaction:</p>
              <?php 
              if($_SESSION['jobme_portal_type'] != "employee"){
                if($get_requests != null){
                  employer_Notifications($get_requests);
                }else {
                  ?>
                    <a class="dropdown-item waves-effect waves-light mb-1" href="#" style="border-radius: 5px; background: RGB(222, 222, 222);">
                      <?php echo "No Job Request For You!"?>
                    </a>
                  <?php
                }

                }else if($_SESSION['jobme_portal_type'] == "employee"){
                  ?>
                    <a class="dropdown-item waves-effect waves-light mb-1" href="#" style="border-radius: 5px; background: RGB(222, 222, 222);">
                     <?php
                        employee_Notifications($get_Hire_Requests);
                      ?> 
                    </a>
                  <?php
                }
              ?>
              </div>
            </li>
          </ul>
        </div>
            <!-- NoT working code -->
        </div>
    <?php
    // }
     }
    }
  ?>

  </div>
</nav>

<?php

?>