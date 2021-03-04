<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bhaavgeet-User Validation</title>
    <link rel="stylesheet" href="./styles/user-validation.css">
    <style>
        .login-html{
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <main>
    <div class="login-wrap">
        <div class="login-html">
            
            <div class="login-form">
                <form name="send-email-form" method="POST" action="forgotpassword.php">
                    <div class="form-wrap">
                        <div class="group">
                            <label for="Email" class="label">Email</label>
                            <input id="email" name="email" type="text" class="input" required>
                        </div>
                        <div class="group">
                            <label for="password" class="label">Password</label>
                            <input id="password" name="password" type="text" class="input" required>
                        </div>
                        <div class="group">
                            <label for="rp-password" class="label">Repeat Password</label>
                            <input id="rp-password" name="rp-password" type="text" class="input" required>
                        </div>
                        <div class="group">
                            <input type="submit" class="button" value="Send Request" id="sign-in-btn" name="sign-in-btn">
                        </div>
                        <div class="hr"></div>
                        <div class="foot-lnk">
                        <a href="user-validation.php"> Go Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </main>
    <?php
        $dbhost = 'localhost';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'spotify-api';

        if(isset($_POST['email']) and isset($_POST['password']) and isset($_POST['rp-password'])){
            $password = $_POST['password'];
            $rp_password = $_POST['rp-password'];
            if($password == $rp_password){
                $email = $_POST['email'];
                $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

                if(!$conn ) {
                    die('Could not connect: ' . mysqli_error());
                }
                $sql = "SELECT * FROM users WHERE email='$email'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $v_key = md5(time().$email);
                    $update_query = "UPDATE users SET v_key = '$v_key', temp_password = '$password' WHERE email = '$email'";
                    $update = mysqli_query($conn, $update_query);
                    $msg = "<a href='http://localhost/test/Bhavgeet/jiten-bhai/user-validation.php?v_key=$v_key&change-pass=true'> Register Account </a>";
                    mail($email,'Bhaavgeet-User Verification',$msg,'From: jitenpatel1482000@gmail.com');
                    header("Location: ./verify.php");
                } else {
                    echo '<script>alert("Email not yet registered")</script>';
                }
            }
            else{
                echo '<script>alert("Passwords does not match")</script>';
            }
        }
    ?>
</body>
</html>
