<?php
/** @var \Kernel\View\ViewInterface $view
 * @var \Kernel\Session\SessionInterface $session
 * @var \App\Models\DirectoryModel $directory
 * @var \App\Models\DirectoryModel[] $subdirectories
 */
?>
<?php $view->component('start') ?>
<div class="col-6">
    <h2>Edit Directory</h2>
    <form action="/directories/edit/<?= $directory->getId() ?>" method="POST">
        <input type="hidden" name="_method" value="PUT">
        <div class="mb-3">
            <label for="name" class="form-label">Directory Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $directory->getDirectoryName() ?>">
        </div>
        <?php if ($session->has('name')): ?>
            <div class="alert alert-danger"><?= $session->getFlash('name')[0] ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="parent" class="form-label">Parent Directory</label>
            <select class="form-select" id="parent" name="parent">
                <option value="0">Root Directory</option>
                <?php foreach ($subdirectories as $subdirectory): ?>
                    <option value="<?= $subdirectory->getId() ?>"
                        <?= $subdirectory->getId() === $directory->getParentDirectoryId() ? 'selected' : '' ?>>
                        <?= $subdirectory->getDirectoryName() ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Directory</button>
    </form>
</div>
<?php $view->component('end') ?>
