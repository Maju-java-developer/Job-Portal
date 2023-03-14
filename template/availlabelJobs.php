<?php

$getJobs = '';
$searchQuery = null;

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['search'])){
        $searchQuery = $_GET['search'];
    }
}

if(isset($_GET['page'])){
    if($_GET['page'] == 'jobCategories'){
        if(isset($_GET['Jobcat_id'])){
            $catID = $_GET['Jobcat_id'];
            $getJobs = getJobByCategory($catID);
        }else{
            if($searchQuery){
                $getJobs = getSearchedJobs($searchQuery);
            }else{
                $getJobs = getLimitedJobFields();
            }
        }
    }else{
        if($searchQuery){
            $getJobs = getSearchedJobs($searchQuery);
        }else{
            $getJobs = getLimitedJobFields();
        }
    }
}else{
    if($searchQuery){
        $getJobs = getSearchedJobs($searchQuery);
    }else{

        $getJobs = getLimitedJobFields();
    }
}

if($getJobs){
    $index = 0;
    foreach($getJobs as $job){
        $jobByID = getJobByID($job[0]);
        $getRequests = getReuqestsByUID($_SESSION['jobme_portal_userID'], $jobByID[0][0]);
        $imagepath ="images/". $jobByID[0][3];
    
        ?>
        
        <div class="card-group mt-2 mb-5" style="border: 1px #20304030 solid; border-radius: 10px;">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h5 class="p-0 m-0"><?php echo $job[1]; ?></h5>
                </div>
                <p class="card-body">
                <img class='w-25 float-left mr-2 ml-0 mb-2' src="<?php echo $imagepath?>" alt="image text">
                <?php echo $job[2]; ?>
                </p>
                <!-- <img class=" image w-25" src="resources/images/software-engineering.jpg" > -->

                <!-- <p class="">
                    <?php echo $job[2]; ?>
                </p> -->
                <div class="rounded-lg align-bottom p-0 m-0">
                    <?php
                    if($_SESSION['jobme_portal_type'] == "employee"){
                        if(!isJobApproved($getRequests[0][1],$getRequests[0][4])){
                            if($getRequests[0][2] == "Pending"){
                        
                                ?>
                                    <button type="button" onclick="redirectTo('?page=cancel_request&job_ID=<?php echo $job[0]; ?>&SenderUID=<?php echo $_SESSION['jobme_portal_userID']; ?>');" class="btn btn-warning m-1 p-2 text-dark float-left" style="width: 49%;">
                                        CANCEL REQUEST
                                    </button>
                                <?php
                            }else {
                                ?>
                                    <button type="button" onclick="redirectTo('?page=send_request&job_ID=<?php echo $job[0]; ?>&SenderUID=<?php echo $_SESSION['jobme_portal_userID']; ?>&RecieverUID=<?php echo $jobByID[0][10]; ?>');" class="btn btn-success  m-1 p-2 text-light float-left" style="width: 49%">
                                        APPLY NOW
                                    </button>
                                <?php
                            }
                        }else {
                            ?>
                                <button type="button" class="btn btn-info m-1 p-2 text-light float-left" style="width: 49%">
                                    APPLIED
                                </button>
                            <?php
                        }
                    }else {
                        ?>
                            <button type="button" class="btn m-1 p-2 text-light float-left" style="width: 49%; background-color: #102040" data-toggle="modal" data-target="#exampleModal_<?php echo ($index+1); ?>" data-whatever="@getbootstrap">
                                UPDATE JOB
                            </button>
                        <?php
                    } 
                    ?>

                    <!-- DELETE JOB MODAL -->
                    <!-- DELETE JOB MODAL -->

                    <!-- UPDATE JOB MODAL -->
                    <div class="modal fade" id="exampleModal_<?php echo ($index+1); ?>" data-target="#exampleModal_<?php echo ($index+1); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">UPDATE JOB</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="#" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-form-label">Job Title</label>
                                <input type="text" class="form-control" id="job_title_<?php echo $index; ?>" value="<?php echo $jobByID[0][1]; ?>">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Job Description</label>
                                <textarea class="form-control" id="job_desc_<?php echo $index; ?>"><?php echo $jobByID[0][2]; ?></textarea>
                            </div>

                            <div class="form-group">
                                <img src="resources\images\JobMe.png" class=" m-1" id="updateImgPreview_<?php echo $index?>" width="35" height="35">
                                <input type="file" class="form-control" style="border 1px #102030 solid;" onclick="getPath('#updateImgPreview_<?php echo $index?>','#updatejobImg_<?php echo $index?>');" id="updatejobImg_<?php echo $index?>" value="<?php echo $job[1]; ?>">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Job Vacancies</label>
                                <input type="text" class="form-control" id="job_Vacancies_<?php echo $index; ?>" value="<?php echo $jobByID[0][4]; ?>">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Job Skills</label>
                                <input type="text" class="form-control" id="job_skills_<?php echo $index; ?>" value="<?php echo $jobByID[0][5]; ?>">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Job Experience</label>
                                <input type="text" class="form-control" id="job_experience_<?php echo $index; ?>" value="<?php echo $jobByID[0][6]; ?>">
                            </div>

                            <select id="jobCat_<?php echo $index; ?>" class=" custom-select">
                            <option>-- Select Category --</option>
                            <?php
                                $jobCategory = getCategories();
                                foreach($jobCategory as $jobCat){
                                    echo "<option>$jobCat[1]</option>";                                
                                }
                            ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                            <button type="button" onclick="updateJob('<?php echo $index; ?>','<?php echo $job[0]; ?>');" class="btn btn-primary" data-target="#exampleModal_<?php echo ($index+1); ?>">UPDATE JOB</button>
                            <!-- <button type="submit" class="btn btn-primary" data-target="#exampleModal_<?php // echo ($index+1); ?>">UPDATE JOB</button> -->
                        </div>
                        </form>
                        </div>
                    </div>
                    </div>
                    <!-- UPDATE JOB MODAL -->

                    <!-- DELETE JOB MODAL -->
                    <div class="modal fade deleteMadal-<?php echo ($index+1); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="deleteModal"<?php echo $index?>>
                    <div class="modal-dialog modal-md">
                        <div class="modal-content p-2">

                            <div class="modal-header mb-lg-4">
                                <h3 class="modal-title">
                                    DELETE JOB
                                </h3>   
                            </div>

                            <h3 class="mb-5 p-3">Are you sure to delete it!</h3>
                             
                            <div class="btn btn-group">
                                <button onclick="$('#deleteM_<?php echo ($index+1); ?>').modal('toggle');" class="btn btn-info w-50 mr-4 rounded-lg ">
                                    CANCEL
                                </button>
                                
                                <button onclick="redirectTo('?page=delete_job&job_ID=<?php echo $job[0]?>');" class="btn btn-danger w-50 mr-4 rounded-lg" >
                                    DELETE JOB
                                </button>
                            </div>

                        </div>
                    </div>
                    </div>
                                
                    <!-- DELETE JOB MODAL -->
                            
                    <!-- MODAL VIEW DETAILS -->
                    <button type="button" class="btn btn-secondary m-1 p-2 text-light float-left" style="width: 49%" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg-<?php echo ($index+1); ?>">
                        VIEW DETAILS
                    </button>

                    <div class="modal fade bd-example-modal-lg-<?php echo ($index+1); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="model_<?php echo ($index+1); ?>">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content p-2">

                            <div class="modal-header mb-lg-4">
                                <h3 class="modal-title">
                                    Job Details
                                </h3>
                            </div>

                            <table class="table">
                                <tr>
                                    <th colspan="3" class="table-dark text-center">Job Details</th>
                                </tr>
                                <?php 
                                $titles = array(
                                    "Job ID",
                                    "Job TItle",
                                    "Job Description",
                                    "Job Vacancy",
                                    "Job Expiry Date"
                                );
                                
                                $index2 = 0;
                                foreach($job as $jobField){
                                   ?>
                                    <tr style="border-bottom: 1px solid #888;">
                                        <td style="text-align: left;"><?php echo $titles[$index2]?></td>
                                        <td style="text-align: right;"><?php echo $jobField;?></td>
                                    </tr>
                                    <?php 
                                    $index2 += 1;
                                 }

                                 ?>
                            </table>

                            <div class="btn btn-group">
                                 <?php
                                 if($_SESSION['jobme_portal_type'] == "employee"){
                                    if(!isJobApproved($getRequests[0][1],$getRequests[0][4])){
                                        if($getRequests[0][2] == 'Pending'){ ?>
                                            <button class="btn btn-warning mr-4 rounded-lg" onclick="redirectTo('?page=cancel_request&job_ID=<?php echo $job[0]; ?>&SenderUID=<?php echo $_SESSION['jobme_portal_userID']; ?>');">
                                                CANCEL REQUEST
                                            </button>
                                        <?php }else{
                                            ?>
                                                <button class="btn btn-success mr-4 rounded-lg" onclick="redirectTo('?page=send_request&job_ID=<?php echo $job[0]; ?>&SenderUID=<?php echo $_SESSION['jobme_portal_userID']; ?>&RecieverUID=<?php echo $jobByID[0][10]; ?>');">
                                                    APPLY NOW
                                                </button>
                                            <?php
                                        }
                                    }else {
                                        ?>
                                            <button class="btn btn-info mr-4 rounded-lg" >
                                                APPLIED
                                            </button>
                                        <?php
                                    }
                                }else {
                                        ?>
                                            <button onclick="$('#model_<?php echo ($index+1); ?>').modal('toggle');" type="button" style="background-color: #102040;" class="btn text-white mr-4 rounded-lg" data-toggle="modal" data-target="#exampleModal_<?php echo ($index+1); ?>" data-whatever="@getbootstrap">
                                                UPDATE JOB
                                            </button>
                                            <!-- <button style="background-color: #102040;" class="btn text-white mr-4 rounded-lg" >UPDATE JOB</button> -->
                                            <button onclick="$('#model_<?php echo ($index+1); ?>').modal('toggle');" class="btn btn-danger mr-4 rounded-lg" role="dialog" data-toggle="modal" data-target=".deleteMadal-<?php echo ($index+1); ?>">
                                                DELETE JOB
                                            </button >
                                        <?php
                                }
                                    ?>
                                <button class="btn btn-secondary rounded-lg" onclick="$('#model_<?php echo ($index+1); ?>').modal('toggle'); addView('<?php echo $job[0]; ?>');">
                                    CANCEL
                                </button>
                            </div>

                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    $index += 1;
    }
}else {
    ?>
    <div class="bg-dark mt-2 ">
        <h1 class="p-5 m-1 text-light">No Content Available Of This Category!</h1>;
    </div>
    <?php
}
?>
