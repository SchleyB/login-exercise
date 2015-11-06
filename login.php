<?php

    include('connect.php');
    include('functions.php');

    $error = "";

    if(logged_in()){
        header("location:profile.php");
    }

    if(isset($_POST['submit'])){

        $firstName = $_POST['fname'];
        $lastName = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirm = $_POST['passwordConfirm'];
        $image = $_FILES['image']['name'];
        $tmp_image = $_FILES['image']['tmp_name'];
        $imageSize = $_FILES['image']['size'];

        $date = date("F, d y");

        if(strlen($firstName) < 3){
            $error = "First Name is too short";
        }
        elseif(strlen($lastName) < 3){
            $error = "Last Name is too short";
        }
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = "Please enter correct email";
        }
        elseif(strlen($password) < 8){
            $error = "Password must be greater than 8 characters";
        }
        elseif($password !== $passwordConfirm){
            $error = "Password does not match";
        }
        elseif($image == ""){
            $error = "Please upload your image";
        }
        elseif($imageSize > 1048576){
            $error = "Image size must be less than 1 MB";
        }
        else{

            $password = md5($password);

            $imageExt = explode(".", $image);
            $imageExtension = $imageExt[1];

            if($imageExtension == 'PNG' || $imageExtension == 'png' || $imageExtension == 'JPG' || $imageExtension == 'jpg'){

                $image = rand(0, 100000) . rand(0, 100000) . rand(0, 100000) . time() . "." . $imageExtension;

                $insertQuery = "INSERT INTO users(firstName, lastName, email, password, image, dates) VALUES ('$firstName', '$lastName', '$email', '$password', '$image', '$date')";
                if(mysqli_query($con, $insertQuery)){

                    if(move_uploaded_file($tmp_image, "images/$image")){

                        $error = "You are successfully registered";

                    }
                    else{

                        $error = "Image is not uploaded";

                    }

                }
                else {
                    $error = "Query did not run";
                }

            }
            else{
                $error = "FIle must be an image";
            }

        }

    }

?>

<!doctype html>

<html>

    <head>

        <title>Registration Page</title>
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

                <form method="post" action="login.php" enctype="multipart/form-data">

                    <label>First Name</label><br>
                    <input type="text" name="fname" /><br><br>

                    <label>Last Name</label><br>
                    <input type="text" name="lname" /><br><br>

                    <label>Email</label><br>
                    <input type="text" name="email" /><br><br>

                    <label>Password</label><br>
                    <input type="password" name="password"><br><br>

                    <label>Confirm Password</label><br>
                    <input type="password" name="passwordConfirm"><br><br>

                    <label>Image</label><br>
                    <input type="file" name="image"><br><br>

                    <input type="submit" name="submit"><br>

                </form>

            </div>

        </div>

    </body>

</html>
