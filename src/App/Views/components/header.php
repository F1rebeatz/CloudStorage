<?php
/**
 * @var \Kernel\Auth\AuthInterface $auth
 * @var \Kernel\Session\SessionInterface $session
 * @var \Kernel\View\ViewInterface $view
 */
$user = $auth->user();
?>
<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid p-0">
                <a class="navbar-brand" href="/home">CloudStorage</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               href="/directories/get/<?= $session->get('root_directory_id') ?>">Files</a>
                        </li>
                        <?php if ($user && $user->role() == 1) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/users/list">AdminPanel</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php if ($auth->check()) { ?>
                    <div class="d-flex">
                        <h3 class="px-2"><?php echo $user->name() ?? 'email' ?></h3>
                        <form action="/logout" method="post">
                            <button type="submit" class="btn btn-outline-primary">Log Out</button>
                        </form>
                    </div>
                <?php } else { ?>
                    <a href="/login" class="btn btn-outline-primary">Log In</a>
                <?php } ?>
            </div>
        </nav>
    </div>
</header>
