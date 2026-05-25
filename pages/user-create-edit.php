<?php
if (isset($_POST['simpan'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $passSha = sha1($password);

    if($password !== $password_confirm) {
        header("location:?page=user-create-edit&status=password_not_match");
        exit();
    }
    $cekEmail = mysqli_query($koneksi, "SELECT id FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($cekEmail) > 0) {
        header('location:?page=user-create-edit&status=email_exists');
        exit();
    }
    
    mysqli_query($koneksi, "INSERT INTO users (name, email, password) VALUES ('$name','$email','$passSha')");
    header("location:?page=user&status=success");
    exit();
}
    
    // if ($password == $confirm) {
    //     exit();
    // } else {
    //     header("location:?page=user-create-edit&status=error");
    //     exit();
    // }


$id = $_GET['idEdit'] ?? '';
$selectUser = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$id'");
$rEdit = mysqli_fetch_assoc($selectUser);

// bisa pilih salah satu (2 poin bawah)
// $id = $_GET['idEdit'] ?? '';
// $id = isset($_GET['idEdit']) ? $_GET['idEdit'] : '';

    
if (isset($_POST['edit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $passSha = sha1($password);

    
    if (empty($password)) {
        mysqli_query($koneksi, "UPDATE users SET name='$name', email='$email' WHERE id='$id'");
        header('location:?page=user');
        exit();
    }    
    if ($password !== $password_confirm) {
        header('location:?page=user-create-edit&idEdit='.$id.'&status=password_not_match');
        exit();
        
    }
    mysqli_query($koneksi, "UPDATE users SET name='$name', email='$email', password='$passSha' WHERE id='$id'");
    header('location:?page=user');
    
        // if ($updateUser) {
        //     header('location:?page=user');
        //     exit();
        // }
    
}

$status = $_GET['status'] ?? '';

?>

<div class="card">
    <h5 class="card-header">
        <?php echo isset($_GET['idEdit']) ? 'Edit' : 'Create New' ?> User
    </h5>
    <div class="card-body">
        <?php if($status == 'password_not_match'):?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Error!</strong>Password Not Match
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
        <?php endif?>
        <?php 
        if ($status == 'email_exists') {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Error!</strong>This Email Already Exists
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
            </div>';
        }
        ?>
        <form action="" method="post">
            <div class="row">
                <div class="col-6">
                    <label for="" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name"
                        value="<?php echo isset($_GET['idEdit']) ? $rEdit['name'] : '' ?>" required
                        placeholder="Enter your Name">
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Email *</label>
                    <input type="email" class="form-control" name="email"
                        value="<?php echo isset($_GET['idEdit']) ? $rEdit['email'] : '' ?>" required
                        placeholder="ex:admin@gmail.com">
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="" class="form-label">Password *</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter Password"
                        <?= $id ? 'required' : '' ?>>
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Password Confirm *</label>
                    <input type="password" class="form-control" name="password_confirm"
                        placeholder="Enter Password Confirm" <?= $id ? 'required' : '' ?>>
                </div>
                <div class="mt-2 text-secondary">
                    <p>Leave blank if you don't want to change the password</p>
                </div>
            </div>
            <div class="text-end mt-2">
                <button type="submit" class="btn btn-primary"
                    name="<?php echo isset($_GET['idEdit']) ? 'edit' : 'simpan' ?>"><?php echo isset($_GET['idEdit']) ? 'Save Changes' : 'Save' ?></button>
                <a href="?page=user" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>