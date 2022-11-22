<?php
require 'dbcon.php';
if (isset($_POST['save'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $id_number = $_POST['id_number'];
    $prog_study = $_POST['prog_study'];
    $year_level = $_POST['year_level'];
    $password = $_POST['password'];
    $password1 = $_POST['password1'];
    $date = date("Y-m-d H:i:s");

    //my change from here
    $sql = "SELECT * FROM voters WHERE id_number = '$id_number'";
    $result = mysqli_query($conn, $sql);
//    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        echo "<script>alert('ID Already Registered'); window.location='index.php'</script>";
    }
    else {
        if ($password == $password1) {
            $sql = "INSERT INTO voters(id_number, password, firstname, lastname, gender, prog_study,year_level,status, date) VALUES('$id_number', '" . md5($password) . "','$firstname','$lastname', '$gender','$prog_study', '$year_level','Unvoted', '$date')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('Successfully Registered'); window.location='../voters.php'</script>";
                $voter_id = mysqli_insert_id($conn);
            }
            else {
                echo "<script>alert('Error during registration    '); window.location='index.php'</script>";
            }
        }
        else {
            echo "<script>alert('Your Password did not match!'); window.location='index.php'</script>";
        }
    }
}
?>