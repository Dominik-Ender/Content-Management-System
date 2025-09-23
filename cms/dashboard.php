<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();
include('includes/header.php');

?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <h1 class="display-h1">Dashboard</h1>
        </div>
    </div>
</div>

<?php
if ($stm = $connect->prepare('SELECT p.title, p.content, u.username FROM posts AS p INNER JOIN users AS u ON u.id = p.author')) {
    $stm->execute();

    $result = $stm->get_result();

    if ($result->num_rows > 0) {
        ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <h1 class="h1-display-h1">Latest Posts</h1>
                    <table class="table table-striped">
                        <tbody>
                            <?php while ($record = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $record['title']; ?></strong><br>
                                        <span class="fst-italic"><?php echo $record['content']; ?></span>
                                        <p>from <?php echo $record['username']; ?></p>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <a href="/cms/posts_add.php">Add new post</a>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo 'No posts found';
    }

    $stm->close();
} else {
    echo 'Could not prepare statement!';
}

include('includes/footer.php');
?>