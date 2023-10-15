<?php
/** @var \Kernel\View\ViewInterface $view
 * @var \Kernel\Session\SessionInterface $session
 * @var \App\Models\UserModel [] $users
 */
?>

<?php $view->component('start') ?>
<h1>Admin - Users</h1>
<?php if (isset($success)): ?>
    <div class="alert alert-success mt-3">
        <?= $success ?>
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger mt-3">
        <?= $error ?>
    </div>
<?php endif; ?>

<a href="/admin/users/list" class="btn btn-primary mt-3">Back to User List</a>

<table class="table mt-4">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user->getId()?></td>
            <td><?= $user->getName() ?></td>
            <td><?= $user->getEmail() ?></td>
            <td>
                <a href="/admin/users/show/<?= $user->getId() ?>" class="btn btn-info">View</a>
                <a href="/admin/users/edit/<?=  $user->getId() ?>" class="btn btn-warning">Edit</a>
                <a href="/admin/users/delete/<?=  $user->getId() ?>" class="btn btn-danger"
                   onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $view->component('end') ?>