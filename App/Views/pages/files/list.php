<?php
/** @var \Kernel\View\ViewInterface $view */
/** @var \Kernel\Session\SessionInterface $session */
?>

<?php $view->component('start') ?>
<div class="container mt-4">
    <h2>Your Files and Directories</h2>

    <!-- Display any success or error messages from the session -->
    <?php if ($session->has('success')): ?>
        <div class="alert alert-success">
            <?= $session->get('success') ?>
        </div>
    <?php endif; ?>

    <?php if ($session->has('error')): ?>
        <div class="alert alert-danger">
            <?= $session->get('error') ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($directories)) { ?>

        <!-- List of Directories -->
        <h3>Directories:</h3>
        <ul class="list-group">
            <?php foreach ($directories as $directory): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= $directory['directory_name'] ?>
                    <div>
                        <a href="/files/get/<?= $directory['id'] ?>" class="btn btn-sm btn-primary me-2">View</a>

                        <!-- Форма для удаления директории -->
                        <form method="POST" action="/directories/delete/<?= $directory['id'] ?>">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger" data-action="delete">Delete</button>
                        </form>

                        <!-- Форма для редактирования директории -->
                        <form method="GET" action="/directories/edit/<?= $directory['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-warning" data-action="edit">Edit</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php } ?>


    <?php if (!empty($files)) { ?>
        <!-- List of Files -->
        <h3>Files:</h3>
        <ul class="list-group">
            <?php foreach ($files as $file): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= $file['file_name'] ?>
                    <div>
                        <a href="/files/get/<?= $file['id'] ?>" class="btn btn-sm btn-primary me-2">Download</a>

                        <!-- Форма для удаления файла -->
                        <form method="POST" action="/files/remove/<?= $file['id'] ?>">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger" data-action="delete">Delete</button>
                        </form>

                        <!-- Форма для редактирования файла -->
                        <form method="GET" action="/files/edit/<?= $file['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-warning" data-action="edit">Edit</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php } ?>
    <a class="btn btn-outline-primary mt-3" href="/files/add">Add New File</a>
    <a class="btn btn-outline-success mt-3" href="/directories/add">Create New Directory</a>
</div>
<?php $view->component('end') ?>
