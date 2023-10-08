<?php
/** @var \Kernel\View\View $view
 **  @var \Kernel\Auth\AuthInterface $auth
 */
?>

<?php $view->component('start') ?>
    <div class="mx-auto mt-3 text-center">
        <h1>Welcome to CloudStorage</h1>
        <p>Simple file storage</p>
        <?php if ($auth->check()) { ?>
          <a href="/files/list" class="btn btn-outline-primary">View Files</a>
        <?php } else { ?>
            <p>Do you have an account?</p>
            <a href="/login" class="btn btn-outline-primary">Log In</a>
            <span>or</span>
            <a href="/register" class="btn btn-primary">Register</a>
        <?php } ?>
    </div>
<?php $view->component('end') ?>