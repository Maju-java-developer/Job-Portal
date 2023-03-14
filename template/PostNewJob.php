<?php
    
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addJobBtn'])){
        // if( 
        //     isset($_POST['job_Title']) && 
        //     isset($_POST['job_Skills']) && 
        //     isset($_POST['job_Experience']) && 
        //     isset($_POST['job_Vacancies']) && 
        //     isset($_POST['job_Des']) && 
        //     isset($_POST['chooseCat']) && 
        //     isset($_POST['JobPostDate']) && 
        //     isset($_POST['JobJoinByDate']) && 
        //     isset($_POST['JobExpiryDate'])){
                
            $job_Title = $_POST['job_Title'];
            $job_Skills = $_POST['job_Skills'];
            $job_Experience = $_POST['job_Experience'];
            $job_Vacancies = $_POST['job_Vacancies'];
            $job_Des = $_POST['job_Des'];
            $job_Cat = $_POST['chooseCat'];
            $job_Post_Date = $_POST['JobPostDate'];
            $job_JoinBy_Date = $_POST['JobJoinByDate'];
            $job_Expiry_Date = $_POST['JobExpiryDate'];

            $imageUploadStatus = '';
            $getUploadedImagePath = uploadImage("job_img");

            if($getUploadedImagePath){
                $imageUploadStatus = $getUploadedImagePath;
            }else{
                $imageUploadStatus = "image_upload_error";
            }

            if($imageUploadStatus == "image_upload_error"){
                echo "Image cannot be uploaded!";
            }else{
                if($job_Cat != "-- Choose Category --"){
                    $jobCatRow = getCatIDByTitle($job_Cat);
                    $job_CatID = $jobCatRow[0][0];

                    PostNewJob(
                        $job_Title,
                        $job_Vacancies,
                        $job_Skills,
                        $job_Experience,
                        $imageUploadStatus,
                        $job_Des,
                        $job_CatID,
                        $job_Post_Date,
                        $job_JoinBy_Date,
                        $job_Expiry_Date
                    );
                }else {
                    echo "Choose Category Please!";
                }
            }
        // }
    }

    ?>
    <div class="col-xl-6 m-auto">
        <div class="card mt-3">
            <div class="card-header bg-dark text-light">
                <h2 class="p-0 m-0">Post New Job</h2>
            </div>
            <form method="POST" class="p-2" enctype="multipart/form-data">
            <div class="form-row mt-2">
                <div class="form-group col-md-6">
                    <label>Job Title</label>
                    <input type="text" class="form-control" name="job_Title" required id="job_Title">
                </div> 
                <div class="form-group col-md-6">
                    <label>Job Vacancies</label>
                    <input type="number" name="job_Vacancies" class="form-control" required="!!required" id="inputPassword4">
                </div>
            </div>
            <div class="form-group">
                <label>Job Skills</label>
                <input type="text" class="form-control" id="job_Skills" name="job_Skills" required="!!required" placeholder="Job Skills">
            </div>
            <div class="form-group">
                <label>Job Experience</label>
                <input type="text" class="form-control" name="job_Experience" id="job_Experience" required placeholder="Job Experience">
            </div>

            <div class="form-group">
                <label>Job Image</label>
                <br>
                <img id="jobImgPreview" src="resources/images/JobMe.png" class="img-fluid" style="height: 50px; width: 50px;">
                <input type="file" id="jobImgFile" class="form-control border-0" name="job_img" required placeholder="Job Image">
            </div>

            <div class=" form-group">
                <label>Job Description</label>
                <textarea class="form-control" placeholder="Job Description" name="job_Des" id="job_Des" required></textarea>
            </div>   

            <div class="form-row">
                <div class="form-group col-md-9">
                <label>Job Category</label>
                <select name="chooseCat" id="chooseCat" required class="form-control">
                    <option selected>-- Choose Category --</option>
                    <?php
                    $jobCat = getCategories(); 
                    for ($i=0; $i < sizeof($jobCat); $i++) { 
                       echo "<option>". $jobCat[$i][1] ."</option>";
                    }
                ?>
                </select>
                </div>
                <div class="form-group col-md-2 mt-4">
                <!-- This Section Is Dedicated For Add Category Model -->
                <!-- Button trigger modal -->
                <button type="button"  class="btn btn-dark" style="width: 9rem; margin-top: 7px;" data-toggle="modal" data-target="#exampleModal">
                    Add Category
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Category Title</label>
                            <input type="text" id="addCatTitle" class="form-control border-0" name="addCatTitle" placeholder="Category Title" !required>
                        </div>                        
                        <div class="form-group">
                            <label>Category Description</label>
                            <input type="text" id="addCatDesc" class="form-control border-0" name="addCatDesc" placeholder="Category Description" !required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" onclick="postAddCat()" name="addCat" class="btn btn-primary">Add Category</button>
                        <?php
                        
                        if(isset($_GET['page'])){
                            if(isset($_GET['subpage'])){
                                if($_GET['page'] == 'PostNewJob' && $_GET['subpage'] == 'addCat'){
                                    if(isset($_GET['add_cat_title']) && isset($_GET['add_cat_desc'])){
                                        if(!is_categroy_exit($_GET['add_cat_title'])){
                                            postCat($_GET['add_cat_title'], $_GET['add_cat_desc']);
                                        }else {
                                            echo "?page=PostNewJob&Message=Error!";
                                        }
                                    }
                                }
                            }
                        }

                        ?>

                    </div>
                    </div>
                </div>
                </div>

                </div>
            </div>

            <div class="form-group">
                <label for="JobPostDate">Job Post Date</label>
                <input type="date" name="JobPostDate" id="jobPostDate" class=" form-control">
            </div>

            <div class="form-group">
                <label for="JobJoinBy">Job Join By</label>
                <input type="date" id="JobJoinByDate" name="JobJoinByDate" class="form-control">
            </div>

            <div class="form-group">
                <label for="JobExpiryDate">Job Expiry Date</label>
                <input type="date" name="JobExpiryDate" id="jobExpiryDate" class=" form-control">
            </div>
            <button type="submit" name="addJobBtn" class="btn btn-primary">Add Job</button>
            </form> 
        </div>
    </div>
    <?php
?>