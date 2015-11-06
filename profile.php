<?php

    include('connect.php');
    include('functions.php');

    if(logged_in()){
        echo "You are logged in";

        ?>

            <a href="logout.php">Logout</a>

        <?php

    }
    else{
        echo "You are not logged in";
    }