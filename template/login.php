<?php
    
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['loginBtn'])){
        if(isset($_POST['email']) && isset($_POST['password'])){
            $userEmail = $_POST['email'];
            $userPassword = $_POST['password'];
            
            if(!empty($userEmail) && !empty($userPassword)){
                $userRow = isLogin($userEmail, $userPassword);
                if($userRow != null){

                    $_SESSION['jobme_portal_Valid'] = true;
                    $_SESSION['jobme_portal_userID'] = $userRow[0];
                    $_SESSION['jobme_portal_userName'] = $userRow[1] ." ". $userRow[2];
                    $_SESSION['jobme_portal_address'] = $userRow[3];
                    $_SESSION['jobme_portal_email'] = $userRow[4];
                    $_SESSION['jobme_portal_type'] = $userRow[6];
                    $_SESSION['jobme_portal_menu'] = 'Logged_In';

                    header('Location: ?page=main');
                }else{
                    header('location: ?page=login&login=failed');
                }
            }else {
                header("Location: ?page=login&login=failed");
            }
        }
    }

?>
    <div class="col-xl-6 m-auto">
        <div class="card" style="margin: 40px auto 20px auto;">
            <h3 class="card-header text-light bg-dark m-0 pl-2 pr-2 pt-3 pb-3">LOGIN TO ACCOUNT</h3>
            <div class="card-body" style="background: rgb(222, 222, 222);">

                <form action="#" method="post">
                <div class="form-group text-dark">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control shadow-sm" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                
                <div class="form-group text-dark">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control shadow-sm" id="exampleInputPassword1" placeholder="Password">
                </div>

                <?php
                    if(isset($_GET['login'])){
                        if($_GET['login'] == "failed"){
                            ?>
                            <div class="alert-success p-2 shadow mb-5 rounded-lg">
                                Wrong credentials! <a href="#">Forget Password</a>
                            </div>
                            <?php
                        }
                    }
                ?>

                <div class="form-check text-dark mb-1">
                    <input type="checkbox" name="logMeIn" class="form-check-input shadow-sm" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>

                <div class="divider"></div>
                <button type="submit" name="loginBtn" class="btn btn-dark">LOGIN</button>
                <button type="button" onclick="javascript:window.location.href='?page=register'" class="btn btn-primary">REGISTER</button>
                </form>

            </div>
        </div>
    </div>
<?php

?>