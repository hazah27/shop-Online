<?php
    require "connect.php";

    $name = htmlspecialchars($_GET['name']);
    $queryProduct = mysqli_query($con, "SELECT * FROM product  WHERE name='$name'");
    $product = mysqli_fetch_array($queryProduct);
    // var_dump($product);

    $querySimilarProduct = mysqli_query($con, "SELECT * FROM product WHERE categories_id='$product[categories_id]' AND id!='$product[id]' LIMIT 4");
    // $similarProduct = mysqli_fetch_array($querySimilarProduct);
    // var_dump($similarProduct);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Online | Detail</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <!-- detail product -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-5">
                    <img src="../image/<?php echo $product['photo']; ?>" class="w-100" alt="">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h1><?php echo $product['name']; ?></h1>
                    <p class="fs-5">
                        <?php echo $product['detail']; ?>
                    </p>

                    <p class="price-text">
                        RM <?php echo $product['price']; ?>
                    </p>

                    <p class="fs-5">
                        Status: <strong><?php echo $product['in_stock']; ?></strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- similar product -->
    <div class="container-fluid py-5 color2">
        <div class="container">
            <h2 class="text-center text-white mb-5">Similar Product</h2>

            <div class="row">
                <?php while($data = mysqli_fetch_array($querySimilarProduct)) { ?>
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="product-detail.php?name=<?php echo $data['name']; ?>">
                        <img src="../image/<?php echo $data['photo']; ?>" class="img-fluid img-thumbnail similar-product-image" alt="">
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php require "footer.php"; ?>    

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>