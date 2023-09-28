<?php
/** @var \Kernel\View\View $view
 * @var \Kernel\Session\Session $session
 */
?>

<?php $view->component('start') ?>
<h2>Your files</h2>
<form action="/files/list" method="post" enctype="multipart/form-data">
    <div class="mb-3">
         <label for="formFile" class="form-label">Add new file</label>
         <input class="form-control" type="file" name="file" id="formFile">
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
</form>
<?php $view->component('end') ?>
