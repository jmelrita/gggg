<?php
    // Delete Table data
    if (isset($_POST["btnSave"])) {
        // Connect to the database
        require_once "connection.php";

        $name    = $con->real_escape_string($_POST["txtName"]);
        $email   = $con->real_escape_string($_POST["txtEmail"]);
        $contact = $con->real_escape_string($_POST["txtContact"]);

        if ($stmt = $con->prepare("INSERT INTO `contacts`(`name`, `email`, `contact`) VALUES (?, ?, ?)")) {
            $stmt->bind_param("sss", $name, $email, $contact);
            $stmt->execute();
            $stmt->close();
            $msg = '<div class="msg msg-create">Contact details saved successfully.</div>';
        } else {
            $msg = '<div class="msg">Prepare() failed: '.htmlspecialchars($con->error).'</div>';
        }

        // Close database connection
        $con->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Data | Simple CRUD with Search in PHP and MySQL </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if(isset($msg)){ echo $msg; }?>
    <main class="container">
        <div class="wrapper">
            <h1>Simple CRUD with Search in PHP and MySQL</h1>
            <h2>&#187; Jake R. Pomperada MAED-IT, MIT &#171;</h2>
        </div>
        <div class="wrapper">
            <div class="title create">
                <h2>Create New Contact</h2>
                <hr>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="frmCreate">
                <input type="text" name="txtName" placeholder="Name" required>
                <input type="email" name="txtEmail" placeholder="Email" required>
                <input type="number" min="0" name="txtContact" placeholder="Contact Number" required>
                <div class="btnWrapper">
                    <button type="submit" name="btnSave" title="Save contact details">Save</button>
                    <a href="index.php" class="btnHome" title="Return back to homepage">Home</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>