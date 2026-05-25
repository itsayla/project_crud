<?php
$selectUser = mysqli_query($koneksi, "SELECT users.name, users.email, users.id FROM users ORDER BY id DESC");
$rows = mysqli_fetch_all($selectUser, MYSQLI_ASSOC);


if (isset($_GET['delete'])) {
    $id = $_GET['delete'] ?? '';
    $deleteUser = mysqli_query($koneksi, "DELETE FROM users WHERE id = '$id'");
    header('location:?page=user');
    exit();
}
?>

<div class="card">
    <h5 class="card-header">
        User Data
    </h5>
    <div class="card-body">
        <div class="mb-2" align="right">
            <a href="?page=user-create-edit" class="btn btn-primary"> + Create New User</a>
        </div>
        <div class="table-responsive">
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                $status = "Data Berhasil Ditambahkan!";
                $location = "?page=user";
                echo statusSuccess($status, $location);
            }
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
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
                            <td><?php echo $row['email'] ?></td>
                            <td>
                                <a href="?page=user-create-edit&idEdit=<?php echo $row['id'] ?>"
                                    class="btn btn-success">Edit</a>
                                <form action="?page=user&delete=<?php echo $row['id'] ?>" method="post" class="d-inline">
                                    <button class="btn btn-danger"
                                        onclick="return confirm('YAKIN MAU DIDELETE?')">Delete</button>
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