<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bhaavgeet-User Validation</title>
    <link rel="stylesheet" href="./styles/user-validation.css">
</head>
<body>
    <main>
    <div class="login-wrap">
        <div class="login-html">
            <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
            <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
            <div class="login-form">
                <form name="sign-in-form" method="POST" action="user-validation.php">
                    <div class="sign-in-htm">
                        <div class="group">
                            <label for="username" class="label">Username</label>
                            <input id="sign-in-username" name="sign-in-username" type="text" class="input" required>
                        </div>
                        <div class="group">
                            <label for="password" class="label">Password</label>
                            <input id="sign-in-password" name="sign-in-password" type="password" class="input" data-type="password" required>
                        </div>
                        <div class="group">
                            <input id="check" type="checkbox" class="check" checked>
                            <label for="check"><span class="icon"></span> Keep me Signed in</label>
                        </div>
                        <div class="group">
                            <input type="submit" class="button" value="Sign In" id="sign-in-btn" name="sign-in-btn">
                        </div>
                        <div class="hr"></div>
                        <div class="foot-lnk">
                            <a href="./forgotpassword.php">Forgot Password?</a>
                        </div>
                    </div>
                </form>
                <form name="sign-up-form" method="POST" action="user-validation.php">
                    <div class="sign-up-htm">
                        <div class="group">
                            <label for="username" class="label">Username</label>
                            <input id="sign-up-username" type="text" name="sign-up-username" class="input" required>
                        </div>
                        <div class="group">
                            <label for="password" class="label">Password</label>
                            <input id="sign-up-password" type="password" name="sign-up-password" class="input" data-type="password" required>
                        </div>
                        <div class="group"> 
                            <label for="rp-password" class="label">Repeat Password</label>
                            <input id="sign-up-rp-password" type="password" name="sign-up-rp-password" class="input" data-type="password" required>
                        </div>
                        <div class="group">
                            <label for="email" class="label">Email Address</label>
                            <input id="sign-up-email" type="text" name="sign-up-email" class="input" required>
                        </div>
                        <div class="group">
                            <input type="submit" class="button" value="Sign Up" id="sign-up-btn" name="sign-up-btn">
                        </div>                       
                        <div class="hr"></div>
                        <div class="foot-lnk">
                            <label for="tab-1">Already Member?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </main>
    <?php
        session_start();

        include 'connect.php';

        //change password
        if(isset($_GET['v_key']) and isset($_GET['change-pass']) == 'true'){

            $v_key = $_GET['v_key'];
            $v_key_query = "SELECT * FROM users WHERE v_key='$v_key'";
            $v_key_result = mysqli_query($conn, $v_key_query);

            if (mysqli_num_rows($v_key_result) > 0) {
                while($row = mysqli_fetch_assoc($v_key_result)) {
                    if($row["v_key"] == $v_key){
                        $new_password = $row["temp_password"];
                        if($new_password != NULL){
                            $verified_query = "UPDATE users SET password = '$new_password', temp_password = NULL WHERE v_key = '$v_key'";
                            $verified = mysqli_query($conn, $verified_query);
                            echo "<script>alert('Your Password Has been successfully updated.')</script>";
                        }else{
                            echo "<script>alert('Password already updated.')</script>";
                        }
                        
                    }
                    else{
                        echo '<script>alert("Verification key does not match")</script>';
                    }
                }
            } else {
                echo '<script>alert("Something went wrong2")</script>';
            }
        }

        //register user
        if(isset($_GET['v_key']) and isset($_GET['user-reg']) == 'true'){
            $v_key = $_GET['v_key'];
            $v_key_query = "SELECT * FROM users WHERE v_key='$v_key'";
            $v_key_result = mysqli_query($conn, $v_key_query);

            if (mysqli_num_rows($v_key_result) > 0) {
                while($row = mysqli_fetch_assoc($v_key_result)) {
                    if($row["v_key"] == $v_key){
                        $verified_query = "UPDATE users SET verified = '1' WHERE v_key = '$v_key'";
                        $verified = mysqli_query($conn, $verified_query);
                        echo '<script>alert("User Account Successfully Verified")</script>';
                    }
                    else{
                        echo '<script>alert("Verification key does not match")</script>';
                    }
                }
            } else {
                echo '<script>alert("Something went wrong1")</script>';
            }
        }
        
        //login
        if(isset($_POST['sign-in-username']) and $_POST['sign-in-password']){
            $username = $_POST['sign-in-username'];
            $password = $_POST['sign-in-password'];
        
            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    if($row["password"] == $password){
                        if($row["verified"] == '1'){
                            $_SESSION['username'] = $username;
                            $_SESSION['password'] = $password;
                            header("Location: ../Bhavgeet_main/index.html");
                        }
                        else{
                            echo '<script>alert("Verification Pending. Please check your email.")</script>';
                        }
                    }
                    else{
                        echo '<script>alert("Invalid Password")</script>';
                    }
                }
            } else {
                echo '<script>alert("Invalid Username")</script>';
            }
            mysqli_close($conn);
        }
        //sign up
        elseif(
            isset($_POST['sign-up-username']) and
            isset($_POST['sign-up-password']) and
            isset($_POST['sign-up-rp-password']) and
            isset($_POST['sign-up-email'])
        ){
            if($password == $rp_password){
                $email_query = "SELECT * FROM users WHERE email='$email'";
                $email_result = mysqli_query($conn, $email_query);
                if (mysqli_num_rows($email_result) > 0) {
                    echo 'test';
                    echo '<script>alert("Email already exists")</script>';
                } 
                else {
                    echo 'test2';
                    $username_query = "SELECT * FROM users WHERE username='$username'";
                    $username_result = mysqli_query($conn, $username_query);
                    if(mysqli_num_rows($username_result) > 0){
                        echo '<script>alert("Username already exists")</script>';
                    }
                    else{
                        //valid condtions to go further
                        $v_key = md5(time().$username);
                        $insert_query = "INSERT INTO users (username, password, email, v_key, verified) VALUES ('$username', '$password', '$email', '$v_key', '0')";
                        $insert = mysqli_query($conn, $insert_query);
                        $msg = "<a href='http://localhost/test/Bhavgeet/jiten-bhai/user-validation.php?v_key=$v_key&user-reg=true'> Register Account </a>";
                        mail($email,'Bhaavgeet-User Verification',$msg,'From: jitenpatel1482000@gmail.com');
                        header("Location: ./verify.php");
                    }
                }
            }
            else{
                echo '<script>alert("Passwords Do Not Match")</script>';
            }
        }
        mysqli_close($conn);
    ?>
</body>
</html>
