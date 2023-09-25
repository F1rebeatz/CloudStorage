<?php
/** @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Session\SessionInterface $session
 */
?>

<?php $view->component('start') ?>
<h1 class="h1 mb-3">Register</h1>
<form action="/register" method="post">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
        <?php if ($session->has('email')) { ?>
            <ul class="list-group list-group-flush">
                <?php foreach ($session->getFlash('email') as $error) { ?>
                    <li class="list-group-item"><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
        <?php if ($session->has('password')) { ?>
            <ul class="list-group list-group-flush">
                <?php foreach ($session->getFlash('password') as $error) { ?>
                    <li class="list-group-item"><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php $view->component('end') ?>
