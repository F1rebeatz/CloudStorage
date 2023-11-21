<?php
/**
 * @var \Kernel\View\ViewInterface $view
 * @var \App\Models\FileModel $file
 * @var \App\Models\UserModel $user
 */
?>

<?php $view->component('start') ?>

<h1>File Details</h1>

<table class="table mt-4">
    <tbody>
    <tr>
        <th>File id</th>
        <td><?= $file->getId() ?></td>
    </tr>
    <tr>
        <th>Owner</th>
        <td><?= $user->getName() ?></td>
    </tr>

    <tr>
        <th>File Name</th>
        <td><?= $file->getFilename() ?></td>
    </tr>
    <tr>
        <th>File Extension</th>
        <td><?= $file->getExtension() ?></td>
    </tr>
    <tr>
        <th>Created On</th>
        <td><?= $file->getCreatedAt() ?></td>
    </tr>
    <tr>
        <th>Updated On</th>
        <td><?= $file->getUpdatedAt() ?></td>
    </tr>
    </tbody>
</table>

<a href="/directories/get/<?= $file->getDirectoryId() ?>" class="btn btn-primary mt-3">Back to Directory</a>

<?php $view->component('end') ?>
