<?php
	require_once 'admin/dbcon.php';
	
	if(isset($_POST['login'])){
		$idno=$_POST['idno'];
		$password=$_POST['password'];

        $sql = "SELECT * FROM voters WHERE id_number = '$idno' && password = '".md5($password)."' && `account` = 'active' && `status` = 'Unvoted'";
        $result = mysqli_query($conn, $sql);
        $numberOfRows = mysqli_num_rows($result);

        $checkingIfVoted = "SELECT * FROM `voters` WHERE id_number = '$idno' && password = '".md5($password)."' && `status` = 'Voted'";
        $votedQuery = mysqli_query($conn, $checkingIfVoted);
        $voted = mysqli_num_rows($votedQuery);

		if ($numberOfRows > 0){
            session_start();
            $resultArray = mysqli_fetch_array($result);
            $_SESSION['voters_id'] = $resultArray['voters_id'];
            $_SESSION['id_number'] = $resultArray['id_number'];
            $_SESSION['firstname'] = $resultArray['firstname'];
            $_SESSION['lastname'] = $resultArray['lastname'];
            header('location:vote.php');
		}
        if($voted == 1){
            ?>
            <script type="text/javascript">
                alert('Sorry You Already Voted')
            </script>
            <?php
        }else{
            ?>
            <script type="text/javascript">
                alert('Your account is not Actived')
            </script>
            <?php
        }


	
	}
?>