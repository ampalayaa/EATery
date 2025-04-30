<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = ''; // Default password for XAMPP (empty by default)
$port = 3307; // XAMPP MySQL default port (use 3306 if this doesn't work)

$conn = new mysqli($host, $username, $password, port: $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = [];
$success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $middle_name = isset($_POST['middle_name']) ? htmlspecialchars(trim($_POST['middle_name'])) : null;
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $mobile = htmlspecialchars(trim($_POST['mobile']));

    // Validate data
    if (!preg_match("/^[A-Za-z]{2,}$/", $first_name)) {
        $errors[] = "First name must be at least 2 letters and contain no special characters.";
    }

    if (!preg_match("/^[A-Za-z]{2,}$/", $last_name)) {
        $errors[] = "Last name must be at least 2 letters and contain no special characters.";
    }

    if ($middle_name && !preg_match("/^[A-Za-z]{2,}$/", $middle_name)) {
        $errors[] = "Middle name must be at least 2 letters and contain no special characters.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!preg_match("/^0\d{10}$/", $mobile)) {
        $errors[] = "Mobile number must be 11 digits and start with 0.";
    }

    if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password)) {
        $errors[] = "Password must be at least 8 characters, with 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, email, password, mobile) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $first_name, $middle_name, $last_name, $email, $hashed_password, $mobile);

        if ($stmt->execute()) {
            $success = "You have successfully registered!";
            $_SESSION['first_name'] = $first_name;

            // Redirect to nextpage.php after successful registration
            header("Location: nextpage.php");
            exit();
        } else {
            $errors[] = "There was an error during registration. Please try again.";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">

  <div class="container">
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <ul>
          <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h3 class="card-title text-center mb-4">Sign Up</h3>
            <form method="POST" action="register.php" onsubmit="return validate_password();">
              
              <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" required name="first_name" id="first_name" autocomplete="first_name">
              </div>

              <div class="mb-3">
                <label for="middle_name" class="form-label">Middle Name (Optional)</label>
                <input type="text" class="form-control" name="middle_name" id="middle_name" autocomplete="middle_name">
              </div>

              <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" required name="last_name" id="last_name" autocomplete="last_name">
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" required name="email" id="email" autocomplete="email">
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" required name="password" id="password" autocomplete="current-password">
              </div>

              <div class="mb-3">
                <label for="confirm-password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" required name="confirm-password" id="confirm-password">
              </div>

              <div class="mb-3">
                <label for="mobile" class="form-label">Mobile Number</label>
                <input type="text" class="form-control" required name="mobile" id="mobile" autocomplete="mobile">
              </div>

              <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">Sign up</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function validate_password() {
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirm-password').value;
      if (password !== confirmPassword) {
        alert('Passwords do not match!');
        return false; // Prevent form submission
      }
      return true; // Allow form submission
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
