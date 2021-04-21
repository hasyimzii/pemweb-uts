<?php
    // include main config & template
    include '_main.php';

    // edit page
    // get decrypted id
    $id = decrypt($_GET['id']);
    // query fetch by id
    $query = mysqli_query($conn, "SELECT * FROM user_details WHERE user_id=$id");
    // fetch as associative
    $user = mysqli_fetch_assoc($query);

    // alert
    $alert = null;
    $erroruser = $errorfirst = $errorlast = null;

    // update db
    if(isset($_POST['update'])) {
        // get decrypted id
        $id = decrypt($_POST['id']);

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
                    // query update
                    $query = mysqli_query($conn, "UPDATE user_details SET username='$username',first_name='$firstname',last_name='$lastname', gender='$gender' WHERE user_id=$id");
                
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
<?=template_header('Edit Account')?>
    <div class="container">
        <div class="row mt-5 shadow px-5 py-3 mb-4 bg-white rounded d-flex justify-content-between">
            <h2 class="m-1">Edit Account</h2>
            <a href="index.php" class="m-1"><button type="button" class="btn btn-secondary shadow bg-secondary">Back</button></a>
        </div>

        <div class="row p-5 shadow p-3 mb-5 bg-white rounded">
            <form action="" method="post" class="col-12">
                <!-- alert -->
                <?php if($alert == "success"): ?>
                    <div class="alert alert-success" role="alert">User Updated Successfully!  <a href="index.php">Show Result</a></div>
                <?php elseif($alert == "failed"): ?>
                    <div class="alert alert-danger" role="alert">Failed to Update User!</div>
                <?php endif; ?>

                <!-- form -->
                <input type="hidden" name="id" value=<?= encrypt($id);?>>
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" class="form-control" name="username" value="<?= $user['username']; ?>">
                    <small class="form-text text-muted">Must longer than 5 characters. Can contain letter, number, or underscore. Make sure username is available!</small>
                    <small class="form-text text-danger"><?= $erroruser; ?></small>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="">First Name</label>
                        <input type="text" class="form-control" name="firstname" value="<?= $user['first_name']; ?>">
                        <small class="form-text text-danger"><?= $errorfirst; ?></small>
                    </div>
                    <div class="col">
                        <label for="">Last Name</label>
                        <input type="text" class="form-control" name="lastname" value="<?= $user['last_name']; ?>">
                        <small class="form-text text-danger"><?= $errorlast; ?></small>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="">Gender</label>
                    <select class="form-control" name="gender">
                        <option <?= $user['gender']=="Male" ? 'selected' : ''; ?>>Male</option>
                        <option <?= $user['gender']=="Female" ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>
                <button type="submit" name="update" class="btn btn-warning btn-block shadow bg-warning text-white">Update</button>
            </form>
        </div>
    </div>
<?=template_footer()?>