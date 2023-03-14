<?php

    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submitBtn'])){
        if(isset($_POST['first_name']) && 
        isset($_POST['last_name']) && 
        isset($_POST['email']) && 
        isset($_POST['address']) && 
        isset($_POST['password']) && 
        isset($_POST['confirm_password']) &&
        isset($_POST['userType'])){

            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $usertype = $_POST['userType'];
            $password = $_POST['password'];
            $confirmPass = $_POST['confirm_password'];

            if(!empty($first_name) && !empty($last_name) && !empty($address) && !empty($email) && !empty($password)){
                if(!isEmailExit($email, $conn)){
                    if($usertype != "-- Choose Type --"){
                        if($password == $confirmPass){
                            addUser($first_name,$last_name,$address,$email,$password,$usertype);
                            
                            $userRow = isLogin($email,$password);
                            echo "UserName". $userRow[1] ." " . $userRow[2]; 
                            if($userRow != null){                        
                                $_SESSION['jobme_portal_Valid'] = true;
                                $_SESSION['jobme_portal_userID'] = $userRow[0];
                                $_SESSION['jobme_portal_userName'] = $userRow[1] ." ". $userRow[2];
                                $_SESSION['jobme_portal_address'] = $userRow[3];
                                $_SESSION['jobme_portal_email'] = $userRow[4];
                                $_SESSION['jobme_portal_type'] = $userRow[6];
                                $_SESSION['jobme_portal_menu'] = 'Logged_In';
                                header('Location: ?page=main');
                            }else {
                                echo "Row is empty!";
                            }
                            
                            }else {
                                header('Location: ?page=register&register=passwordError');
                            }
                        }else {
                            header('Location: ?page=register&register=userTypeError');
                        }
                }else {
                    header('Location: ?page=register&register=emailError');
                }                
            }
        }else {
            echo "Something parameter are missing!";
        }
    }

    ?>
    <div class="col-xl-6 m-auto">
        <div class="card bg-light mt-4">
        <form action="#" method="post">
            <div class="card-header bg-dark text-light text-md-center">
                <h2 class="p-0 m-0">Register</h2>
            </div>
            
            <div class="card-body" style="background: rgb(218, 218, 215)">
                <div class="form-group">
                    <input type="text" class="form-control" name="first_name" placeholder="First Name" required="required">
                </div>
                
                <div class="form-group">
                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" required="required">
                </div>

                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email" required="required">

                    <?php
                        if(isset($_GET['register'])){
                            if($_GET['register'] == "emailError"){
                                ?>
                                <div class="alert-danger p-2 rounded-lg">
                                    This email already exists!
                                </div>
                            
                                <?php
                            }
                        }                
                    ?>

                </div>


                <div class="form-group">
                    <input type="text" class="form-control" name="address" placeholder="Address" required="required">
                </div>

                <select name="userType" class="custom-select mb-3" id="chooseType">
                    <option>-- Choose Type --</option>
                    <option>employee</option>
                    <option>employer</option>
                </select>    

                <?php
                    if(isset($_GET['register'])){
                        if($_GET['register'] == "userTypeError"){
                            ?>
                            <div class="alert-danger p-2 rounded-lg mb-2">
                                Choose user Type First!
                            </div>
                            <?php
                        }
                    }                
                ?>

                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                    <?php
                        if(isset($_GET['register'])){
                            if($_GET['register'] == "passwordError"){
                                ?>
                                <div class="alert-danger p-2 rounded-lg">
                                    Password does not match!
                                </div>
                                <?php
                            }
                        }                
                    ?>
                </div>
                
                <div class="form-group">
                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="required">
                </div>        
                
                <div class="btn-group">
                    <button type="submit" name="submitBtn" class="btn btn-success mr-2 rounded-lg">Sumbit</button>
                    <button onclick="javascript:window.Location.href ='?page=login'" class=" btn btn-secondary rounded-lg">Already Have Account</button>
                </div>
                </form>
            </div>
        </div>
    </div>
  <?php  
?>