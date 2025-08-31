<?php
// insert detils to the database
if (isset($_POST["submit"]))
{
   $name = $_POST['na'];
   $phone_number= $_POST['phone_num'];
   $email = $_POST['email'];
   $message = $_POST['message'];

        $con=mysqli_connect("localhost","root","","secretofsrilanka") or die("couldn't connect to the server");// database connection
	    $query=mysqli_query($con,"INSERT INTO inquiry(name, phone_num, email, message) values('$name','$phone_number','$email','$message')");	 // sql command


         if($query>0)
		{
            //popup msg
            echo "<script>
                    alert('Thank you! Your inquiry has been submitted successfully. We will contact you soon.');
                    window.location.href = 'contact.html';
                  </script>";
            exit();
        }
        else
        {
            echo "<script>
                    alert('Sorry, there was an error submitting your inquiry. Please try again.');
                    window.location.href = 'contact.html';
                  </script>";
            exit();
		}		
mysqli_close($con);
}

if (!isset($_POST["submit"]) && !isset($_POST["update"]) && !isset($_POST["delete"])) {
?>
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
}
?>