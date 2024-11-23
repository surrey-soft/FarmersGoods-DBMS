<?php
// Include the database connection file
include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize form data
    $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $roadNo = mysqli_real_escape_string($con, $_POST['roadNo']);
    $houseNo = mysqli_real_escape_string($con, $_POST['houseNo']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);  // Hash the password

    // Get the user type
    $userType = mysqli_real_escape_string($con, $_POST['userType']);

    // Prepare the SQL query based on user type
    if ($userType == 'farmer') {
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
        else{
            echo "error";
        }
            
                
                
            
        
    }   
    } elseif ($userType == 'qcOfficer') {
        // Insert into QCOfficer table
        $sql = "INSERT INTO QCOfficer (FirstName, LastName, SIM1, SIM2, Password) 
                VALUES ('$firstName', '$lastName', '$contact', '$roadNo', '$hashedPassword')";
    } elseif ($userType == 'customer') {
        // Insert into Customer table
        $sql = "INSERT INTO Customer (FirstName, LastName, C_Address, MobileNo, Email, Password) 
                VALUES ('$firstName', '$lastName', '$roadNo', '$contact', '$city', '$hashedPassword')";
    } elseif ($userType == 'packagingStaff') {
        // Insert into PackagingStaff table
        $sql = "INSERT INTO PackagingStaff (FirstName, LastName, Address, DOB, Contact_Info, Password) 
                VALUES ('$firstName', '$lastName', '$roadNo', '$dob', '$contact', '$hashedPassword')";
    } elseif ($userType == 'driver') {
        // Insert into Driver table
        $sql = "INSERT INTO Driver (D_FirstName, D_LastName, Contact_Info, D_Address, Password) 
                VALUES ('$firstName', '$lastName', '$contact', '$roadNo', '$hashedPassword')";
    } else {
        echo "Invalid user type.";
        exit();
    }

   
    


// Close the connection
mysqli_close($con);
?>
