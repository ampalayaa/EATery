<?php
// Start the session
session_start();

// Check if the user is logged in (i.e., if session 'first_name' is set)
if (!isset($_SESSION['first_name'])) {
    // If no session is set, redirect to register.php (user must be logged in)
    header("Location: register.php");
    exit();
}

// Function to destroy the session and log out
function destroy_session() {
    session_destroy(); // Destroy the session
    session_unset(); // Remove all session variables
    header("Location: register.php"); // Redirect back to register.php after logout
    exit();
}

// Check if logout button was clicked
if (isset($_POST['logout'])) {
    destroy_session(); // Destroy session and redirect to register.php
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">

  <div class="container">
    <h3 class="text-center">Welcome, <?= $_SESSION['first_name'] ?>!</h3>
    <form method="POST" action="nextpage.php">
        <button type="submit" class="btn btn-danger" name="logout">Logout</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
