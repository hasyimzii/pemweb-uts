<?php
    // include main config & template
    include '_main.php';

    // pagination
    $limit = 10;
    $page = isset($_GET['page'])?(int)$_GET['page'] : 1;
    $first_page = ($page>1) ? ($page * $limit) - $limit : 0;

    // navigate
    $previous = $page - 1;
    $next = $page + 1;

    // connect & query read db
    $query = mysqli_query($conn, "SELECT * FROM user_details ORDER BY user_id DESC");
    $total_result = mysqli_num_rows($query);
    $total_page = ceil($total_result / $limit);

    // limited query
    $limited = mysqli_query($conn,"SELECT * FROM user_details ORDER BY user_id DESC LIMIT $first_page, $limit");

?>
<?=template_header('Account List')?>
    <div class="container">
        <div class="row mt-5 shadow px-5 py-3 mb-4 bg-white rounded d-flex justify-content-between">
            <h2 class="m-1">Account List</h2>
            <a href="create.php" class="m-1"><button type="button" class="btn btn-success shadow bg-success">Create</button></a>
        </div>

        <div class="row p-5 shadow p-3 mb-5 bg-white rounded">

            <!-- table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // fetch as array
                        $n = $first_page + 1;
                        while($user = mysqli_fetch_array($limited)):
                    ?>
                    <tr class="p-3">
                        <th scope="row" class="align-middle"><?= $n++; ?></th>
                        <td class="align-middle"><?= $user['username'] ?></td>
                        <td class="align-middle"><?= $user['first_name'] ?></td>
                        <td class="align-middle"><?= $user['last_name'] ?></td>
                        <td class="align-middle"><?= $user['gender'] ?></td>
                        <td class="align-middle">
                        <div class="btn-group" role="group">
                            <a href="edit.php?id=<?= encrypt($user['user_id']); ?>"><button type="button" class="btn btn-warning shadow bg-warning text-white rounded-0"><i class="fas fa-pen fa-sm"></i></button></a>
                            <a href="delete.php?id=<?= encrypt($user['user_id']); ?>"><button type="button" class="btn btn-danger shadow bg-danger text-white rounded-0"><i class="fas fa-trash fa-sm"></i></button></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" <?php if($page > 1){ echo "href='?page=$previous'"; } ?>>Previous</a>
                    </li>
                    <!-- if on first/second page -->
                    <?php if($page <= 2): ?>
                        <?php for($x = 1; $x <= 5; $x++): ?>
                            <!-- active page -->
                            <?php if($x == $page): ?>
                                <li class="page-item active"><a class="page-link" href="?page=<?php echo $x ?>"><?php echo $x; ?></a></li>
                            
                            <!-- other -->
                            <?php else: ?>
                                <li class="page-item"><a class="page-link" href="?page=<?php echo $x ?>"><?php echo $x; ?></a></li>
                            <?php endif; ?>
                        <?php endfor; ?>

                    <!-- if on 3 last page -->
                    <?php elseif($page >= $total_page - 3): ?>
                        <?php for($x = $total_page - 5; $x <= $total_page; $x++): ?>
                            <!-- active page -->
                            <?php if($x == $page): ?>
                                <li class="page-item active"><a class="page-link" href="?page=<?php echo $x ?>"><?php echo $x; ?></a></li>
                            
                            <!-- other -->
                            <?php else: ?>
                                <li class="page-item"><a class="page-link" href="?page=<?php echo $x ?>"><?php echo $x; ?></a></li>
                            <?php endif; ?>
                        <?php endfor; ?>
                    
                    <!-- other page -->
                    <?php else: ?>
                        <?php for($x = $previous - 1; $x <= $next + 1; $x++): ?>
                            <!-- active page -->
                            <?php if($x == $page): ?>
                                <li class="page-item active"><a class="page-link" href="?page=<?php echo $x ?>"><?php echo $x; ?></a></li>
                            
                            <!-- other -->
                            <?php else: ?>
                                <li class="page-item"><a class="page-link" href="?page=<?php echo $x ?>"><?php echo $x; ?></a></li>
                            <?php endif; ?>
                        <?php endfor; ?>
                    <?php endif; ?>
                    				
                    <li class="page-item">
                        <a  class="page-link" <?php if($page < $total_page) { echo "href='?page=$next'"; } ?>>Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
<?=template_footer()?>