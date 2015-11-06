<?php

    session_start();

    $con = mysqli_connect("localhost", "root", "root", "registration");

    if(mysqli_connect_errno()){
        echo "error connecting to database " . mysqli_connect_errno();
    }

?>