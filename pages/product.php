<?php
$select = mysqli_query($koneksi, "SELECT products.*, categories.category_name FROM products LEFT JOIN categories ON products.category_id = categories.id ORDER BY id DESC");
$rowsProducts = mysqli_fetch_all($select, MYSQLI_ASSOC);


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM products WHERE id = '$id'");
    header('location:?page=product');
}
?>

<div class="card">
    <h5 class="card-header">
        Manage Product
    </h5>
    <div class="card-body">
        <div class="mb-2 justify-content-end" align="right">
            <a href="?page=create-product" class="btn btn-primary"> + Create Product</a>
        </div>
        <div class="table-responsive">
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                $status = "Product creates successfully!";
                $location = "?page=product";
                echo statusSuccess($status, $location);
            }
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Category Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Unit</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rowsProducts as $index => $v) {
                    ?>
                        <tr>
                            <td><?php echo $index + 1 ?></td>
                            <td><img src="assets/uploads/<?php echo $v['product_image'] ?>" alt="" width="80"></td>
                            <td><?php echo $v['product_name'] ?></td>
                            <td><?php echo $v['category_name'] ?></td>
                            <td><?php echo $v['qty'] ?></td>
                            <td>Rp<?php echo number_format($v['price'], 2, ',', '.') ?></td>
                            <td><?php echo $v['unit'] ?></td>
                            <td><?php echo $v['description'] ?></td>
                            <td><?php echo getStatus($v['is_active']) ?></td>
                            <td>
                                <a href="?page=create-product&edit=<?php echo $v['id'] ?>" class="btn btn-success">Edit</a>
                                <form action="?page=product&delete=<?php echo $v['id'] ?>" method="post" class="d-inline">
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