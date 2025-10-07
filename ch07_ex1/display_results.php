<?php
    // get the data from the form
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = htmlspecialchars($_POST['password']);
    $phone = htmlspecialchars($_POST['phone']);

    // for the heard_from radio buttons,
    // display a value of 'Unknown' if the user doesn't select a radio button
    $heard_form = isset($_POST['heard_form']) ? htmlspecialchars($_POST['heard_form']) : 'Unknown';
    // for the wants_updates check box,
    // display a value of 'Yes' or 'No'
    $wants_updates = isset($_POST['wants_updates']) ?  'Yes' : 'No';
     $contact_via = htmlspecialchars($_POST['contact_via']);

     // convert newlines to <br> for comments
$comments = nl2br(htmlspecialchars($_POST['comments']));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Account Information</title>
    <link rel="stylesheet" href="main.css"/>
</head>
<body>
    <main>
        <h1>Account Information</h1>

        <label>Email Address:</label>
        <span><?php echo htmlspecialchars($email); ?></span><br>

        <label>Password:</label>
        <span><?php echo  htmlspecialchars ($password); ?></span><br>

        <label>Phone Number:</label>
        <span><?php echo  htmlspecialchars ($phone) ; ?></span><br>

        <label>Heard From:</label>
        <span><?php echo  htmlspecialchars ($heard_form) ; ?></span><br>

        <label>Send Updates:</label>
        <span><?php echo  htmlspecialchars ($wants_updates) ; ?></span><br>

        <label>Contact Via:</label>
        <span><?php echo  htmlspecialchars ($contact_via) ; ?></span><br>

        <span>Comments:</span><br>
        <span><?php echo htmlspecialchars  ($comments) ; ?></span><br>
    </main>
</body>
</html>