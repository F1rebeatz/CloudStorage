<?php
/** @var \Kernel\View\ViewInterface $view
 * @var \App\Models\DirectoryModel[] $subdirectories
 * @var \App\Models\FileModel[] $files
 * @var \App\Models\DirectoryModel $currentDirectory
 */

?>

<?php $view->component('start') ?>
<div class="col-6">
    <h1>Directory: <?= $currentDirectory->getDirectoryName() ?></h1>
    <a href="/files/add?directory=<?= $currentDirectory->getId() ?>" class="btn btn-primary">Add File</a>
    <a href="/directories/add?parent_directory=<?= $currentDirectory->getId() ?>" class="btn btn-success">Add Subdirectory</a>


    <?php if (!empty($subdirectories)) { ?>
        <h2>Subdirectories:</h2>
        <ul>
            <?php foreach ($subdirectories as $subdirectory) { ?>
                <li>
                    <a href="/directory/get?directory=<?= $subdirectory->getId() ?>">
                        <?= $subdirectory->getDirectoryName() ?>
                    </a>
                    <a href="/directories/edit?directory=<?= $subdirectory->getId() ?>" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="/directories/remove?directory=<?= $subdirectory->getId() ?>">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger" data-action="delete">Delete</button>
                    </form>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>


    <?php if (!empty($files)) { ?>
        <h2>Files:</h2>
        <ul>
            <?php foreach ($files as $file) { ?>
                <li>
                    <?= $file->getFilename() ?>
                    <a href="/files/edit?file=<?= $file->getId() ?>" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="/files/remove?file=<?= $file->getId() ?>">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger" data-action="delete">Delete</button>
                    </form>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</div>
<?php $view->component('end') ?>
