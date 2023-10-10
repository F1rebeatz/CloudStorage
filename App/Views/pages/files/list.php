<?php
/** @var \Kernel\View\ViewInterface $view */
/** @var \Kernel\Session\SessionInterface $session */
/** @var \App\Models\FileModel[] $files */
/** @var \App\Models\DirectoryModel[] $directories */
?>

<?php $view->component('start') ?>
<div class="container mt-4">
    <h2>Your Files and Directories</h2>

    <!-- Display any success or error messages from the session -->
    <?php if ($session->has('success')): ?>
        <div class="alert alert-success">
            <?= $session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?php if ($session->has('error')): ?>
        <div class="alert alert-danger">
            <?= $session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($directories)) { ?>

        <!-- List of Directories -->
        <h3>Directories:</h3>
        <ul class="list-group">
            <?php foreach ($directories as $directory): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= $directory->getDirectoryName() ?>
                    <div>
                        <a href="/files/get/<?= $directory->getId() ?>" class="btn btn-sm btn-primary me-2">View</a>

                        <form method="POST" action="/directories/delete/<?= $directory->getId() ?>">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger" data-action="delete">Delete</button>
                        </form>

                        <form method="GET" action="/directories/edit/<?= $directory->getId() ?>">
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
                    <?= $file->getFilename() ?>
                    <div class="btn-group d-flex gap-2 ">
                        <a href="/files/get/?file=<?= $file->getId() ?>" class="btn btn-sm btn-outline-primary">Download</a>
                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal<?= $file->getId() ?>">Delete
                        </button>
                        <a href="/files/edit/?file=<?= $file->getId() ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                    </div>
                </li>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal<?= $file->getId() ?>" tabindex="-1"
                     aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this file: <?= $file->getFilename() ?>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form method="POST" action="/files/remove/?file=<?= $file->getId() ?>">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </ul>

    <?php } ?>
    <a class="btn btn-outline-primary mt-3" href="/files/add">Add New File</a>
    <a class="btn btn-outline-success mt-3" href="/directories/add">Create New Directory</a>
</div>
<?php $view->component('end') ?>
