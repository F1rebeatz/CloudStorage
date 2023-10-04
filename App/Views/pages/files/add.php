<?php
/** @var \Kernel\View\ViewInterface $view
 * @var \Kernel\Session\SessionInterface $session
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
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
</div>
<?php $view->component('end') ?>