<?php
/**
 * @var \Kernel\View\ViewInterface $view
 * @var \Kernel\Session\SessionInterface $session
 * @var \App\Models\UserModel $user
 */
?>

<?php $view->component('start') ?>
<h1>Edit User</h1>
<a href="/admin/users/list" class="btn btn-primary mt-3">Back to User List</a>

<form action="/admin/users/edit/<?= $user->getId() ?>" method="post" class="mt-4">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control <?php if ($session->has('name')) echo 'is-invalid'; ?>" id="name" name="name" value="<?= $user->getName() ?>">
        <?php if ($session->has('name')) { ?>
            <div class="invalid-feedback">
                <?= $session->getFlash('name')[0] ?>
            </div>
        <?php } ?>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control <?php if ($session->has('email')) echo 'is-invalid'; ?>" id="email" name="email" value="<?= $user->getEmail() ?>">
        <?php if ($session->has('email')) { ?>
            <div class="invalid-feedback">
                <?= $session->getFlash('email')[0] ?>
            </div>
        <?php } ?>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control <?php if ($session->has('password')) echo 'is-invalid'; ?>" id="password" name="password">
        <?php if ($session->has('password')) { ?>
            <div class="invalid-feedback">
                <?= $session->getFlash('password')[0] ?>
            </div>
        <?php } ?>
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" class="form-control <?php if ($session->has('password_confirmation')) echo 'is-invalid'; ?>" id="password_confirmation" name="password_confirmation">
        <?php if ($session->has('password_confirmation')) { ?>
            <div class="invalid-feedback">
                <?= $session->getFlash('password_confirmation')[0] ?>
            </div>
        <?php } ?>
    </div>
    <button type="submit" class="btn btn-success">Save</button>
</form>

<?php $view->component('end') ?>
