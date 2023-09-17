<?php

session_start();

if (!isset($_SESSION["userid"]) || $_SESSION["userid"] !== true) {
    header("location: login.php");
    exit;
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Hello, <strong><?php echo $_SESSION["name"]; ?></strong>. Welcome to CloudStorage.</h1>
        </div>
        <p>
            <a href="public/index.php" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Log Out</a>
        </p>
    </div>
</div>

<?php include 'template_view.php' ?>
