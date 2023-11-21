<?php
/** @var \Kernel\View\ViewInterface $view
 * @var \Kernel\Session\SessionInterface $session
 */

?>
<?php $view->component('start') ?>

<div class="alert alert-danger">
    <?= /** @var string $message */
    $message ?>
</div>

<?php $view->component('end') ?>
