<?php
/**
 * @var \Kernel\View\ViewInterface $view
 * @var \Kernel\Session\SessionInterface $session
 * @var \App\Models\UserModel $user
 */
?>

<?php $view->component('start') ?>
<h1>User Details</h1>
<a href="/admin/users/list" class="btn btn-primary mt-3">Back to User List</a>

<table class="table mt-4">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?= $user->getId() ?></td>
        <td><?= $user->getName() ?></td>
        <td><?= $user->getEmail() ?></td>
    </tr>
    </tbody>
</table>
<?php $view->component('end') ?>
