<?php
    // include main config & template
    include '_main.php';

    // alert
    $alert = null;
    $erroruser = $errorfirst = $errorlast = null;

    // create db
    if(isset($_POST['create'])) {
        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];

        // validation
        if(empty($username)) {
            $alert = "failed";
            $erroruser = "*Username is required!";
        }
        if(empty($firstname)) {
            $alert = "failed";
            $errorfirst = "*Firstname is required!";
        }
        if(empty($lastname)) {
            $alert = "failed";
            $errorlast = "*Lastname is required!";
        }
        // if not empty
        if(!empty($username) && !empty($firstname) && !empty($lastname)) {
            // regex username
            if(preg_match('/^\w{5,}$/', $username)) {
                // check username availability
                $check = mysqli_query($conn, "SELECT * FROM user_details WHERE username='$username'");

                // if exist
                if(mysqli_num_rows($check) != 0) {
                    $alert = "failed";
                    $erroruser = "*Username is already taken!";
                }
                // if available
                else {
                    // query create
                    $query = mysqli_query($conn, "INSERT INTO user_details(username, first_name, last_name, gender) VALUES('$username', '$firstname', '$lastname', '$gender')");

                    // change alert
                    $alert = "success";
                }
            }
            else {
                $alert = "failed";
                $erroruser = "*Username not valid!";
            }
        }
    }
?>
<?=template_header('Create Account')?>
    <div class="container">
        <div class="row mt-5 shadow px-5 py-3 mb-4 bg-white rounded d-flex justify-content-between">
            <h2 class="m-1">Create Account</h2>
            <a href="index.php" class="m-1"><button type="button" class="btn btn-secondary shadow bg-secondary">Back</button></a>
        </div>

        <div class="row p-5 shadow p-3 mb-5 bg-white rounded">
            <form action="create.php" method="post" class="col-12">
                <!-- alert -->
                <?php if($alert == "success"): ?>
                    <div class="alert alert-success" role="alert">User Created Successfully!  <a href="index.php">Show Result</a></div>
                <?php elseif($alert == "failed"): ?>
                    <div class="alert alert-danger" role="alert">Failed to Create User!</div>
                <?php endif; ?>

                <!-- form -->
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Username">
                    <small class="form-text text-muted">Must longer than 5 characters. Can contain letter, number, or underscore. Make sure username is available!</small>
                    <small class="form-text text-danger"><?= $erroruser; ?></small>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="">First Name</label>
                        <input type="text" class="form-control" name="firstname" placeholder="First name">
                    <small class="form-text text-danger"><?= $errorfirst; ?></small>
                    </div>
                    <div class="col">
                        <label for="">Last Name</label>
                        <input type="text" class="form-control" name="lastname" placeholder="Last name">
                        <small class="form-text text-danger"><?= $errorlast; ?></small>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="">Gender</label>
                    <select class="form-control" name="gender">
                        <option value="Male" selected>Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <button type="submit" name="create" class="btn btn-success shadow bg-success btn-block">Create</button>
            </form>
        </div>
    </div>
<?=template_footer()?>