<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Register</h2>
            <p>Please fill this form to create an account.</p>

            <?php if (!empty($errors['name'])): ?>
                <p class="text-danger"><?php echo $errors['name']; ?></p>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <?php if (!empty($errors['email'])): ?>
                    <p class="text-danger"><?php echo $errors['email']; ?></p>
                <?php endif; ?>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" required/>
                </div>

                <?php if (!empty($errors['password'])): ?>
                    <p class="text-danger"><?php echo $errors['password']; ?></p>
                <?php endif; ?>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>

                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                </div>
            </form>

            <p>Already have an account? <a href="../../login.php">Login here</a>.</p>
        </div>
    </div>
</div>
