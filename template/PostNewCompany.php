<?php

    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submitBtn'])){
        if(isset($_POST['company_title']) && isset($_POST['company_description']) && isset($_POST['companyPostDate']) && isset($_POST['companyJoinBy']) && isset($_POST['companyExpiryDate'])){
            $company_title = $_POST['company_title'];
            $company_dec = $_POST['company_description'];
            $company_postDate = $_POST['companyPostDate'];
            $company_JoinBy = $_POST['companyJoinBy'];
            $company_Expirydate = $_POST['companyExpiryDate'];
            $getUploadedImagePath = uploadImage("company_img");

            $imageUploadStatus = '';

            if($getUploadedImagePath){
                $imageUploadStatus = $getUploadedImagePath;
                echo "Status: " . $imageUploadStatus;
            }else{
                $imageUploadStatus = "image_upload_error";
            }            

            if($imageUploadStatus == "image_upload_error"){
                echo "Image Cannot be uploaded!";
            }else {
                addCompany($company_title,$company_dec,$company_postDate,$company_JoinBy,$company_Expirydate,$imageUploadStatus);
            }
        }
    }
    ?>  

    <div class="col-lg-7 m-auto pt-5">
        <div class="card">
        <div class="card-header p-2 bg-dark mb-1">
            <h3 class="text-light ">Post New Company</h3>
        </div>
            <form method="post" class="p-2" enctype="multipart/form-data">
                <div class="form-group mt-1">
                    <label>Company Title</label>
                    <input type="text" class="form-control" name="company_title" required placeholder="Type Company Title">
                </div>

                <div class="form-group">
                    <label>Company Discription</label>
                    <textarea class="form-control" name="company_description" required rows="3"></textarea>
                </div>

                <div class="form-group mt-1">
                    <img src="resources\images\jobMe.png" name="companyImgPreview" id="companyImgPreview" style="width: 50px; height: 50px; margin-left: 5px;">
                    <input type="file" name='company_img' id="companyImgFile" class="form-control border-0" required placeholder="Type Company Title">
                </div>

                <div class=" form-group">
                    <label for="JobPostDate">Company Post Date</label>
                    <input type="date" name="companyPostDate" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="JobJoinBy">Company Join By</label>
                    <input type="date" name="companyJoinBy" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="JobExpiryDate">Company Expiry Date</label>
                    <input type="date" name="companyExpiryDate" id="companyExpiryDate" required class=" form-control">
                </div>

                <button type="sumbit" name="submitBtn" class=" btn btn-success w-25">Submit</button>
            </form>
        </div>
    </div>
  <?php    
?>