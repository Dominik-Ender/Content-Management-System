<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();
include('includes/header.php');

$currentUserId = $_SESSION['id'];

$isAdmin = false;

if ($stm = $connect->prepare('SELECT 1 from ADMIN where id = ?')) {
    $stm->bind_param('i', $currentUserId);
    $stm->execute();

    $stm->store_result();
    $isAdmin = $stm->num_rows > 0;
    $stm->close();
}

if ($isAdmin && isset($_GET['delete'])) {
    if ($stm = $connect->prepare('DELETE FROM users WHERE id = ?')) {
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();

        set_message("The user id " . $_GET['delete'] . " has been deleted.");
        header('Location: users.php');
        $stm->close();
        die();

    } else {
        echo 'Could not prepare statement!';
    }
}

if ($isAdmin) {
    $sql = 'SELECT * FROM users';
} else {
    $sql = 'SELECT * FROM users WHERE id = ?';
}

if ($stm = $connect->prepare($sql)) {
    if (!$isAdmin) {
        $stm->bind_param('i', $currentUserId);
    }

    $stm->execute();
    $result = $stm->get_result();

    if ($result->num_rows > 0) {
        ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <h1 class="h1-display-h1">User management</h1>
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>

                        <?php while ($record = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $record['username']; ?></td>
                                <td><?php echo $record['email']; ?></td>
                                <td><?php echo $record['active']; ?></td>
                                <td>
                                    <a href="/cms/users_edit.php?id=<?php echo $record['id']; ?>">Edit</a>
                                </td>
                                <td>
                                    <a href="/cms/users.php?delete=<?php echo $record['id']; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                    <?php if ($isAdmin) { ?>
                        <a href="/cms/users_add.php">Add new user</a>

                    <?php } ?>
                </div>
            </div>
        </div>

        <?php
    } else {
        echo 'No users found';
    }

    $stm->close();
} else {
    echo 'Could not prepare statement!';
}

include('includes/footer.php');
?>