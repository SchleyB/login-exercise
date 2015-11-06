<?php

    include('connect.php');
    include('functions.php');

    $error = "";

    if(logged_in()){
        header("location:profile.php");
        exit();
    }

    if(isset($_POST['submit'])){

        $email = $_POST['email'];
        $password = $_POST['password'];
        $checkbox = isset($_POST['keep']);

        if(email_exists($email, $con)){
            $result = mysqli_query($con, "Select password from users where email='$email'");
            $retrievePassword = mysqli_fetch_assoc($result);

            if(md5($password) !== $retrievePassword['password']){
                $error = "Password is incorrect!";
            }
            else{
                $_SESSION['email'] = $email;

                if($checkbox == "on"){

                    setcookie("email", $email, time()+3600);

                }

                header("location: profile.php");
            }

        }
        else{
            $error = "Please create an account";
        }

    }

?>

<!doctype html>

<html>

    <head>

        <title>Login Page</title>
        <link rel="stylesheet" href="css/style.css">

    </head>

    <body>

        <div id="error"><?php echo $error; ?></div>

        <div id="wrapper">

            <div id="menu">
                <a href="index.php">Login</a>
                <a href="login.php">Sign Up</a>
            </div>

            <div id="formDiv">

                <form method="post" action="index.php" enctype="multipart/form-data">

                    <label>Email</label><br>
                    <input type="text" name="email" /><br><br>

                    <label>Password</label><br>
                    <input type="password" name="password"><br><br>

                    <label>Remember Me</label>
                    <input type="checkbox" name="keep"><br><br>

                    <input type="submit" name="submit" value="login"><br>

                </form>

            </div>

        </div>

    </body>

</html>
