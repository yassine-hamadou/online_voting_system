<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
	require_once 'dbcon.php'; // The mysql database connection script
    require '../vendor/autoload.php';




if(isset($_POST['login']))
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    $login_id = $_POST['login_id'];

    $query = $conn->query("SELECT * FROM user WHERE username = 	'$username' AND password = '$password' AND user_id = '$login_id' ") or die($conn->error);
    $rows = $query->num_rows;
    $fetch = $query->fetch_array();
    if ($rows == 0)
    {
        ?>
        <script type="text/javascript">
        alert('Username/Password Error!');
        window.location = 'index.php';
        </script>
        <?php
    }
    else if ($rows > 0)
        {
            try {
                $otp = rand(100000, 999999);
                //Update the database to store the OTP
                $query = "UPDATE `user` SET `otp` = '$otp' WHERE `username` = '$username'";
                $result = $conn->query($query);
                if ($result) {
                    //Send the OTP to the user's email using phpmailer
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'yassinehamadou1@gmail.com';
                    $mail->Password = 'lkokpdnipsssqxsn';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
                    $mail->setFrom('yassinehamadou1@gmail.com', 'VOTING SYSTEM');
                    $mail->addAddress($fetch['email']);
                    $mail->isHTML(true);
                    $mail->Subject = 'OTP';
                    $mail->Body = 'Hello Admin! In order to get access to your account kindly provide this OTP: ' . $otp;
                    $mail->send();
                        ?>
                        <script type="text/javascript">
                            alert('The OTP has been sent to your email. Kindly check your mail.');
                            window.location = 'otp.php';
                        </script>
                        <?php
                } else {
                    echo "Error: " . $query . "<br>" . $conn->error;
                }
            }
            catch (Exception $e) {
                ?>
                <script type="text/javascript">
                    alert('Error sending OTP! The message failed with status: <?php echo $e->ErrorInfo; ?>');
                    window.location = 'index.php';
                </script>
                <?php
            }
        }
    else{
        ?>
        <script type="text/javascript">
        alert('Error!');
        window.location = '../index.php';
        </script>
        <?php
    }
}
?>