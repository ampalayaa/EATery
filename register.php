<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    header("Location: login.php?username=" . urlencode($username));
    exit();
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
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h3 class="card-title text-center mb-4">Sign Up</h3>
            <form id="register-form" method="POST" action="register.php" onsubmit="return validate_passwords();">
              
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" required name="username" id="username" autocomplete="username">
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
                <label for="dob" class="form-label">Birthday</label>
                <input type="date" class="form-control" required name="dob" id="dob">
              </div>

              <div class="mb-3">
                <label for="mobile" class="form-label">Mobile Number</label>
                <input type="text" class="form-control" required name="mobile" id="mobile" autocomplete="mobile">
              </div>

              <div class="mb-3">
                <label class="form-label d-block">Gender:</label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" value="Male" id="genderMale">
                  <label class="form-check-label" for="genderMale">Male</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" value="Female" id="genderFemale">
                  <label class="form-check-label" for="genderFemale">Female</label>
                </div>
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
        return false;
      }
      return true;
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
