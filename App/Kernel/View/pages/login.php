<?php
/** @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Session\SessionInterface $session
 */
?>

<?php $view->component('start') ?>
<h1 class="h1 mb-3">Login</h1>
<form action="/login" method="post">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        <?php if ($session->has('error')) { ?>
            <p class="text-danger">
                <?php echo $session->getFlash('error') ?>
            </p>
        <?php } ?>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">

    </div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>
<?php $view->component('end') ?>
