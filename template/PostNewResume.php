<?php

    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submitBtn'])){
        if(
        isset($_POST['resume_title']) && 
        isset($_POST['chooseCat']) &&
        isset($_POST['experience']) &&
        isset($_POST['skills']) &&
        isset($_POST['qualification']) &&
        isset($_POST['expertise']) &&
        isset($_POST['chooseType'])){

            $resume_title = $_POST['resume_title'];
            $resume_categroy = $_POST['chooseCat'];
            $resume_experience = $_POST['experience'];
            $resume_skills = $_POST['skills'];
            $resume_qualification = $_POST['qualification'];
            $resume_expertise = $_POST['expertise'];
            $resume_type = $_POST['chooseType'];

            $uplodImageStatus = "";
            $getUplaodDocPath = uploadDocument('upload_Resume','images/');

            if($getUplaodDocPath){
                $uplodImageStatus = $getUplaodDocPath;
            }else {
                $uplodImageStatus = "uplaod_Document_error";
            }

            if(!empty($resume_title) && !empty($resume_categroy) && !empty($resume_experience) && !empty($resume_skills) && !empty($resume_qualification) && !empty($resume_expertise) && !empty($resume_type)){
                if($resume_categroy != "-- Choose Category --"){
                    $cat_Row = getCatIDByTitle($resume_categroy);
                    $cat_ID = $cat_Row[0][0];
        
                    if($resume_type != "-- Choose Job Type --"){
                        if($uplodImageStatus != "uplaod_Document_error"){
                            postResume(
                                $resume_title,
                                $resume_categroy,
                                $uplodImageStatus,
                                $resume_experience,
                                $resume_skills,
                                $resume_qualification,
                                $resume_expertise,
                                $resume_type,
                                $cat_ID
                            );
                            header("Location: ?page=main");
                        }else {
                            header("Location: ?page=PostNewResume&PostNewResume=uploadImageError");
                        }
                    }else {
                        header("Location: ?page=PostNewResume&type=JobTypeError");
                    }
                }else {
                    header("Location: ?page=PostNewResume&category=categoryError");
                }
            }
        }else {
            echo "Some Parameter's are missing!";
        }
    }

    ?>
    <div class=" col-lg-6 m-auto">
        <div class="card mb-2 mt-3">
        <div class="card-header bg-dark text-light p-2 mb-1">
            <h3 class="m-2">POST NEW RESUME</h3>
        </div>
            <form class="p-2" action="#" method="post" enctype="multipart/form-data">
                
            <div class="form-group">
                    <label>Resume Title</label>
                    <input type="text" class="form-control" name="resume_title" required placeholder="Type Resume Title">
                </div>

                <div class="form-group">
                    <label>Resume Category</label>
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

                <?php
                    if(isset($_GET['category'])){
                        if(isset($_GET['category']) == "categoryError"){
                        ?>
                            <div class="form-group alert-info">
                                <label class="p-1 m-1">Select Resume Category!</label>
                            </div>
                        <?php
                        }
                    }
                ?>

                <div class="form-group">
                    <label>Upload Resume</label>
                    <input type="file" class="form-control" name="upload_Resume" required>
                </div>

                <div class="form-group">
                    <label>Expeirence</label>
                    <input type="text" class="form-control" name="experience" required placeholder="Experience">
                </div>

                <div class="form-group">
                    <label>Skills</label>
                    <input type="text" class="form-control" name="skills" required placeholder="Skills (JAVA,C#,PHP)">
                </div>

                <div class="form-group">
                    <label>Qualification</label>
                    <input type="text" class="form-control" name="qualification" required placeholder="Qualification (B.A,BCs,M.A,M.Phil)">
                </div>

                <div class="form-group">
                    <label>Expertise</label>
                    <input type="text" class="form-control" name="expertise" required placeholder="Expertise (PHP,JavaScript,CSS)">
                </div>
                    
                <div class="form-group">
                    <label>Job Type</label>
                    <select name="chooseType" class="custom-select" id="">
                        <?php
                        $jobtypes = array('-- Choose Job Type --', 'Full-Time','Part-Time','Internes','Freelancer','Other'); 
                        foreach($jobtypes as $type){
                            echo "<option>$type</option>";
                        }
                        ?>
                    </select>
                </div>

                <?php
                    if(isset($_GET['type'])){
                        if(isset($_GET['type']) == "JobTypeError"){
                        ?>
                            <div class="form-group alert-info">
                                <label class="p-1 m-1">Select Resume Category!</label>
                            </div>
                        <?php
                        }
                    }
                ?>

                <button type="submit" name="submitBtn" class="btn btn-success">POST RESUME</button>
            </form>
        </div>
    </div>
    <?php
?>