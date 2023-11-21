<?php
/** @var \Kernel\View\ViewInterface $view
 * @var \Kernel\Session\SessionInterface $session
 * @var \App\Models\DirectoryModel $subdirectories
 * @var \App\Models\FileModel $file
 * @var int $directoryId
 */

?>
<?php $view->component('start') ?>
    <div class="col-6">
        <form action="/files/edit/" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="formFile" class="form-label">New file name</label>
                <input class="form-control" type="text" name="title" id="formFile"
                       value="<?php echo $file->getFilename() ?>">
                <input type="hidden" name="fileId" value="<?= $file->getId() ?>">
            </div>
            <?php if ($session->has('title')) { ?>
                <div class="alert alert-danger"><?php echo $session->getFlash('title')[0] ?></div>
            <?php } ?>

            <div class="mb-3">
                <label for="directory" class="form-label">Choose a directory</label>
                <select class="form-select" name="directory" id="directory">
                    <option value="<?= $directoryId; ?>">Current Directory</option>
                    <?php foreach ($subdirectories as $directory) { ?>
                        <option
                            value="<?php echo $directory->getId(); ?>" <?php echo $directory->getId() == $file->getDirectoryId() ? 'selected' : '' ?>>
                            <?php echo $directory->getDirectoryName(); ?></option>
                    <?php } ?>
                </select>
            </div>

            <button class="btn btn-primary mt-3" type="submit">Update</button>
        </form>
    </div>

<?php $view->component('end') ?>