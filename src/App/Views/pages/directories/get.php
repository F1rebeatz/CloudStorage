<?php
/** @var \Kernel\View\ViewInterface $view
 * @var \App\Models\DirectoryModel[] $subdirectories
 * @var \Kernel\Session\SessionInterface $session
 * @var \App\Models\FileModel[] $files
 * @var \App\Models\DirectoryModel $directory
 */
?>

<?php $view->component('start') ?>
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
<h2>Directory: <?= $directory->getDirectoryName() ?></h2>
<?php if (!empty($subdirectories)) { ?>

    <!-- List of Directories -->
    <h3>Subdirectories:</h3>
    <ul class="list-group">
        <?php foreach ($subdirectories as $directory): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-between align-items-center">
                    <svg class="me-4" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" width="16" height="16">
                        <defs>
                            <style>.cls-1 {
                                    fill: #101820;
                                }</style>
                        </defs>
                        <title/>
                        <g data-name="Layer 39" id="Layer_39">
                            <path class="cls-1"
                                  d="M4,28a3,3,0,0,1-3-3V7A3,3,0,0,1,4,4h7a1,1,0,0,1,.77.36L14.8,8H27a1,1,0,0,1,0,2H14.33a1,1,0,0,1-.76-.36L10.53,6H4A1,1,0,0,0,3,7V25a1,1,0,0,0,1,1,1,1,0,0,1,0,2Z"/>
                            <path class="cls-1"
                                  d="M25.38,28H4a1,1,0,0,1-1-1.21l3-14A1,1,0,0,1,7,12H30a1,1,0,0,1,1,1.21L28.32,25.63A3,3,0,0,1,25.38,28ZM5.24,26H25.38a1,1,0,0,0,1-.79L28.76,14h-21Z"/>
                        </g>
                    </svg><?= $directory->getDirectoryName() ?></div>
                <div class="btn-group d-flex gap-2">
                    <a href="/directories/get/<?= $directory->getId() ?>" class="btn btn-sm btn-primary me-2">View</a>

                    <form method="POST" action="/directories/remove/<?= $directory->getId() ?>">
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
                <div class="d-flex justify-content-between align-items-center">
                    <svg id="Capa_1" class="me-4" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         width="16px" height="16px" viewBox="0 0 792 792" style="enable-background:new 0 0 792 792;"
                         xml:space="preserve">
    <g>
        <rect x="216" y="432" width="360" height="36"/>
        <rect x="216" y="540" width="360" height="36"/>
        <rect x="216" y="108" width="216" height="36"/>
        <rect x="216" y="648" width="360" height="36"/>
        <rect x="216" y="324" width="360" height="36"/>
        <path d="M666.54,792c0,0,17.46,0,17.46-17.604V158.4L526.896,0H125.46c0,0-17.46,0-17.46,17.604V774.36
			C108,792,125.46,792,125.46,792H666.54z M144,36h360v108c0,36,36,36,36,36h108v576H144V36z"/>
        <rect x="216" y="216" width="360" height="36"/>
    </g>
</svg>
                    <?= $file->getFilename() . '.' . pathinfo($file->getFilepath(), PATHINFO_EXTENSION) ?>
                </div>

                <div class="btn-group d-flex gap-2">
                    <a href="/files/show/<?= $file->getId() ?>" class="btn btn-sm btn-outline-info">Info</a>
                    <a href="/files/get/<?= $file->getId() ?>" class="btn btn-sm btn-outline-primary">Download</a>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal<?= $file->getId() ?>">Delete
                    </button>
                    <a href="/files/edit/<?= $file->getId() ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                    <a href="/files/share/<?= $file->getId() ?>" class="btn btn-sm btn-outline-success">Share</a>
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
                            <form method="POST" action="/files/remove/<?= $file->getId() ?>">
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
<?php if (!$directory->getParentDirectoryId() == null) { ?>
    <a href="/directories/get/<?= $directory->getParentDirectoryId() ?>" class="btn btn-outline-secondary mt-3">
        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-left"
             viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                  d="M11.354 4.354a.5.5 0 0 0-.708-.708L4 10.293V7.5a.5.5 0 0 0-1 0V10a.5.5 0 0 0 .5.5H10a.5.5 0 0 0 0-1H6.207l6.147-6.146a.5.5 0 0 0 0-.708z"/>
        </svg>
        Back
    </a>
<?php } ?>

<a class="btn btn-outline-primary mt-3" href="/files/add?directory=<?= $directory->getId() ?>">Add New File</a>
<a class="btn btn-outline-success mt-3" href="/directories/add?directory=<?= $directory->getId() ?>">Create New
    Directory</a>


<?php $view->component('end') ?>
