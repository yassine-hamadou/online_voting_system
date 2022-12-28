<?php
// Connect to the database
require_once 'dbcon.php';

// Check if the form was submitted
if (isset($_POST['verify'])) {
    // Get the otp code from the form submission
    $otp = $_POST['otp'];
    // Check if the otp code matches the otp code in the database
    $query = $conn->query("SELECT * FROM `user` WHERE `otp` = '$otp'");
    $row = $query->fetch_array();
    if ($row) {
        // If the otp code matches, display a success message
        ?>
            <script type="text/javascript">
            alert('OTP verified. Welcome!');
            window.location = 'candidate.php';
            </script>
        <?php
        session_start();
        $_SESSION['id'] = $row['user_id'];
    } else {
        // If the otp code does not match, display an error message
        ?>
            <script type="text/javascript">
            alert('Invalid OTP');
            window.location = 'index.php';
            </script>
        <?php
    }
}

