<?php

$hostname= "localhost";

$username= "root";

$password = "";

$db_name = "aproject_db";

$conn = mysqli_connect($hostname, $username, $password, $db_name);

if (!$conn) {
    echo "Connection failed!".mysqli_connect_errno();
} 
  