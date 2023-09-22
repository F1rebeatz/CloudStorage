<?php
/** @var \App\Kernel\View\View $view
 * @var \App\Kernel\Session\Session $session
 */

?>

<?php $view->component('start') ?>
<h1>Add Files</h1>
<form action="/files/list" method="post">
    <div class="mb-3">
        <!-- <label for="formFile" class="form-label">Add your file</label> -->
        <!-- <input class="form-control" type="file" name="file" id="formFile"> -->
        <label for="formFile" class="form-label">Add your file</label>
        <input class="form-control" type="text" name="name" id="formFile">
        <?php if ($session->has('name')) { ?>
            <ul class="list-group list-group-flush">
                <?php foreach ($session->getFlash('name') as $error) { ?>
                    <li class="list-group-item"><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
</form>
<?php $view->component('end') ?>
