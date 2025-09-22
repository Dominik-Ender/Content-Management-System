<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();
include('includes/header.php');

if (isset($_POST['username'])) {
    if ($stm = $connect->prepare('INSERT INTO users (username, email, password, active) VALUES(?, ?, ?, ?)')) {
        // $hashed = SHA1($_POST['password']);
        // $stm -> bind_param('ss', $_POST['email'], $hashed);
        $stm->bind_param('ssss', $_POST['username'], $_POST['email'], $_POST['password'], $_POST['active']);
        $stm->execute();

        set_message("A new user " . $_POST['username'] . " has been added");
        header('Location: users.php');
        $stm->close();
        die();

    } else {
        echo 'Could not prepare statement!';
    }
}

?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <h1 class="h1-display-h1">Add user</h1>
            <form method="post">
                <!-- Username input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="username">Username</label>
                    <input type="username" id="username" name="username" class="form-control" />
                </div>

                <!-- Email input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" id="email" name="email" class="form-control" />
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" />
                </div>

                <!-- Active select -->
                <div class="form-outline mb-4">
                    <select name="active" class="form-select" id="active">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Sign in</button>
            </form>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>