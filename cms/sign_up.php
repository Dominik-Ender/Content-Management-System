<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
// secure();

$username = "";
$email = "";
$password1 = "";
$password2 = "";

$usernameErr = "";
$emailErr = "";
$password1Err = "";
$password2Err = "";


if (isset($_SESSION['id'])) {
    header('Location: dashboard.php');
    die();
}

include('includes/header.php');

if (isset($_POST['signup'])) {
    require "validation.php";

    if (empty($usernameErr) && empty($emailErr) && empty($password1Err) && empty($password2Err)) {
        if ($stm = $connect->prepare('INSERT INTO users (username, email, password, active) VALUES (?, ?, ?, 1)')) {
            // $hashed = SHA1($_POST['password']);
            // $stm -> bind_param('ss', $_POST['email'], $hashed);
            $stm->bind_param('sss', $_POST['username'], $_POST['email'], $_POST['password1']);

            if ($stm->execute()) {
                $_SESSION['id'] = $connect->insert_id;
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['email'] = $_POST['email'];

                var_dump($result);

                set_message("You have succesfully signed up " . $_SESSION['username']);
                header('Location: dashboard.php');
                die();
            }

            $stm->close();
        }
    }
}

if (isset($_POST['title'])) {
    header('Location: sign_up.php');
    die();
}

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <form method="post" class="container" role="form"
                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                autocomplete="off"
                >
                <!-- Username input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="username">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="form-control" 
                        value="<?php echo htmlspecialchars($username); ?>" 
                        autocomplete="off"
                    />
                    <span class="error"><?php echo $usernameErr; ?></span>

                </div>

                <!-- Email input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>"  />
                    <span class="error"><?php echo $emailErr; ?></span>

                </div>

                <!-- Password 1 input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="password1">Password</label>
                    <input type="password" id="password1" name="password1" class="form-control" />
                    <span class="error"><?php echo $password1Err; ?></span>

                </div>

                <!-- Password 2 input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="password2">Password</label>
                    <input type="password" id="password2" name="password2" class="form-control" />
                    <span class="error"><?php echo $password2Err; ?></span>

                </div>

                <!-- Submit button -->
                <div class="d-flex gap-2">
                    <button type="submit" name="signup" class="btn btn-primary">Sign up</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

include('includes/footer.php');

?>