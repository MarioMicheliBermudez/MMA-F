<?php
require("../../../lang/lang.php");
$strings = tr();

include('dependencies/dbConnect.php');

global $pdo;

if (isset($_REQUEST['delete']) && $_REQUEST['delete'] == 1) {
    if (isset($_REQUEST['search'])) {
        unset($_REQUEST['search']);
    }
}

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($searchTerm)) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE name LIKE :searchTerm");
    $stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
} else {
    $stmt = $pdo->prepare("SELECT * FROM users");
}

$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <title><?php echo $strings['kayit'] ?></title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
        }
    </style>
</head>

<body>
    <main>
        <div class="" style="padding: 60px;">
            <div class="container-fluid">
                <h1 class="mt-4"><?php echo $strings['kayit'] ?></h1>
                <div class="form-group">
                    <span></span>
                </div>
                <div class="row">
                    <div class="col-4">
                        <form method="GET">
                            <input type="text" placeholder="Search" value="<?php echo htmlspecialchars($searchTerm) ?>" name="search">
                            <button class="btn btn-primary" type="submit"><?php echo $strings['search'] ?></button>
                        </form>
                    </div>
                    <div class="col-8">
                        <form method="GET">
                            <button class="btn btn-primary" type="submit" style="margin-left:-90px"><?php echo $strings['reset'] ?></button>
                        </form>
                    </div>
                </div>
                <div class="">
                    <fieldset>
                        <div class="form-group">
                            <div class="">
                                <div class="table-responsive mt-4">
                                    <table class="table table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Username</th>
                                                <th>E-Mail</th>
                                                <th>Name</th>
                                                <th>Surname</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $user) : ?>
                                                <tr>
                                                    <td><?php echo $user['id']; ?></td>
                                                    <td><?php echo $user['username']; ?></td>
                                                    <td><?php echo $user['email']; ?></td>
                                                    <td><?php echo $user['name']; ?></td>
                                                    <td><?php echo $user['surname']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
