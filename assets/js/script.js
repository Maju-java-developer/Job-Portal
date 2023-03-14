
function readURL(input , $imagePreviewid) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $($imagePreviewid).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    } 
}

var imagePath = "";

var jobImgPreviewid = "";
var jobimgid = "";

function getPath(previewImgid, fileImgid){
    jobImgPreviewid = previewImgid;
    jobimgid = fileImgid;

    $(jobimgid).change(function(){
        readURL(this, jobImgPreviewid);
    });
}

$("#jobImgFile").change(function(){
    readURL(this, '#jobImgPreview');
});

$("#companyImgFile").change(function(){
    readURL(this, '#companyImgPreview');
});

function postAddCat(){
    var catTitle = $("#addCatTitle").val();
    var catDescription = $("#addCatDesc").val();

    window.location.href = '?page=PostNewJob&subpage=addCat&add_cat_title='+catTitle+'&add_cat_desc='+catDescription;
}

function updateJob(modalID,jobid){
    var jobTitle = $("#job_title_"+modalID).val();
    var jobDisc = $("#job_desc_"+modalID).val();
    var jobVacancies = $("#job_Vacancies_"+modalID).val();
    var jobSkills = $("#job_skills_"+modalID).val();
    var jobExperience = $("#job_experience_"+modalID).val();
    var jobCat = $("#jobCat_"+modalID).val();
       
    window.location.href = '?page=update_job&job_Title='+jobTitle+'&job_Desc='+jobDisc+'&job_vanancies='+jobVacancies+'&job_Skills='+jobSkills+'&job_Experience='+jobExperience+'&job_cat='+jobCat+'&JobID='+jobid;
}

function redirectTo(url){
    window.location.href = url;
}

function hireRequest(Publisher_UID){

    var jobTitle = $('#job_' + Publisher_UID).val();
    var jobType = $('#type_' + Publisher_UID).val();
    var jobSalary = $('#salary_' + Publisher_UID).val();
    
    window.location.href = "?page=hire_request&Job_Title="+jobTitle+"&job_Type="+jobType+"&job_Salary="+jobSalary+"&Publisher_UID="+Publisher_UID;
}

function getJobSearchValue(){
    var searchVal = $("#search").val();
    window.location.href = "?page=availableJobs&search=" + searchVal;
    // alert("Got Jobs: " + searchVal);
}
function getResumeSearchValue(){
    var searchVal = $("#search").val();
    // var currentLocation = window.location.href;
    window.location.href = "?page=availabelResumes&search=" + searchVal;
}

function addView(jid){
    window.location.href = "core/view.php?JID="+jid;
}

var currentJobID = 0;