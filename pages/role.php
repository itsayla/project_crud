<?php
$query = mysqli_query($koneksi, "SELECT * FROM roles ORDER BY id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM roles WHERE id = '$id'");
    header('location:?page=role');
}
?>

<div class="card">
    <h5 class="card-header">
        Manage Role
    </h5>
    <div class="card-body">
        <div class="mb-2" align="right">
            <a href="?page=create-role" class="btn btn-primary"> + Create New Role</a>
        </div>
        <div class="table-responsive">
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                $status = "Role creates successfully!";
                $location = "?page=role";
                echo statusSuccess($status, $location);
            }
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $index => $row) {
                    ?>
                    <tr>
                        <td><?php echo $index + 1 ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo getStatus($row['is_active']) ?></td>
                        <td><?php echo $row['description'] ?></td>
                        <td>
                            <a href="?page=create-role&edit=<?php echo $row['id'] ?>" class="btn btn-success">Edit</a>
                            <form action="?page=role&delete=<?php echo $row['id'] ?>" method="post" class="d-inline">
                                <button class="btn btn-danger"
                                    onclick="return confirm('Are you sure to delete this data?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>