<?php

    function mySQLConnection(){
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "jobme_portal";

        $conn = new mysqli($host,$username,$password,$database);
        return $conn;
    }

    function isLogin($email, $password){
        $query = "SELECT * FROM users WHERE email = '". $email . "' AND password = '". $password ."';";
        $conn = MySQlconnection();
        $resultUser = $conn->query($query) or die("Error: " . $conn->error);
  
        $userRows = $resultUser->fetch_all(PDO::FETCH_ASSOC);

        foreach($userRows as $row){
            if($row[4] == $email && $row[5] == $password){
                return $row;
            }else {
                return null;
            }
        }
        return null;
    }

    function isEmailExit($email ,$conn){
        $query = "SELECT Email FROM users WHERE email = '". $email ."'";

        $reusltResult = $conn->query($query) or die("Error: " . $conn->error);
        $userRow = $reusltResult->fetch_all(PDO::FETCH_ASSOC);

        foreach($userRow as $row){
            if($row[0] == $email){
                return true;
            }else {
                return false;
            }
        }

        return false;   
    }

    function generateRID(){
        $randomiseOne = random_int(1,9999);
        $randomiseTwo = random_int(1,999);
        $randomiseThree = random_int(1,9999);

        $totalRandom = $randomiseOne ."_". $randomiseTwo ."_". $randomiseThree; 

        return $totalRandom;
    }

    function addUser($first_name,$last_name,$address,$email,$password,$usertype){

        $conn = mySQLConnection();
        $RID = generateRID();

        $insertUserQuery = "INSERT INTO users "
        . "(First_Name,Last_Name,Address,Email,Password,RID,type)VALUE " 
        ."('". $first_name ."', '". $last_name ."', '". $address ."' ,'". $email ."', '". $password ."','" . $RID. "','". $usertype ."')";

        $reusltResult = $conn->query($insertUserQuery) or die ("Error: " . $conn->error);

        if($reusltResult == 1){
            echo $reusltResult . "Record has been inserted successfully!";
        }else {
            echo "Something went Wrong!";
        } 
    }

    function getUserByID($id){

        $conn = mySQLConnection();
        $userQuery = "SELECT * FROM users WHERE UID = $id;";

        $resultSet = $conn->query($userQuery) or die($conn->error);  
        $userRow = $resultSet->fetch_all(PDO::FETCH_ASSOC);

        return $userRow;
    }

    function getCategories(){

        $conn = mySQLConnection();
        $jobTitleQuery = "SELECT * FROM categories;";

        $resultSet = $conn->query($jobTitleQuery) or die($conn->error);  
        $catRow = $resultSet->fetch_all(PDO::FETCH_ASSOC);

        return $catRow;
    }
    
    function cateogiesSideBar($page){
        ?>
        <?php
    }

    function getJobByCategory($catID){

        $conn = mySQLConnection();
        $jobTitleQuery = "SELECT JID, JobTitle,JobDescription,JobVacancies,JobExpiryDate FROM jobs WHERE CatID = ". $catID ." ORDER BY JobPostDate DESC;";

        $resultSet = $conn->query($jobTitleQuery) or die($conn->error);  
        $catRow = $resultSet->fetch_all(PDO::FETCH_ASSOC);

        return $catRow;
    }

    function getAllJobs(){

        $conn = mySQLConnection();
        $jobTitleQuery = "SELECT * FROM jobs ORDER BY JobPostDate DESC;";

        $resultSet = $conn->query($jobTitleQuery) or die($conn->error);  
        $jobsRow = $resultSet->fetch_all(PDO::FETCH_ASSOC);

        return $jobsRow;
    }

    function getJobByID($id){

        $conn = mySQLConnection();
        $jobTitleQuery = "SELECT * FROM jobs WHERE JID = ". $id ." ORDER BY JobPostDate DESC;";

        $resultSet = $conn->query($jobTitleQuery) or die($conn->error);  
        $catRow = $resultSet->fetch_all(PDO::FETCH_ASSOC);
        return $catRow;
    }

    function getJobsByPublisher_UID($id){

        $conn = mySQLConnection();
        $jobTitleQuery = "SELECT * FROM jobs WHERE Publisher_UID = ". $id ." ORDER BY JobPostDate DESC;";

        $resultSet = $conn->query($jobTitleQuery) or die($conn->error);  
        $jobRow = $resultSet->fetch_all(PDO::FETCH_ASSOC);

        return $jobRow;
    }

    function getLimitedJobFields(){

        $conn = mySQLConnection();
        $jobTitleQuery = "SELECT JID, JobTitle,JobDescription,JobVacancies,JobExpiryDate FROM jobs ORDER BY JobPostDate DESC";

        $resultSet = $conn->query($jobTitleQuery) or die($conn->error);  
        $catRow = $resultSet->fetch_all(PDO::FETCH_ASSOC);

        return $catRow;
    }

    function getSearchedJobs($search){

        $conn = mySQLConnection();
        $jobTitleQuery = "SELECT JID, JobTitle,JobDescription,JobVacancies,JobExpiryDate FROM jobs WHERE JobTItle LIKE ('%". $search ."%') ORDER BY JobPostDate DESC;";

        $resultSet = $conn->query($jobTitleQuery) or die($conn->error);  
        $catRow = $resultSet->fetch_all(PDO::FETCH_ASSOC);

        return $catRow;
    }

    // function categoryType($type){
    //     $query = "SELECT * FROM jobs WHERE jobTitle = '". $type . "' ";
    // }

    function PostNewJob(
        $Title,
        $Vacancies,
        $Skills,
        $Experience,
        $Img,
        $Description,
        $CatID,
        $PostDate,
        $JoinBy,
        $ExpiryDate){
        
        $jobRID = generateRID();

        $conn = mySQLConnection();
        $query = "INSERT INTO jobs(
            JobTitle,
            JobDescription,
            JobImages,
            JobVacancies,
            JobSkills,
            JobExperience,
            JobPostDate,
            JobJoinBy,
            JobExpiryDate,
            CatID,
            jobRID,
            Publisher_UID
            ) VALUES ".
        "('". $Title ."', '". $Description ."' , '". $Img ."', '". $Vacancies ."', '". $Skills ."', ".
        "'". $Experience ."', '". $PostDate ."', '". $JoinBy ."', '". $ExpiryDate ."' ,$CatID,'". $jobRID ."', ". $_SESSION['jobme_portal_userID'].");";

        $result = mysqli_query($conn, $query) or die($conn->error);

        if($result){
            header('Location: ?page=main');
        }else {
            echo "<script>alert('Something went wrong Dear!')</script>";
        }
    }

    function delete_job(){
        if(isset($_GET['job_ID'])){
            $job_ID = $_GET['job_ID'];
            $query = "DELETE FROM jobs WHERE JID = $job_ID";

            $conn = mySQLConnection();

            if($conn->query($query) or die("Error: " .$conn->error)){
                header("Location: ?page=main");
            }else {
                echo "Someting went wrong1 ". $conn->error;
            }
        }
    }

    function postResume($resume_title,$reusme_category,$upload_resume,$resume_experience,$resume_skills,$resume_qualificaiton,$resume_expertise,$resume_type,$catID){

        $resumeRID = generateRID();

        $query = "INSERT INTO resumes(
            Resume_Title,
            Resume_Category,
            Upload_Resume,
            Resume_Experience,
            Resume_Skills,
            Resume_Qualificaton,
            Resume_Expertise,
            Resume_Type,
            Cat_ID,
            Resume_RID,
            Publisher_UID)VALUES(
            '". $resume_title ."',
            '". $reusme_category ."',
            '". $upload_resume ."',
            '". $resume_expertise ."',
            '". $resume_skills ."',
            '". $resume_qualificaiton ."',
            '". $resume_expertise ."',
            '". $resume_type ."',
            ". $catID .",
            '". $resumeRID ."',
            '". $_SESSION['jobme_portal_userID'] ."');";
        $conn = mySQLConnection();
            
        if($conn->query($query) or die ($conn->error)){
            header("Location: ?page=main");
        }else {
            echo "Something went wrong!". $conn->error;
        }
    }

    function uploadDocument($imageName, $imagePath){
        $errors = array();
        $file_name = $_FILES[$imageName]['name'];
        $file_size = $_FILES[$imageName]['size'];
        $file_tmp = $_FILES[$imageName]['tmp_name'];
        $file_type = $_FILES[$imageName]['type'];

        $extension = array("doc","docx","pdf");
        
        $fileExlodeExtension = explode(".",$_FILES[$imageName]['name']);

        $file_ext = strtolower(end($fileExlodeExtension));

        if(in_array($file_ext, $extension) == false){
            $errors[] = "extension not allowed, please choose a doc docx or pdf file!"; 
            echo $errors[] = "extension not allowed, please choose a doc docx or pdf file!"; 
        }

        if($file_size > 5000000){
            $errors[] = "File size must be excately 2 MB!";
        }

        if(empty($errors) == true){
            move_uploaded_file($file_tmp,$imagePath.$file_name);
            return $file_name;
        }else {
            return $errors;
        }
    }

    function getResumes(){
        $query = "SELECT * FROM resumes;";
        $conn = mySQLConnection();

        $getResume = $conn->query($query) or die ("Error: ".$conn->error);
        $Rows = $getResume->fetch_all(PDO::FETCH_ASSOC);
        
        return $Rows;
    }

    function getResumesByCatID($cat_ID){
        $query = "SELECT * FROM resumes WHERE Cat_ID = ". $cat_ID .";";
        $conn = mySQLConnection();

        $getResume = $conn->query($query) or die ("Error: ".$conn->error);
        $Rows = $getResume->fetch_all(PDO::FETCH_ASSOC);
        
        return $Rows;
    }

    function getSearchedResumes($search){

        $conn = mySQLConnection();
        $jobTitleQuery = "SELECT * FROM resumes WHERE Resume_Category LIKE ('%". $search ."%');";

        $resultSet = $conn->query($jobTitleQuery) or die($conn->error);  
        $catRow = $resultSet->fetch_all(PDO::FETCH_ASSOC);
        
        return $catRow;
    }

    function updateJob(){
        if(isset($_GET['job_Title']) && isset($_GET['job_Desc']) && isset($_GET['job_vanancies']) && isset($_GET['job_Skills']) && isset($_GET['job_Experience']) && isset($_GET['job_cat']) && isset($_GET['JobID'])){
            $conn = mySQLConnection();

            $job_title = $_GET['job_Title'];
            $job_Desc = $_GET['job_Desc'];
            $job_Skills = $_GET['job_Skills'];
            $job_Vacancies = $_GET['job_vanancies'];
            $job_Exprience = $_GET['job_Experience'];
            $job_cat = $_GET['job_cat'];
            $jobID = $_GET['JobID']; 

            $catRow =  getCatIDByTitle("$job_cat");
            $catID = $catRow[0][0];

            $query = "";
            if($job_cat != "-- Select Category --"){
                $query = "UPDATE jobs SET 
                JobTitle= '". $job_title."',
                JobDescription = '". $job_Desc."',
                JobVacancies = '". $job_Vacancies."',
                JobSkills = '". $job_Skills."',
                JobExperience = '". $job_Exprience ."',
                CatID = $catID WHERE JID = $jobID;";
            }else {
                $query = "UPDATE jobs SET 
                JobTitle= '". $job_title."',
                JobDescription = '". $job_Desc."',
                JobVacancies = '". $job_Vacancies."',
                JobSkills = '". $job_Skills."',
                JobExperience = '". $job_Exprience ."' WHERE JID = $jobID;";
            }

            if($conn->query($query) or die("Error: ".$conn->error)){
                header("Location: ?page=main");
            }else {
                echo "Somthing went wrong!" .$conn->error;
            }
        }
    }

    function isJobApproved($jobID, $PublisherID){
        $query = "SELECT * FROM job_requests WHERE Request_JID = '". $jobID. "' AND Request_Sent_From_UID = '". $_SESSION['jobme_portal_userID']."' AND Request_Sent_To_UID = '". $PublisherID."' AND Request_Status = 'Approved' ";
        
        $conn = mySQLConnection();

        $job_requests = $conn->query($query) or die("Error: " .$conn->error);
        $row = $job_requests->fetch_all(PDO::FETCH_ASSOC);

        foreach($job_requests as $request){
            if($request != null){
                return true; 
            }else {
                return false;
            }
        }
        return false;
    }

    function addCompany($company_title,$company_des,$company_PostDate,$company_JoinBy,$company_ExpiryDate,$company_Logo){
        $conn = mySQLConnection();
        $query = "INSERT INTO company(
            Company_Title,
            Company_Description,
            Company_Logo,
            Company_Post_Date,
            Company_Join_By,
            Company_Expiry_Date,
            Publisher_UID,
            Company_RID)VALUES(
            '". $company_title ."',
            '". $company_des ."', 
            '". $company_Logo ."',
            '". $company_PostDate ."',
            '". $company_JoinBy ."',
            '". $company_ExpiryDate ."',
            '". $_SESSION['jobme_portal_userID']."',
            3)";

        $result = $conn->query($query) or die ("Erorr: " .$conn->error);

        if($result){
            header("Location: ?page=main");
        } else {
            echo "Something went wrong!";
        }
       
    }

    // Function to get the client IP address
    function getIP() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    function addView(){
        $conn = mySQLConnection();

        if(isset($_GET['JID'])){

            $jid = $_GET['JID'];

            $selectQuery = "SELECT * FROM views WHERE email = '". $_SESSION['jobme_portal_email'] . "' AND JID = ". $jid .";";

            $result = $conn->query($selectQuery) or die ("Error: " . $conn->error);
            $viewsRow = $result->fetch_all(PDO::FETCH_ASSOC);

            $checkView = false;

            foreach($viewsRow as $row){
                $today = date("Y-m-d");
                // echo "<script>alert('". $today ."')</script>";
                // echo "<script>alert('Today: ". $row[4] ."\nJob ID: ". $row[1] ."')</script>";
                if($row[1] == $jid && $row[4] == $today){
                    $checkView = true;
                    header('Location: ../index.php');
                }
            }

            if(!$checkView){
                $query = "INSERT INTO views (JID, Email, IP, Date) VALUES ($jid, '". $_SESSION['jobme_portal_email'] ."', '" . getIP() . "', NOW());";
                mysqli_query($conn, $query);

                header('Location: ../index.php');
            }
        }
    }
    
    function set_Header_Title_ByPage(){
        if(!isset($_GET['page'])) $title = "Login";
        if(isset($_GET['page']) && $_GET['page'] == "login") $title = "Login";
        if(isset($_GET['page']) && $_GET['page'] == "register") $title = "Register";
        if(isset($_GET['page']) && $_GET['page'] == "main") $title = "Available Jobs";
        if(isset($_GET['page']) && $_GET['page'] == "feed") $title = "Available Jobs";
        if(isset($_GET['page']) && $_GET['page'] == "availableJobs") $title = "Available Jobs";
        if(isset($_GET['page']) && $_GET['page'] == "availabelResumes") $title = "Available Resumes";
        if(isset($_GET['page']) && $_GET['page'] == "availableCompanies") $title = "Available Companies";
        if(isset($_GET['page']) && $_GET['page'] == "PostNewJob") $title = "Post New Job";
        if(isset($_GET['page']) && $_GET['page'] == "PostNewCompany") $title = "Post New Company";
        if(isset($_GET['page']) && $_GET['page'] == "jobCategories") $title = "Available Jobs";
        if(isset($_GET['page']) && $_GET['page'] == "PostNewResume") $title = "Post New Resume";

        return $title;
    }

    function get_companies(){
        $conn = mySQLConnection();

        $query = "SELECT * FROM company;";

        $result = $conn->query($query) or die ("Error: " . $conn->error);
        $companyRows = $result->fetch_all(PDO::FETCH_ASSOC);

        return $companyRows;
    }

    function get_job_request($request_sent_uid){
        $conn = mySQLConnection();

        $query = "SELECT * FROM job_requests WHERE Request_Sent_To_UID = '" . $request_sent_uid . "' && Request_Status = 'Pending' LIMIT 6;";

        $result = $conn->query($query) or die ("Error: " . $conn->error);
        $requestRow = $result->fetch_all(PDO::FETCH_ASSOC);

        return $requestRow;
    }

    function approve_job_request(){
        if(isset($_GET['SenderUID']) && isset($_GET['Request_JID'])){
            $request_JID = $_GET['Request_JID'];
            $sent_from_uid = $_GET['SenderUID'];
            $sent_to_uid = $_SESSION['jobme_portal_userID'];

            $approveQuery = "UPDATE job_requests SET Request_Status = 'Approved' WHERE
            Request_JID = $request_JID  
            AND 
            Request_Sent_From_UID = $sent_from_uid
            AND 
            Request_Sent_To_UID = $sent_to_uid
            AND 
            Request_Status = 'Pending'
            ";

            $conn = mySQLConnection();
            $result = $conn->query($approveQuery) or die ("Error: " .$conn->error);

            if($result == 1){
                header("Location: ?page=main");
            }else {
                echo "Something went wrong!";
            }
        }else {
            header("Location: ?page=Availabel&approved=error");
        }
    }

    function decline_request(){
        if(isset($_GET['SenderUID']) && isset($_GET['Request_JID'])){
            $query = "DELETE FROM job_requests WHERE 
            Request_Sent_From_UID = '". $_GET['SenderUID'] . "'
            AND
            Request_JID = '". $_GET['Request_JID'] ."'
            AND 
            Request_Sent_To_UID = '". $_SESSION['jobme_portal_userID'] . "'
            AND 
            Request_Status = 'Pending' 
            ;";
            $conn = mySQLConnection();

            if($conn->query($query) == TRUE){
                header('Location: ?page=AvailabelJobs');
            }else {
                echo "Error: " . $query . "<br>" . $conn->error;
            }
        }else {
            echo "br><br><br><br><h1 class='bg-dark text-light'>Some parameters are missing!</h1>";
        }
    }

    function hire_request(){
        if(isset($_GET['Job_Title']) && isset($_GET['job_Type']) && isset($_GET['job_Salary']) && isset($_GET['Publisher_UID'])){
            $jobTitle = $_GET['Job_Title'];
            $jobType = $_GET['job_Type'];
            $jobSalary = $_GET['job_Salary'];
            $Publisher_UID = $_GET['Publisher_UID'];
            $relation_UID = generateRID();
            $status = "Pending";

            $conn = mySQLConnection();
            $query = "INSERT INTO hire_request(
                Hire_User_To_UID,
                Hire_User_From_UID,
                Hire_Job_Title,
                Hire_Job_Type,
                Hire_Job_Salary,
                Hire_Status,
                Hire_Relation_ID) VALUES (
                '". $Publisher_UID ."',
                '". $_SESSION['jobme_portal_userID'] ."',
                '". $jobTitle ."',
                '". $jobType ."',
                '". $jobSalary ."',
                '". $status ."',
                '". $relation_UID."'
            );";

            if($conn->query($query) or die ($conn->error)){
                header("Location: ?page=main");
            }else {
                echo "Someting went wrong!".$conn->error;
            }

        }else {
            echo "Your Get Wrong Parameters!";
        }
    }

    function is_hire_request_exit($idTo,$idFrom){
        $query = "SELECT * FROM hire_request WHERE
        Hire_User_To_UID = '". $idTo ."' 
        AND
        Hire_User_From_UID = '". $idFrom ."' 
        AND
        Hire_Status = 'Pending' LIMIT 5;";

        $conn = mySQLConnection();

        $hireResult = $conn->query($query) or die ($conn->error);
        $hireRows = $hireResult->fetch_all(PDO::FETCH_ASSOC);

        foreach($hireRows as $hireRow){
            if($hireRow != null){
                return true;
            }else {
                return false;
            }
        }
        return false;
    }

    function is_hire_request_approved($idTo,$idFrom){
        $query = "SELECT * FROM hire_request WHERE
        Hire_User_To_UID = '". $idTo ."' 
        AND
        Hire_User_From_UID = '". $idFrom ."' 
        AND
        Hire_Status = 'Approved'";

        $conn = mySQLConnection();

        $hireResult = $conn->query($query) or die ($conn->error);
        $hireRows = $hireResult->fetch_all(PDO::FETCH_ASSOC);

        foreach($hireRows as $hireRow){
            if($hireRow != null){
                return true;
            }else {
                return false;
            }
        }
        return false;
    }

    function get_hire_request($userID){
        $query = "SELECT * FROM hire_request WHERE
        Hire_User_To_UID = '". $userID ."' 
        AND
        Hire_Status = 'Pending' LIMIT 5;";

        $conn = mySQLConnection();

        $hireResult = $conn->query($query) or die ($conn->error);
        $hireRow = $hireResult->fetch_all(PDO::FETCH_ASSOC);

        return $hireRow;
    }

    function approved_hire_reqeust(){
        if(isset($_GET['To_UserID']) && isset($_GET['From_UserID'])){
            $from_id = $_GET['From_UserID'];
            $to_id = $_GET['To_UserID'];

            $conn = mySQLConnection();
            $query = "UPDATE hire_request SET Hire_Status = 'Approved' WHERE 
            Hire_User_To_UID = ". $to_id ."
            AND
            Hire_User_From_UID = ". $from_id ."
            AND
            Hire_Status = 'Pending';";

            if($conn->query($query) or die($conn->error)){
                header("Location: ?page=availableJobs");
            }else{
                echo "Sometihng went wrong!".$conn->error;
            }
        }else {
            echo "Your are getting paremeters Wrong!";;
        }
    }

    
    function cancel_hire_request(){
        if(isset($_GET['From_UID']) && isset($_GET['To_UID'])){
            $from_id = $_GET['From_UID'];
            $to_id = $_GET['To_UID'];

            $conn = mySQLConnection();
            $query = "DELETE FROM hire_request WHERE 
            Hire_User_To_UID = '". $to_id ."'
            AND
            Hire_User_From_UID = '". $from_id ."'
            AND
            Hire_Status = 'Pending';";

            if($conn->query($query) or die($conn->error)){
                header("Location: ?page=availabelResumes");
            }else{
                echo "Sometihng went wrong!".$conn->error;
            }
        }else {
            echo "your Some Parameter are missin!";
        }
    }

    function get_CompnayByID($publisher_UID){
        $query = "SELECT * FROM company WHERE Publisher_UID = '". $publisher_UID ."';"; 
        $conn = mySQLConnection();

        $companyResult = $conn->query($query) or die ($conn->error);
        $companyRows = $companyResult->fetch_all(PDO::FETCH_ASSOC);

        return $companyRows;
    }

    function postCat($title, $desc){
        $query = "INSERT INTO categories (Category_Title, Category_Description) VALUES ('$title', '$desc');";

        $postCatResult = mysqli_query(mySQLConnection(), $query) or die(mysqli_error(mySQLConnection()));

        if($postCatResult){
            header('Location: ?page=PostNewJob');
        }
    }

    function is_categroy_exit($title){
        $query = "SELECT * FROM categories WHERE Category_Title = '". $title ."';"; 
        $conn = mySQLConnection();

        $categoryResult = $conn->query($query) or die ($conn->error);
        $categoryRows = $categoryResult->fetch_all(PDO::FETCH_ASSOC);

        foreach($categoryRows as $categoryRow){
            if($categoryRow != null){
                return true;
            }else {
                return false;
            }
        }
        return false;
    }

    function employee_Notifications($get_Hire_Requests){
        if($get_Hire_Requests != null){ 
            foreach($get_Hire_Requests as $hire_request){
            $company = get_CompnayByID($hire_request[2]);

            echo "<p class='font-weight-bolder p-1 m-0'> $hire_request[4] </p>";//JobTitle
            echo  "<p class='m-0' style='color:green;'>". $hire_request[5] . ": &nbsp;&nbsp; PkR: ".$hire_request[6] ."<br>";
            if($company != null){
                echo  "<p> ". $company[0][1] ."</p>";
            }else{
                echo "<br>";
            }          

            echo "<button class='btn btn-success' onclick=redirectTo('?page=approved_hireRequest&To_UserID=".$hire_request[1]."&From_UserID=".$hire_request[2]."');>APPROVE</button>";
            echo "&nbsp; &nbsp; <button class='btn btn-warning' onclick=redirectTo('?page=decline_hirerequest&To_UID=". $hire_request[1] ."&From_UID=". $hire_request[2]."')>DECLINE</button><hr>";
            }
        }
    }

    function employer_Notifications($get_requests){
        foreach($get_requests as $request){
            ?>
              <a class="dropdown-item waves-effect waves-light mb-1" href="#" style="border-radius: 5px; background: RGB(222, 222, 222);">
              <?php
              $getNotifcationSenderInfo = getUserByID($request[3]);
              $getNotificationJobInfo = getJobByID($request[1]);
              if($getNotifcationSenderInfo != null && $getNotificationJobInfo != null){
                $getUserImage = "resources\images\JobMe.png";
                echo "<img class='rounded-lg mt-1' src=' ". $getUserImage ."' width='50' height='50'>";                  
                echo "&nbsp; &nbsp;" . $getNotifcationSenderInfo[0][1] . " " . $getNotifcationSenderInfo[0][2];
                echo "<br>";
                echo "Job_Title: <br>" .$getNotificationJobInfo[0][1] . "<br>";
                echo "Job_Description: <br>" .$getNotificationJobInfo[0][2] ."<br><br>";
                  
                echo "<button class='btn btn-success' onclick='window.location.href = \"?page=approved_request&SenderUID=". $getNotifcationSenderInfo[0][0]."&Request_JID=".$getNotificationJobInfo[0][0]." \"'>APPROVE</button>";
                echo "&nbsp; &nbsp; <button class='btn btn-warning' onclick='window.location.href = \"?page=decline_request&SenderUID=". $getNotifcationSenderInfo[0][0]."&Request_JID=".$getNotificationJobInfo[0][0]." \"'>DECLINE</button>";
            }
              ?>
              </a>
            <?php
        }
    }

    function uploadImage($id){
        $image = $_FILES[$id]['name'];
    
        // image file directory
        $target = "images/".basename($image);

        if (move_uploaded_file($_FILES[$id]['tmp_name'], $target)) {
            return $image;
        }else{
            return false;
        }
    }

    function getCatIDByTitle($cat_Title){
        $query = "SELECT CID FROM categories WHERE Category_Title = '". $cat_Title ."';";

        $conn = mySQLConnection();
        $resultSet = $conn->query($query) or die($conn->error);
        $row = $resultSet->fetch_all(PDO::FETCH_ASSOC);

        if($row != null){
            return $row;
        }else {
            return false;
        }
        return false;
    }

    function getCategoryByID($cat_ID){
        $query = "SELECT Category_Title FROM categories WHERE CID = '". $cat_ID ."';";

        $conn = mySQLConnection();
        $resultSet = $conn->query($query) or die($conn->error);
        $row = $resultSet->fetch_all(PDO::FETCH_ASSOC);

        if($row != null){
            return $row;
        }else {
            return false;
        }
        return false;
    }

    function sendRequest(){
        if(isset($_GET['job_ID']) && isset($_GET['SenderUID']) && isset($_GET['RecieverUID'])){
            $t=time();
            $timestamp = $t . " " . date("Y-m-d",$t);
            $query = "INSERT INTO job_requests (
                Request_JID,
                Request_Status,
                Request_Sent_From_UID,
                Request_Sent_To_UID,
                Request_Sent_At
                ) VALUES (
                    '" . $_GET['job_ID'] . "',
                    'Pending',
                    '" . $_GET['SenderUID'] . "',
                    '" . $_GET['RecieverUID'] . "',
                    NOW()
                );";

                $conn = mySQLConnection();
                if ($conn->query($query) === TRUE) {
                    header('Location: ?page=AvailableJobs');
                } else {
                    echo "Error: " . $query . "<br>" . $conn->error;
                }                

        }else{
            echo "<br><br><br><br><br><br><br><h1 class='bg-dark text-light'>Some parameters are missing!</h1>";
        }
    }

    function cancelRequest(){
        if(isset($_GET['job_ID']) && isset($_GET['SenderUID'])){
            $query = "DELETE FROM job_requests WHERE Request_Sent_From_UID = '". $_GET['SenderUID'] . "' AND Request_JID = '". $_GET['job_ID'] ."';";
            $conn = mySQLConnection();

            if($conn->query($query) == TRUE){
                header('Location: ?page=AvailabelJobs');
            }else {
                echo "Error: " . $query . "<br>" . $conn->error;
            }

        }else {
            echo "br><br><br><br><h1 class='bg-dark text-light'>Some parameters are missing!</h1>";
        }
    }

    function getReuqestsByUID($uid, $jid){
        $query = "SELECT * FROM job_requests WHERE Request_Sent_From_UID = '$uid' AND Request_JID = '$jid';";

        $conn = mySQLConnection();
        $resultSet = $conn->query($query) or die($conn->error);
        $row = $resultSet->fetch_all(PDO::FETCH_ASSOC);

        if($row != null){
            return $row;
        }else {
            return false;
        }
        return false;
    }
    
?>