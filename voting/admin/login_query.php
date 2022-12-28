<?php
	require_once 'dbcon.php'; // The mysql database connection script
    require '../vendor/autoload.php';
    use Twilio\Rest\Client;




if(isset($_POST['login']))
	{
        $account_sid = 'ACb53b02eadc84a70cc92725dc103a1e21';
        $auth_token = 'd7d39ed5a9bf02d9cdc2d2ddbe2b76d0';
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
                                $client = new Client($account_sid, $auth_token);
                                $client->messages->create(
                                    $fetch['Phone'], // Text this number
                                    array(
                                        'from' => '+12183792414', // From the free Twilio number
                                        "messagingServiceSid" => "MGa99e7755ff21b65eb61aa72b8aecd445",
                                        'body' => 'Hello Admin! In order to access your account, kindly provide this OTP code: ' . $otp
                                    )
                                );
                                ?>
                                <script type="text/javascript">
                                alert('OTP sent to your phone');
                                window.location = 'otp.php';
                                </script>
                                <?php
                            } else {
                                ?>
                                <script type="text/javascript">
                                alert('Error sending OTP');
                                window.location = 'index.php';
                                </script>
                                <?php
                            }

                        } catch (\Twilio\Exceptions\ConfigurationException $e) {
                            echo "Error: " . $e->getMessage();
                        } catch (\Twilio\Exceptions\TwilioException $e) {
                            echo "Error: " . $e->getMessage();
                        }
			}else{
				?>
						<script type="text/javascript">
						alert('Error!');
						window.location = '../index.php';
						</script>
						<?php
			}
	}
	?>