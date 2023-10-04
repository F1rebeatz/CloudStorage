<?php
/** @var \Kernel\View\View $view
 **  @var \Kernel\Auth\AuthInterface $auth
 */
?>

<?php $view->component('start') ?>
    <div>

    </div>
    <div class="mx-auto mt-3 text-center">
    <h1>CloudStorage</h1>
    <p>Simple file storage</p>
<?php if ($auth->check()) { ?>
    <a href="/files/list" class="btn btn-outline-primary ">View Files</a>
    </div>
<?php } ?>
<?php $view->component('end') ?>