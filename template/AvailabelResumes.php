<?php

    $getResumes = '';
    $searchQuery = null;

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if(isset($_GET['search'])){
            $searchQuery = $_GET['search'];
        }
    }

    if(isset($_GET['page'])){
        if($_GET['page'] == 'availabelResumes'){
            if(isset($_GET['resumeCat_id'])){
                $catID = $_GET['resumeCat_id'];
                $getResumes = getResumesByCatID($catID);
            }else{
                if($searchQuery){
                    // echo "<script>alert('Fault In Page Setup 1 ". $searchQuery . " ');</script>";
                    $getResumes = getSearchedResumes($searchQuery);
                }else{
                    $getResumes = getResumes();
                }
            }
        }else{
            // echo "<script>alert('Fault In Page Setup 2');</script>";
            if($searchQuery){
                $getResumes = getSearchedResumes($searchQuery);
            }else{
                $getResumes = getResumes();
            }
        }
    }else{
        // echo "<script>alert('Fault In Page Setup 3');</script>";
        if($searchQuery){
            $getResumes = getSearchedResumes($searchQuery);
        }else{
            $getResumes = getResumes();
        }
    }

    ?>
    <div class="col-xl-3 float-left">
        <h3 class="card-title bg-dark p-2 mt-2 mb-0 text-light">Categories</h3>
        <ul class="list-group list-text-dark mb-1">
            <?php
                $getCategories = getCategories();
                for ($i=0; $i < sizeof($getCategories); $i++) {
                    echo "<li class='list-group-item'><a href='?page=availabelResumes&resumeCat_id=". $getCategories[$i][0]."'>" . $getCategories[$i][1] . "</a></li>";
                }
            ?>
        </ul>
    </div>
    <?php
    
    // $getResumes = getResumes();
$getJobs = getJobsByPublisher_UID($_SESSION['jobme_portal_userID']);
echo "<div class='col-xl-8 float-left'>";

if($getResumes){
    for ($i=0; $i <sizeof($getResumes); $i++) {
        $showMyJobClass = "ShowMyJob_".$i;

        $getCategoryByID = getCategoryByID($getResumes[$i][10]);
        $cat_Title = $getCategoryByID[0][0];
        // $getCategoryByID = ;
        ?>
            <div class="d-flex bd-highlight">
                <div class="p-2 flex-fill bd-highlight">
                    <div class="card mb-1">
                        <div class="card-header bg-dark text-light">
                            <h3><?php echo $getResumes[$i][1] ?></h3>
                        </div>
                        
                        <div class="card-body">
                            <p class="font-weight-bolder"><?php echo "Category: ". $cat_Title ?></p>
                            <p class="font-weight-bolder"><?php echo "Experience: ". $getResumes[$i][4] ?></p>
                            <p class="font-weight-bolder"><?php echo "Skills: ". $getResumes[$i][5] ?></p>
                            <p class="font-weight-bolder"><?php echo "Qualification: ". $getResumes[$i][6] ?></p>
                            <p class="font-weight-bolder"><?php echo "Expert: ". $getResumes[$i][7] ?></p>
                            <p class="font-weight-bolder"><?php echo "Type: ". $getResumes[$i][9] ?></p>
                        </div>

                        <div class="btn-group">
                            <button type="button" style="width: 40%; margin: 5px;" class="btn btn-primary rounded-lg" data-toggle="modal" data-target=".<?php echo $showMyJobClass?>">HIRE</button>
                            <button type="button" style="width: 40%; margin: 5px;" class="btn btn-success rounded-lg" onclick="window.location.href = 'images/<?php echo $getResumes[$i][3] ?>'">DOWNLOAD RESUME</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Show My Job modal -->
            <div class="modal fade <?php echo $showMyJobClass?>" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header mb-5">
                        <h3>
                            My Jobs Details
                        </h3>
                        <hr>
                    </div>
                    
                    <label class="p-1 m-1">Job Title:</label>
                    <select name="job" id="job_<?php echo $getResumes[$i][8]; ?>" class="custom-select m-auto" style="width: 99%; margin-bottom: 10px;">
                    <?php
                    foreach($getJobs as $job){
                        ?>
                            <option><?php echo $job[1]; ?></option>
                        <?php
                    }
                    ?>
                    </select>

                    <label class="p-1 m-1 mt-2">Job Type</label>
                    <select name="type" id="type_<?php echo $getResumes[$i][8]; ?>" class="custom-select m-auto" style="width: 99%; margin-bottom: 10px;"> 
                    <?php
                    $jobTypes = array("Part-Time","Full-time","Freelancher");
                        foreach($jobTypes as $jobtype){
                            echo "<option>$jobtype</option>";
                        }
                    ?>
                    </select>

                    <label class="p-1 m-1 mt-2">Job Salary</label>
                    <select name="salary" id="salary_<?php echo $getResumes[$i][8]; ?>" class="custom-select m-auto" style="width: 99%; margin-bottom: 10px;"> 
                    <?php
                    $salary = 15000;
                    for ($j=0; $j < 9; $j++) { 
                        echo "<option>$salary</option>";
                        $salary += 10000;
                    }
                    ?>
                    </select>
                    <?php
                        if($getJobs != null){ 
                            if(is_hire_request_exit($getResumes[$i][8],$_SESSION['jobme_portal_userID'])){
                                ?>
                                    <button type="button" onclick="redirectTo('?page=cancel_hireRequest&From_UID=<?php echo $_SESSION['jobme_portal_userID'] ?>&To_UID=<?php echo $getResumes[$i][8]?>');" class="btn btn-warning text-dark rounded-lg mt-3" style="width: 98%; margin: auto; margin-bottom: 5px">CANCEL HIRE</button>
                                <?php                            
                            }else if(is_hire_request_approved($getResumes[$i][8],$_SESSION['jobme_portal_userID'])){
                                ?>
                                    <button type="button" class="btn btn-success rounded-lg mt-3" style="width: 98%; margin: auto; margin-bottom: 5px">Applied</button>
                                <?php                            
                            }else {
                                ?>
                                    <button type="button" onclick=" hireRequest('<?php echo $getResumes[$i][8]?>');" class="btn btn-info rounded-lg mt-3" style="width: 98%; margin: auto; margin-bottom: 5px">HIRE</button>
                                <?php                            
                            }
                        }else {
                            ?>
                                <button type="button" onclick="redirectTo('?page=PostNewJob');" class="btn btn-secondary rounded-lg mt-3" style="width: 98%; margin: auto; margin-bottom: 5px">POST JOB FIRST</button>
                            <?php                            
                        }
                    ?>
                </div>
            </div>
            </div>
            <!-- Show My Job modal -->

      <?php
    }
    echo "</div>";        
}else {
    ?>
    <div class="bg-dark mt-2 ">
        <h1 class="p-5 m-1 text-light">No Content Available Of This Category!</h1>;
    </div>
    <?php
}
?>