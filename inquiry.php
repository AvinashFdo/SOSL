<html>
    <head>
        <title> secretofsrilanka </title>
    </head>
    <body>
        <form method="post" action="inquiry.php">
            id
            <input type="text" name="id"><br>
            name
            <input type="text" name="na"><br>
            phone_number
            <input type="text" name="phone_num"><br>
            email
            <input type="text" name="email"><br>
            message
            <input type="text" name="message"><br>
            
            <input type="submit" name="submit" ><br>
            <input type= "reset"><br>
            <input type= "submit" value="update" name= "update"><br>
            <input type= "submit" value="delete" name= "delete"><br>
        </form>
    </body>
</html>

<?php
// insert detils to the database
if (isset($_POST["submit"]))
{
   
   $name = $_POST['na'];
   $phone_number= $_POST['phone_num'];
   $email = $_POST['email'];
   $message = $_POST['message'];

        $con=mysqli_connect("localhost","root","","secretofsrilanka") or die("couldn't connect to the server");// database connection
	    $query=mysqli_query($con,"INSERT INTO inquiry(name, phone_number, email, message) values('$name','$phone_number','$email','$message')");	 // sql command


         if($query>0)
		{
			print ("<h1 align='center'>You are Successfully Regeistered</h1><br>");
            echo "Name:- $name <br>";
            echo "Phone:- $phone_number <br>";
            echo "Email:- $email <br>";
            echo "Write Message:- $message <br>";
            
        }
        else
        {
			echo("No record Addres".mysqli_error($con));
		}		
mysqli_close($con);
}
//update details
if (isset($_POST["update"]))
{
   $id = $_POST['id'];
   $name = $_POST['na'];
   $phone_number= $_POST['phone_num'];
   $email = $_POST['email'];
   $message = $_POST['message'];

        $name = $_POST['na'];
        $con = mysqli_connect("localhost", "root", "", "secretofsrilanka") or die("couldn't connect to the server"); // database connection
        $query = mysqli_query($con, "UPDATE inquiry SET name='$name', phone_number='$phone_number', email='$email', message='$message' WHERE id='$id'");	 // sql command


        if ($query > 0)
        {
            print ("<h1 align='center'>You are Successfully Updated</h1><br>");
            echo "Name:- $name <br>";
            echo "Phone:- $phone_number <br>"; 
            echo "Email:- $email <br>";
            echo "Message:- $message <br>";
        }
        else		
        {
            echo("No record Updated".mysqli_error($con));
        }
mysqli_close($con);
}
//delete details
if (isset($_POST["delete"]))
{
   $name= $_POST['na'];

        $con=mysqli_connect("localhost","root","","secretofsrilanka") or die("couldn't connect to the server");// database connection
        $query=mysqli_query($con,"SELECT * FROM inquiry where name= '$name' ");// sql command
        
    $nor = mysqli_num_rows($query);
    if($nor<1)
        {
            echo ("Invalid Entry");
        }
    else
        {
            $rec=mysqli_fetch_assoc($query);
               $query=mysqli_query($con,"DELETE FROM inquiry where name='$name' ");	 // sql command
                   print ("<h1 align='center'>You are Successfully Deleted</h1><br>");
                        echo "Name :- ". $rec['name']. "<br>";
                        echo "Phone :- ". $rec['phone_number']. "<br>";
                        echo "Email :- ". $rec['email']. "<br>";
                        echo "Message :- ". $rec['message']. "<br>";
                        

        }
mysqli_close($con);
}
?>