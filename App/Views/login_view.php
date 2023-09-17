<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Login</h2>
            <p>Please fill in your email and password.</p>
            <form action="" method="post">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" required/>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <?php echo $error; ?>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                </div>
                <p>Don't have an account? <a href="../../register.php">Register here</a>.</p>
            </form>
        </div>
    </div>
</div>
