<?php
    // Connect to the database
    require_once "connection.php";
    
    // Get contact details
    if (isset($_GET["id"])) {
        $id = preg_replace('/\D/', '', $_GET["id"]); //Accept numbers only
    } else {
        header("Location: index.php?p=update&err=no_id");
    }

    // Update contact details
    if (isset($_POST["btnUpdate"])) {
        $name    = $con->real_escape_string($_POST["txtName"]);
        $email   = $con->real_escape_string($_POST["txtEmail"]);
        $contact = $con->real_escape_string($_POST["txtContact"]);

        if ($stmt = $con->prepare("UPDATE `contacts` SET `name`=?, `email`=?, `contact`=? WHERE `id`=?")) {
            $stmt->bind_param("sssi", $name, $email, $contact, $id);
            $stmt->execute();
            $stmt->close();
            $msg = '<div class="msg msg-update">Contact details updated successfully.</div>';
        } else {
            $msg = '<div class="msg">Prepare() failed: '.htmlspecialchars($con->error).'</div>';
        }
    }

    
    if ($stmt = $con->prepare("SELECT `name`, `email`, `contact` FROM `contacts` WHERE `id`=? LIMIT 1")) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($name, $email, $contact);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    } else {
        die('prepare() failed: ' . htmlspecialchars($con->error));
    }
    
    // Close database connection
    $con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data | Simple CRUD with Search in PHP and MySQL</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if(isset($msg)){ echo $msg; }?>
    <main class="container">
        <div class="wrapper">
            <h1>Simple CRUD with Search in PHP</h1>
            <h2>&#187; Jake R. Pomperada MAED-IT, MIT &#171;</h2>
        </div>
        <div class="wrapper">
            <div class="title update">
                <h2>Update Contact</h2>
                <hr>
            </div>
            <form action="<?=$_SERVER['PHP_SELF']."?id=".$id;?>" method="post" class="frmUpdate">
                <input type="text" name="txtName" placeholder="Name" value="<?php echo $name; ?>" required>
                <input type="email" name="txtEmail" placeholder="Email" value="<?php echo $email; ?>" required>
                <input type="number" min="0" name="txtContact" placeholder="Contact Number" value="<?php echo $contact; ?>" required>
                <div class="btnWrapper">
                    <button type="submit" name="btnUpdate" class="btnUpdate" title="Update contact details">Update</button>
                    <a href="index.php" class="btnHome" title="Return back to homepage">Home</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>