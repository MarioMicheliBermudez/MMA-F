<?php
require_once("../../../lang/lang.php");

$strings = tr();

function isValidIP($ip) {
    return filter_var($ip, FILTER_VALIDATE_IP) !== false;
}

?>
<!DOCTYPE HTML>
<html lang="en-US">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $strings['title1']; ?></title>
	<link rel="stylesheet" href="./../bootstrap.min.css">
</head>

<body>
	<div class="container text-center">
		<div class="main-wrapper" style="margin-top: 25vh;">
			<div class="header-wrapper">
				<h2 class="col">PING</h2>
			</div>
			<div class="col-md-auto mt-3 d-flex justify-content-center">
				<form method="POST" class="flex-column">
					<input class="form-control" type="text" name="ip" style="width: 500px;">
					<button type="submit" class="btn btn-primary mt-4" style=" width: 500px;">Ping</button>
				</form>
			</div>

		<div class="col-md-auto d-flex justify-content-center" style="">

			<?php
			if (isset($_POST["ip"])) {
				$input = $_POST["ip"];

				if (isValidIP($input)) {
					$output = shell_exec("ping -c5 $input");
					if (!empty($output)) {
						echo '<div class="mt-5 alert alert-primary" role="alert" style=" width:500px;" > <strong>  <p style="text-align:center;">';
						echo nl2br($output);
						echo ' </p></strong></div>';
					}
				} else {
					echo '<div class="mt-5 alert alert-danger" role="alert" style=" width:500px;" > <strong>  <p style="text-align:center;">Invalid IP Address</p></strong></div>';
				}
			}
			?>
		</div>
	</div>
</div>
	<script id="VLBar" title="<?= $strings['title1'] ?>" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
