<?php
if (isset($_POST['simpan'])) {
    $parent_id = htmlspecialchars($_POST['parent_id']) ?: 'NULL';
    $name = $_POST['name'] ?: 'NULL';
    $url = htmlspecialchars($_POST['url']);
    $icon = htmlspecialchars($_POST['icon']);
    $sort_order = $_POST['sort_order'];
    $is_active = htmlspecialchars($_POST['is_active']);

    mysqli_query($koneksi, "INSERT INTO menus (parent_id, name, url, icon, sort_order, is_active) VALUES ($parent_id,'$name','$url','$icon','$sort_order', 'is_active')");
    header("location:?page=menu&status=success");
}


$id = $_GET['edit'] ?? '';
$query = mysqli_query($koneksi, "SELECT * FROM menus WHERE id = '$id'");
$rEdit = mysqli_fetch_assoc($query);

$queryParent = mysqli_query($koneksi, "SELECT * FROM menus WHERE parent_id is NULL");
$rowParent = mysqli_fetch_all($queryParent, MYSQLI_ASSOC);

// bisa pilih salah satu (2 poin bawah)
// $id = $_GET['edit'] ?? '';
// $id = isset($_GET['edit']) ? $_GET['edit'] : '';


if (isset($_POST['edit'])) {
    $parent_id = $_POST['parent_id'] ?: 'NULL';
    $name = htmlspecialchars($_POST['name']);
    $url = htmlspecialchars($_POST['url']);
    $icon = htmlspecialchars($_POST['icon']);
    $sort_order = $_POST['sort_order'];
    $is_active = htmlspecialchars($_POST['is_active']);

    $update = mysqli_query($koneksi, "UPDATE menus SET parent_id=$parent_id, name='$name', url='$url', icon='$icon', sort_order='$sort_order', is_active='$is_active' WHERE id='$id'");

    header('location:?page=menu');
}
?>


<div class="card">
    <h5 class="card-header">
        <?php echo isset($_GET['edit']) ? 'Edit' : 'Create New' ?> Menu
    </h5>
    <div class="card-body">

        <form action="" method="post">
            <div class="row mb-3">
                <div class="col-6">
                    <label for="" class="form-label">Name *</label>
                    <input type="text" class="form-control" name="name"
                        value="<?php echo isset($_GET['edit']) ? $rEdit['name'] : '' ?>" required
                        placeholder="Enter your Name">
                </div>
                <div class="col-6 mb-3">
                    <label for="" class="form-label">Parent ID</label>
                    <select name="parent_id" id="" class="form-control">
                        <option value="">Select One</option>
                        <?php foreach ($rowParent as $parent): ?>
                            <option value="<?= $parent['id'] ?>">
                                <?= $parent['name'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Icon</label>
                    <input type="text" class="form-control" name="icon" placeholder="Enter Icon"
                        value="<?= $id ? $rEdit['icon'] : '' ?>">
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Sort Order</label>
                    <input type="text" class="form-control" name="sort_order" placeholder="Enter Sort Order"
                        value="<?= $id ? $rEdit['sort_order'] : '' ?>">
                </div>
                <div class="col-6 mt-2">
                    <label for="" class="form-label">URL</label>
                    <input type="text" class="form-control" name="url" placeholder="Enter URL"
                        value="<?= $id ? $rEdit['url'] : '' ?>">
                </div>
                <div class="col-6 mt-3">
                    <label for="" class="form-label d-block">Status</label>
                    <input type="radio" name="is_active" value="1"
                        <?= $id ? ($rEdit['is_active'] == 1) ? 'checked' : '' : 'checked' ?>> Active
                    <input type="radio" name="is_active" value="0"
                        <?= $id ? ($rEdit['is_active'] == 0) ? 'checked' : '' : '' ?>> Inactive
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