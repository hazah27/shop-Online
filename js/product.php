<?php
    require "connect.php";

    $queryCategory = mysqli_query($con, "SELECT * FROM categories");

    // get product by product name/keyword
    if(isset($_GET['keyword']))
    {
        $queryProduct = mysqli_query($con, "SELECT * FROM product WHERE name LIKE '%$_GET[keyword]%'");
    }

    // get product by category
    else if(isset($_GET['category'])) 
    {
        $queryCategoryId = mysqli_query($con, "SELECT id FROM categories WHERE name='$_GET[category]'");
        $categoryId = mysqli_fetch_array($queryCategoryId);

        $queryProduct = mysqli_query($con, "SELECT * FROM product WHERE categories_id='$categoryId[id]'");
    }

    // get product default
    else
    {
        $queryProduct = mysqli_query($con, "SELECT * FROM product");
    }

    $countData = mysqli_num_rows($queryProduct);
    // echo $countData;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Online | Product</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <!-- banner -->
    <div class="container-fluid banner-product">
        <div class="container">
            <h1 class="text-white text-center">Product</h1>
        </div>
    </div>

    <!-- body -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3>Category</h3>
                <ul class="list-group">
                    <?php while($category = mysqli_fetch_array($queryCategory)) { ?>
                        <a class="no-decoration" href="product.php?category=<?php echo $category['name']; ?>">
                            <li class="list-group-item"><?php echo $category['name']; ?></li>
                            </a>
                <?php } ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Product</h3>
                <div class="row">
                    <?php
                        if($countData<1)
                        {
                            ?>
                            <h4 class="text-center my-5">Product does not exist</h4>
                            <?php
                        }
                    ?>



                    <?php while($product = mysqli_fetch_array($queryProduct)) { ?>
                    <div class="col-md-4 mb-5">
                        <div class="card h-100">
                            <div class="image-box">
                                <img src="../image/<?php echo $product['photo']; ?>" class="card-img-top" alt="">
                            </div>
                            
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $product['name']; ?></h4>
                                <p class="card-text text-truncate">
                                    <?php echo $product['detail']; ?>
                                </p>
                                <p class="card-text price-text">RM <?php echo $product['price']; ?></p>
                                <a href="product-detail.php?name=<?php echo $product['name']; ?>" class="btn color2 text-white">See Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php require "footer.php"; ?>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
    
</body>
</html>