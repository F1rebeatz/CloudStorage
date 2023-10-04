<?php
/** @var \Kernel\View\ViewInterface $view
 * @var \Kernel\Session\SessionInterface $session
 */
?>

<?php $view->component('start') ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="h1 mb-3 text-center">Login</h1>
        <form action="/login" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                       aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            </div>
            <?php if ($session->has('error')) { ?>
                <div class="alert alert-danger"><?php echo $session->getFlash('error') ?></div>
            <?php } ?>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>


<?php $view->component('end') ?>
