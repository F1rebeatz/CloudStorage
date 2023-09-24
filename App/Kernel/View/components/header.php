<?php
/**
 * @var \App\Auth\AuthInterface $auth
 */
$user = $auth->user();
?>
<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">CloudStorage</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                    </ul>
                </div>
                <?php if ($auth->check()) { ?>
                    <div class="d-flex">
                        <h3 class="px-2">User: <?php echo $user->email() ?? 'email' ?></h3>
                        <form action="/logout" method="post">
                            <button type="submit" class="btn btn-outline-primary">Logout</button>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </nav>
    </div>
</header>
