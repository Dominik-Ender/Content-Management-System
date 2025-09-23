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

if (isset($_GET['delete'])) {
    if ($stm = $connect->prepare('DELETE FROM posts WHERE id = ?')) {
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();

        header('Location: posts.php');
        $stm->close();
        die();

    } else {
        echo 'Could not prepare statement!';
    }
}

if ($isAdmin) {
    $sql = 'SELECT * FROM posts';
    $stm = $connect->prepare($sql);
} else {
    $sql = 'SELECT * FROM posts WHERE author = ?';
    $stm = $connect->prepare($sql);
    $stm->bind_param('i', $currentUserId);
}

$stm->execute();

$result = $stm->get_result();

if ($result->num_rows > 0) {
    ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <h1 class="h1-display-h1">Posts management</h1>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Author´s ID</th>
                        <th>Content</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>

                    <?php while ($record = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $record['id']; ?></td>
                            <td><?php echo $record['title']; ?></td>
                            <td><?php echo $record['author']; ?></td>
                            <td><?php echo $record['content']; ?></td>
                            <td>
                                <a href="/cms/posts_edit.php?id=<?php echo $record['id']; ?>">Edit</a>
                            </td>
                            <td>
                                <a href="/cms/posts.php?delete=<?php echo $record['id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    <?php
    $stm->close();
} else {
    echo 'Could not prepare statement!';
}

include('includes/footer.php');
?>