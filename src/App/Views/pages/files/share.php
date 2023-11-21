<?php
/** @var \Kernel\View\ViewInterface $view
 * @var \App\Models\FileModel $file
 * @var array $usersWithAccess
 * @var \Kernel\Session\SessionInterface $session
 */
?>

<?php $view->component('start') ?>

    <h2>Share File: <?= $file->getFilename() ?></h2>

    <!-- Display any success or error messages -->
<?php if ($session->has('success')): ?>
    <div class="alert alert-success">
        <?= $session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if ($session->has('error')): ?>
    <div class="alert alert-danger">
        <?= $session->getFlash('error') ?>
    </div>
<?php endif; ?>

    <!-- Form to share file -->
    <form action="/files/share/<?= $file->getId() ?>" method="post">
        <div class="mb-3">
            <label for="recipientEmail" class="form-label">Recipient's Email</label>
            <input type="email" class="form-control" id="recipientEmail" name="recipientEmail" required>
            <input type="hidden" name="_method" value="PUT">
        </div>
        <button type="submit" class="btn btn-primary">Share</button>
    </form>

    <h2>Users with Access</h2>

<?php if (empty($usersWithAccess)): ?>
    <p>No users have access to this file.</p>
<?php else: ?>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($usersWithAccess as $user): ?>
            <tr>
                <td><?= $user->getName() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td>
                    <form method="post" action="/files/share/<?= $file->getId() ?>/<?= $user->getId() ?>">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-danger btn-sm" type="submit">Revoke Access</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>