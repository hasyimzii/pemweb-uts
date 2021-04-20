<?php
    // include main config & template
    include '_main.php';

    
?>
<?=template_header('Create Account')?>
    <div class="container">
        <div class="row mt-5 shadow px-5 py-3 mb-4 bg-white rounded d-flex justify-content-between">
            <h2 class="m-1">Create Account</h2>
            <a href="index.php" class="m-1"><button type="button" class="btn btn-secondary shadow bg-secondary">Back</button></a>
        </div>

        <div class="row p-5 shadow p-3 mb-5 bg-white rounded">
            <form action="create.php" method="post" class="col-12">
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Username">
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="">First Name</label>
                        <input type="text" class="form-control" name="firstname" placeholder="First name">
                    </div>
                    <div class="col">
                        <label for="">Last Name</label>
                        <input type="text" class="form-control" name="lastname" placeholder="Last name">
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="">Gender</label>
                    <select class="form-control" name="gender">
                        <option selected>Male</option>
                        <option>Female</option>
                    </select>
                </div>
                <button type="submit" name="submit" class="btn btn-success shadow bg-success btn-block">Create</button>
            </form>
        </div>
    </div>
<?=template_footer()?>