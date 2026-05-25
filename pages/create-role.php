<?php
if (isset($_POST['simpan'])) {
    $name = htmlspecialchars($_POST['name']);
    $is_active = htmlspecialchars($_POST['is_active']);
    $description = $_POST['description'];

    mysqli_query($koneksi, "INSERT INTO roles (name, is_active, description) VALUES ('$name','$is_active','$description')");
    header("location:?page=role&status=success");
}


$id = $_GET['idEdit'] ?? '';
$query = mysqli_query($koneksi, "SELECT * FROM roles WHERE id = '$id'");
$rEdit = mysqli_fetch_assoc($query);

// bisa pilih salah satu (2 poin bawah)
// $id = $_GET['idEdit'] ?? '';
// $id = isset($_GET['idEdit']) ? $_GET['idEdit'] : '';


if (isset($_POST['edit'])) {
    $name = htmlspecialchars($_POST['name']);
    $is_active = htmlspecialchars($_POST['is_active']);
    $description = $_POST['description'];

    mysqli_query($koneksi, "UPDATE roles SET name='$name', is_active='$is_active', description='$description' WHERE id='$id'");
    header('location:?page=role');
}
?>


<div class="card">
    <h5 class="card-header">
        <?php echo isset($_GET['idEdit']) ? 'Edit' : 'Create New' ?> Role
    </h5>
    <div class="card-body">
        <form action="" method="post">
            <div class="row">
                <div class="col-12">
                    <label for="" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name"
                        value="<?php echo isset($_GET['idEdit']) ? $rEdit['name'] : '' ?>" required
                        placeholder="Enter your Name">
                </div>
                <div class="col-12">
                    <label for="" class="form-label">Description</label>
                    <textarea name="description" class="form-control"><?= $id ? $rEdit['description'] : '' ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for="" class="form-label">Status *</label>
                    <input type="radio" name="is_active" value="0"
                        <?= $id ? ($rEdit['is_active'] == 0) ? 'checked' : '' : 'checked' ?>>
                    Inactive
                    <input type="radio" name="is_active" value="1"
                        <?= $id ? ($rEdit['is_active'] == 1) ? 'checked' : '' : 'checked' ?>>
                    Active
                </div>
            </div>
            <div class="text-end mt-2">
                <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>"
                    class="btn btn-primary"><?php echo isset($_GET['edit']) ? 'Save Changes' : 'Save' ?>
                </button>
                <a href="?page=create-role" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>