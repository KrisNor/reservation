<?php
	include_once 'header.php';
?>
<section class="main-container">
	<div class="main-wrapper">
		<?php
			if ($_SESSION['userRole'] == 'Admin') {

				include_once 'includes/dbh.inc.php';

				echo '<h2>Pasirinkite paskyrą</h2>';
				$name =  $_SESSION['userName'];
				$surname = $_SESSION['userSurname'];
				$role = $_SESSION['userRole'];
				echo '<p>Prisijungta kaip '.$name.' '.$surname.'. Rolė: '.$role.'</p>';

				$sql = "SELECT * FROM users";
				$result = mysqli_query($conn, $sql);
				echo '<table class="users-table" name="usersTable">
					<tr class="header" name="header">
						<th>Vardas</th>
						<th>Pavardė</th>
						<th>Elektroninis paštas</th>
				</tr>';
				if (mysqli_num_rows($result) > 0) {
					while ($row = $result->fetch_assoc()) {
						echo '<tr class="clickable-row" data-href="adminEditAccount.php?id='.$row['userID'].'">
								<th>'.$row['userName'].'</th>
								<th>'.$row['userSurname'].'</th>
								<th>'.$row['userEmail'].'</th>
						</tr>';
					}
				}
			} else
				header("Location: index.php");
		?>
	</div>
</section>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

<script>
	jQuery(document).ready(function($) {
	    $(".clickable-row").click(function() {
	        window.location = $(this).data("href");
	    });
	});
</script>


<?php
	include_once 'footer.php';
?>
