<?php
if (isset($_POST['simpan'])) {
    $category_name = $_POST['category_name'];

    $cek = mysqli_query($koneksi, "SELECT * FROM categories WHERE category_name = '$category_name'");
    if (mysqli_num_rows($cek) > 0) {
        header("location:?page=create-category&status=category-exists");
        exit();
    }
    $query = mysqli_query($koneksi, "INSERT INTO categories (category_name) VALUES ('$category_name')");
    if ($query) {
        header("location:?page=category&status=success");
        exit();
    }
}

if (isset($_POST['edit'])) {
    $id = base64_decode($_POST['edit']) ?? '';
    $select = mysqli_query($koneksi, "SELECT * FROM categories WHERE id='$id'");
    $rowEdit = mysqli_fetch_assoc($select);

    if (isset($_POST['edit'])) {
        $category_name = htmlspecialchars($_POST['category_name']);
        $cek = mysqli_query($koneksi, "SELECT category_name FROM categories WHERE category_name='$category_name'");
        if (mysqli_num_row($cek) > 0) {
            header("location:?page=create-category&edit=" . $_GET['edit'] . )
        }
    }

    mysqli_query($koneksi, "UPDATE roles SET name='$name', is_active='$is_active', description='$description' WHERE id='$id'");
    header('location:?page=role');
}
?>
<div class="card">
    <div class="card-header">
        <h5 class="cart-title">Create Category</h5>
    </div>
    <div class="card-body">
        <form action="" class="form-label" method="post">
            <label for="">Category Name</label>
            <input type="text" class="form-control" name="category_name" required>
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'category-exists') {
                $status = "Category Name Already Exist!";
                echo inputFailed($status);
            }
            ?>
            <br>
            <button type="submit" name="simpan" class="btn btn-primary mt-2">Create</button>
            <a href="?page=category" class="btn btn-secondary mt-2">Cancel</a>
        </form>
    </div>
</div>