<?php
/** @var \Kernel\View\ViewInterface $view
 * @var \Kernel\Session\SessionInterface $session
 */
?>

<?php $view->component('start') ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="h1 mb-3">Register</h1>
        <form action="/register" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Your name</label>
                <input type="text" class="form-control <?php echo $session->has('name') ? 'is-invalid' : '' ?>" name="name" id="name" aria-describedby="name" placeholder="Alex Burk">
                <?php if ($session->has('name')) { ?>
                    <div class="invalid-feedback">
                        <?php echo $session->getFlash('name')[0]; ?>
                    </div>
                <?php } ?>
                <div id="name" class="form-text">Just your name</div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control <?php echo $session->has('email') ? 'is-invalid' : '' ?>" name="email" id="email" aria-describedby="emailHelp" placeholder="example@mail.ru">
                <?php if ($session->has('email')) { ?>
                    <div class="invalid-feedback">
                        <?php echo $session->getFlash('email')[0]; ?>
                    </div>
                <?php } ?>
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control <?php echo $session->has('password') ? 'is-invalid' : '' ?>" id="password" placeholder="***********">
                <?php if ($session->has('password')) { ?>
                    <div class="invalid-feedback">
                        <?php echo $session->getFlash('password')[0]; ?>
                    </div>
                <?php } ?>
            </div>

            <div id="passwordHelpBlock" class="form-text mb-2">
                Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm password</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>



<?php $view->component('end') ?>
