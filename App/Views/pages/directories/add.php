<?php
/** @var \Kernel\View\ViewInterface $view
 * @var \Kernel\Session\SessionInterface $session
 * @var \App\Models\DirectoryModel[] $subdirectories
 * @var int $directoryId
 */

?>
<?php $view->component('start') ?>
<div class="col-6">
    <h1>Add New Directory</h1>
    <form action="/directories/add" method="post">
        <div class="mb-3">
            <label for="directory_name" class="form-label">Directory Name</label>
            <input class="form-control" type="text" name="directory_name" id="directory_name" required>
        </div>
        <?php if ($session->has('directory_name')) { ?>
            <div class="alert alert-danger"><?php echo $session->getFlash('directory_name')[0] ?></div>
        <?php } ?>
        <button class="btn btn-primary" type="submit">Create Directory</button>
    </form>
</div>
<?php $view->component('end') ?>
