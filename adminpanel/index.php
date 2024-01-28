<?php
    require "session.php";
    require "../js/connect.php";

    $queryCategories = mysqli_query($con, "SELECT * FROM categories");
    $totalCategories = mysqli_num_rows($queryCategories);
    // echo $totalCategories;

    $queryProduct = mysqli_query($con, "SELECT * FROM product");
    $totalProduct = mysqli_num_rows($queryProduct);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .box {
        border: solid;
    }

    .summary-categories {
        background-color: #FFC0CB;
        border-radius: 15px;
    }

    .summary-product {
        background-color: #FF91A4;
        border-radius: 15px;
    }

    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-home"></i> Home</li>
            </ol>
        </nav>
        <h2>Hello <?php echo $_SESSION['username']; ?></h2>

        <div class="container mt-5">
            <div class="row">

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-categories p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-align-justify fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Categories</h3>
                                <p class="fs-4"><?php echo $totalCategories; ?> Categories</p>
                                <p><a href="categories.php" class="text-white no-decoration">See Detail...</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-product p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-box fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Product</h3>
                                <p class="fs-4"><?php echo $totalProduct; ?> Products</p>
                                <p><a href="product.php" class="text-white no-decoration">See Detail...</a></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>