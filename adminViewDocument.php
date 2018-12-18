<?php
	include_once 'header.php';
?>

<section class="main-container">
	<div class="main-wrapper">
		<h2>Document</h2>
		<?php
			if ($_SESSION['userRole'] == 'Admin' || $_SESSION['userRole'] == 'Controller') {
				$name =  $_SESSION['userName'];
				$surname = $_SESSION['userSurname'];
				$role = $_SESSION['userRole'];
				echo '<p>Prisijungta kaip '.$name.' '.$surname.'. Rolė: '.$role.'</p>';

				include_once 'includes/dbh.inc.php';

				$documentID = $_GET['documentID'];
				$roomID = $_GET['roomID'];
				$userID = $_GET['userID'];

				//Created a template
				$sql = "SELECT * FROM documents WHERE documentID = ?";
				//Create a prepared statement
				$stmt = mysqli_stmt_init($conn);
				//Prepare the prepared statement
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					echo "SQL error at selectedReservation roomID check";
					header("Location: reserve.php?select=error");
					exit();
				}
				//Bind parameters to the palceholder
				mysqli_stmt_bind_param($stmt, 's', $documentID);
				//Run parameters inside databse
				mysqli_stmt_execute($stmt);
				$resultDocument = mysqli_stmt_get_result($stmt);

				//Created a template
				$sql = "SELECT * FROM rooms WHERE roomID = ?";
				//Create a prepared statement
				$stmt = mysqli_stmt_init($conn);
				//Prepare the prepared statement
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					echo "SQL error at selectedReservation roomID check";
					header("Location: reserve.php?select=error");
					exit();
				}
				//Bind parameters to the palceholder
				mysqli_stmt_bind_param($stmt, 's', $roomID);
				//Run parameters inside databse
				mysqli_stmt_execute($stmt);
				$resultRoom = mysqli_stmt_get_result($stmt);

				//Created a template
				$sql = "SELECT * FROM users WHERE userID = ?";
				//Create a prepared statement
				$stmt = mysqli_stmt_init($conn);
				//Prepare the prepared statement
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					echo "SQL error at selectedReservation roomID check";
					header("Location: reserve.php?select=error");
					exit();
				}
				//Bind parameters to the palceholder
				mysqli_stmt_bind_param($stmt, 's', $userID);
				//Run parameters inside databse
				mysqli_stmt_execute($stmt);
				$resultUser = mysqli_stmt_get_result($stmt);

				if ($rowDocument = $resultDocument->fetch_assoc()) {
					if ($rowRoom = $resultRoom->fetch_assoc()) {
						$price = $rowRoom['roomPrice'] * ((strtotime($rowDocument['checkOut']) - strtotime($rowDocument['checkIn']))/(60*60*24)); 
						if ($rowUser = $resultUser->fetch_assoc()) {
							echo '<p>User: '.$rowUser['userName'].' '.$rowUser['userSurname'].' '.$rowUser['userEmail'].' '.$rowUser['userPhoneNumber'].'</p>
								<form class="reservation-form">
								<p>Kambario pavadinimas</p>
								<input type="text" name="roomName" placeholder="Kambario pavadinimas" value="'.$rowRoom['roomName'].'" readonly="readonly">
								<p>Kambario dydis</p>
								<input type="text" name="roomSize" placeholder="Kambario dydis" value="'.$rowRoom['roomSize'].'" readonly="readonly">
								<p>Kambario kaina (€'.$rowRoom['roomPrice'].' už naktį)</p>
								<input type="text" name="roomPrice" placeholder="Kambario kaina" value="€'.$price.'" readonly="readonly">
								<p>Registracijos data</p>
								<input type="date" id="checkIn" name="checkIn" value="'.date('Y-m-d').'" readonly="readonly">
								<p>Išvykimo data</p>
								<input type="date" id="checkOut" name="checkOut" value="'.date("Y-m-d", strtotime('tomorrow')).'" readonly="readonly">
								<img src="'.$rowRoom['roomPictureURL'].'">
							</form>';
						}
					}
				}
			} else
				header("Location: index.php");
		?>
	</div>
</section>
<?php
	include_once 'footer.php';
?>
