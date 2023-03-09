<?php

    $conn = mysqli_connect("localhost","root","welC0me$","urlshortener");

    if(!$conn){
        echo "Database Connection error" . mysqli_connect_error();
    }

?>