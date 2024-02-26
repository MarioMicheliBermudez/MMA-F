<?php
require_once("../../../lang/lang.php");
$strings = tr();
?>

<!DOCTYPE HTML>
<html lang="en-US">

<head>
	<meta charset="UTF-8">
	<title><?= htmlspecialchars($strings['title']) ?></title>
	<link rel="stylesheet" href="./../bootstrap.min.css">
</head>

<body>
	<div class="container">
		<div class="row pt-5 mt-2" style="margin-left: 140px;">
			<h1><?= htmlspecialchars($strings['title']) ?></h1>
		</div>
		<div class="row pt-2 mt-5 " style="margin-left: 200px;">
			<div class="col-md-4">
				<img src="images/resim.jpg" style="width: 140px"></a>
			</div>
			<div class="col-md-4">
				<img src="images/resim2.jpg" style="width: 140px"></a>
			</div>
			<div class="col-md-4">
				<img src="images/resim3.jpg" style="width: 130px"></a>
			</div>
		</div>
		<div class="row pt-5" style="margin-left: 230px;">
			<div class="col-md-4">
				<a class="btn btn-primary" href="?product_id=1" role="button" style="margin-right: 20px"><?= htmlspecialchars($strings['button']) ?></a>
			</div>
			<div class="col-md-4">
				<a class="btn btn-primary" href="?product_id=2" role="button" style="margin-left: 15px"><?= htmlspecialchars($strings['button']) ?></a>
			</div>
			<div class="col-md-4">
				<a class="btn btn-primary" href="?product_id=3" role="button" style="margin-left: 30px"><?= htmlspecialchars($strings['button']) ?></a>
			</div>
		</div>
		<div class="row pt-2 mt-5 mb-3" style="margin-right: 70px;">
			<div class="col-md-5" style="margin-left: 150px;">
				<?php
				if (isset($_GET['product_id'])) {
					$product_id = $_GET['product_id'];
					// Validar que el product_id sea un número
					if (is_numeric($product_id)) {
						// Lógica para mostrar información del producto según el ID
						// Aquí puedes incluir tu lógica para recuperar y mostrar información del producto
						echo '<div class="alert alert-primary" role="alert" style=" width:1000px;" > <strong>  <p style="text-align:center;">' . htmlspecialchars($strings['result']) . '</p></strong></div>';
					} else {
						echo '<div class="alert alert-danger" role="alert">Invalid product ID</div>';
					}
				}
				?>
			</div>
		</div>
	</div>
	<script id="VLBar" title="<?= htmlspecialchars($strings['title']) ?>" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
