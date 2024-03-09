<?php
// Include your database connection code here if not in a separate file
require_once("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $country = $_POST["country"];
    $region = $_POST["region"];
    $province = $_POST["province"];
    $municipality = $_POST["municipality"];
    $barangay = $_POST["barangay"];
    $lotBlock = $_POST['lotBlock'];
    $street = $_POST['street'];
    $phase = $_POST['phase'];
    $lastName = $_POST["lastName"];
    $firstName = $_POST["firstName"];
    $email = $_POST["email"];
    $contact = $_POST['contact']; // No need to manipulate the contact number here
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password

    // Insert data into the database
    $sql = "INSERT INTO users(country, region, province, municipality, barangay, lot_block, street, phs, last_name, first_name, email, contact, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssssssssss", $country, $region, $province, $municipality, $barangay, $lotBlock, $street, $phase, $lastName, $firstName, $email, $contact, $password);
        mysqli_stmt_execute($stmt);
        echo "User registered successfully!";
    } else {
        echo "Error: " . mysqli_error($conn); // Output the specific database error for debugging
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
