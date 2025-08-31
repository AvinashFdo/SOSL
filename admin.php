<?php
// Get all inquiries and display them
if (isset($_GET["action"]) && $_GET["action"] == "list")
{
    $con=mysqli_connect("localhost","root","","secretofsrilanka") or die("couldn't connect to the server");
    $query=mysqli_query($con,"SELECT * FROM inquiry ORDER BY id ASC");
    
    echo "[";
    $first = true;
    while($row = mysqli_fetch_assoc($query))
    {
        if (!$first) echo ",";
        echo "{";
        echo '"id":"' . $row['id'] . '",';
        echo '"name":"' . $row['name'] . '",';
        echo '"email":"' . $row['email'] . '",';
        echo '"phone_number":"' . $row['phone_num'] . '",';
        echo '"message":"' . str_replace('"', '\\"', $row['message']) . '"';
        echo "}";
        $first = false;
    }
    echo "]";
    mysqli_close($con);
}

// Update inquiry details
if (isset($_POST["action"]) && $_POST["action"] == "update")
{
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_num'];
    $message = $_POST['message'];

    $con=mysqli_connect("localhost","root","","secretofsrilanka") or die("couldn't connect to the server");
    $query=mysqli_query($con,"UPDATE inquiry SET name='$name', phone_num='$phone_number', email='$email', message='$message' WHERE id='$id'");

    if($query>0)
    {
        echo "success";
    }
    else
    {
        echo("error: ".mysqli_error($con));
    }		
    mysqli_close($con); 
}

// Delete inquiry details
if (isset($_POST["action"]) && $_POST["action"] == "delete")
{
    $id = $_POST['id'];

    $con=mysqli_connect("localhost","root","","secretofsrilanka") or die("couldn't connect to the server");
    $query=mysqli_query($con,"DELETE FROM inquiry WHERE id='$id'");

    if($query>0)
    {
        echo "success";
    }
    else
    {
        echo "error";
    }
    mysqli_close($con);
}
?>