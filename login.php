<?php
session_start();

// Check login credentials
if (isset($_POST["action"]) && $_POST["action"] == "login")
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $con=mysqli_connect("localhost","root","","secretofsrilanka") or die("couldn't connect to the server");
    $query=mysqli_query($con,"SELECT * FROM login WHERE UserName='$username' AND Password='$password'");

    $row_count = mysqli_num_rows($query);
    
    if($row_count > 0)
    {
        // Login successful
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $username;
        echo "success";
    }
    else
    {
        // Login failed
        echo "failed";
    }
    
    mysqli_close($con);
}

// Check if user is logged in
if (isset($_GET["action"]) && $_GET["action"] == "check_session")
{
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true)
    {
        echo "logged_in";
    }
    else
    {
        echo "not_logged_in";
    }
}

// Logout
if (isset($_GET["action"]) && $_GET["action"] == "logout")
{
    session_destroy();
    echo "logged_out";
}
?>