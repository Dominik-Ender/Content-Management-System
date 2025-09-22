<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();
include('includes/header.php');

if (isset($_POST['title'])) {
    if ($stm = $connect->prepare('INSERT INTO posts (title, content, author, date) VALUES(?, ?, ?, ?)')) {
        // $hashed = SHA1($_POST['password']);
        // $stm -> bind_param('ss', $_POST['email'], $hashed);
        $stm->bind_param('ssis', $_POST['title'], $_POST['content'], $_SESSION['id'], $_POST['date']);
        $stm->execute();

        set_message("A new post " . $_POST['username'] . " has been added");
        header('Location: posts.php');
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
            <h1 class="h1-display-h1">Add post</h1>

            <form method="post">
                <!-- Title input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="title">Title</label>
                    <input type="text" id="title" name="title" class="form-control" />
                </div>

                <!-- Content input -->
                <div class="form-outline mb-4">
                    <textarea name="content" id="content"></textarea>
                </div>

                <!-- Date select -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="date">Date</label>
                    <input type="date" id="date" name="date" class="form-control" />
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Add post</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.0.1/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#content'
    });
</script>

<?php
include('includes/footer.php');
?>