<?php
// Include the database connection file
include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize form data
    $firstName = isset($_POST['firstName']) ? mysqli_real_escape_string($con, $_POST['firstName']) : null;
    $lastName = isset($_POST['lastName']) ? mysqli_real_escape_string($con, $_POST['lastName']) : null;
    $dob = isset($_POST['dob']) ? mysqli_real_escape_string($con, $_POST['dob']) : null;  // Check if 'dob' exists
    $contact = isset($_POST['contactInfo']) ? mysqli_real_escape_string($con, $_POST['contactInfo']) : null;
    $city = isset($_POST['city']) ? mysqli_real_escape_string($con, $_POST['city']) : null;  // Check if 'city' exists
    $roadNo = isset($_POST['roadNo']) ? mysqli_real_escape_string($con, $_POST['roadNo']) : null;  // Check if 'roadNo' exists

    $houseNo = isset($_POST['houseNo']) ? mysqli_real_escape_string($con, $_POST['houseNo']) : null;  // Check if 'houseNo' exists
    $address = isset($_POST['address']) ? mysqli_real_escape_string($con, $_POST['address']) : null;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($con, $_POST['email']) : null; 
    $sim1 = isset($_POST['sim1']) ? mysqli_real_escape_string($con, $_POST['sim1']) : null; 
    $sim2 = isset($_POST['sim1']) ? mysqli_real_escape_string($con, $_POST['sim2']) : null; 
    $password = isset($_POST['password']) ? mysqli_real_escape_string($con, $_POST['password']) : null;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);  // Hash the password

    // Get the user type
    $userType = mysqli_real_escape_string($con, $_POST['userType']);
    // echo $userType;
    // echo $firstName;
    // echo $lastName;
    // echo $hashedPassword;
    // echo $contact;
    // echo $address;

    // Prepare the SQL query based on user type
    if ($userType == 'farmer')
     {
        // Insert into Farmer table
        $sql = "INSERT INTO farmer (FirstName, LastName, DOB, City, RoadNo, HouseNo, Password) 
                VALUES ('$firstName', '$lastName', '$dob', '$city', '$roadNo', '$houseNo', '$hashedPassword')";
        $result = mysqli_query($con,$sql);
        $get_farmer_id ="SELECT Farmer_ID FROM farmer WHERE FirstName='$firstName' AND LastName ='$lastName' AND Password='$hashedPassword'";
        $result2 = mysqli_query($con,$get_farmer_id);

        if ($result2){
            $num=mysqli_num_rows($result2);
            if($num>0){
                
                $farmer_id = mysqli_fetch_assoc($result2)['Farmer_ID'];
                $query = "INSERT INTO farmercontact VALUES ($farmer_id,$contact)";
                mysqli_query($con,$query);

            }
            header("Location:../signIn.php");
        }     
        
    }   



    elseif ($userType == 'qcOfficer') {
        // Insert into QCOfficer table
        $sql = "INSERT INTO QCOfficer (FirstName, LastName, SIM1, SIM2, Password) 
                VALUES ('$firstName', '$lastName', '$sim1', '$sim2', '$hashedPassword')";
         $result = mysqli_query($con,$sql);
         header("Location:../signIn.php");

    }
    
    
    
    elseif ($userType == 'customer') {
        // Insert into Customer table
        $sql = "INSERT INTO Customer (FirstName, LastName, C_Address, MobileNo, Email, Password) 
                VALUES ('$firstName', '$lastName', '$address', '$contact', '$email', '$hashedPassword')";
         $result = mysqli_query($con,$sql);
         header("Location:../signIn.php");
    }

    
    elseif ($userType == 'packagingStaff') {
        // Insert into PackagingStaff table
        $sql = "INSERT INTO PackagingStaff (FirstName, LastName, Address, DOB, Contact_Info, Password) 
                VALUES ('$firstName', '$lastName', '$address', '$dob', '$contact', '$hashedPassword')";
         $result = mysqli_query($con,$sql);
         header("Location:../signIn.php");

    } 
    
    
    
    elseif ($userType == 'driver') {
        // Insert into Driver table
        echo 'insdie here';
        $sql = "INSERT INTO driver (D_FirstName, D_LastName, Contact_Info, D_Address, Password) 
                VALUES ('$firstName', '$lastName', '$contact', '$address', '$hashedPassword')";
         $result = mysqli_query($con,$sql);
         echo 'inside exactly  here';
         header("Location:../signIn.php");
    } 
    
    
    else {
        echo "Invalid user type.";
        exit();
    }

   
}    


// Close the connection
mysqli_close($con);
?>
