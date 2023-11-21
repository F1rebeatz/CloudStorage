<?php
/** @var \Kernel\View\ViewInterface $view
 * @var \Kernel\Session\SessionInterface $session
 * @var \App\Models\DirectoryModel $directories
 * @var int $directoryId
 */

?>
<?php $view->component('start') ?>
    <div class="col-6">
        <form action="/files/add" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="formFile" class="form-label">New file name</label>
                <input class="form-control" type="text" name="title" id="formFile">
            </div>
            <?php if ($session->has('title')) { ?>
                <div class="alert alert-danger"><?php echo $session->getFlash('title')[0] ?></div>
            <?php } ?>
            <div class="mb-3">
                <label for="formFile" class="form-label">Add new file</label>
                <input class="form-control" type="file" name="file" id="formFile">
            </div>
            <?php if ($session->has('file')) { ?>
                <div class="alert alert-danger"><?php echo $session->getFlash('file')[0] ?></div>
            <?php } ?>
            <div class="mb-3">
                <label for="directory" class="form-label">Choose a directory</label>
                <select class="form-select" name="directory" id="directory">
                    <option value="<?= $directoryId; ?>">Current Directory</option>
                    <?php
                    foreach ($directories as $directory) { ?>
                        <option
                            value="<?= $directory->getId(); ?>"><?= $directory->getDirectoryName(); ?></option>
                    <?php } ?>
                </select>
            </div>
            <button class="btn btn-primary mt-3" type="submit">Submit</button>
        </form>
    </div>

<?php $view->component('end') ?>