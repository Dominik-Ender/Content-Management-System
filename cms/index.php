<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
// secure();

$email = "";
$password = "";

$emailErr = "";
$passwordErr = "";

if (isset($_POST['signup'])) {
    header('Location: sign_up.php');
    die();
}

if (isset($_SESSION['id'])) {
    header('Location: dashboard.php');
    die();
}

include('includes/header.php');

if (isset($_POST['signin'])) {
    require "validation_login.php";

    if (empty($passwordErr) && empty($emailErr)) {
        if ($stm = $connect->prepare('SELECT * FROM users WHERE email = ? AND password = ? AND active = 1')) {
            $stm->bind_param('ss', $_POST['email'], $_POST['password']);
            $stm->execute();

            $result = $stm->get_result();
            $user = $result->fetch_assoc();

            if ($user) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];

                header('Location: dashboard.php');
                die();
            }

            $stm->close();
        } else {
            echo 'Could not prepare statement!';
        }
    }
}

?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <form method="post">
                <!-- Email input -->
                <div class="form-group mb-4">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" id="email" name="email" class="form-control" />
                    <span class="error"><?php echo $emailErr; ?></span>
                </div>

                <!-- Password input -->
                <div class="form-group mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" />
                    <span class="error"><?php echo $passwordErr; ?></span>
                </div>

                <!-- Submit button -->
                <div class="d-flex gap-2">
                    <button type="submit" name="signin" class="btn btn-primary">Sign in</button>
                    <button type="submit" name="signup" class="btn btn-secondary">Sign up</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>