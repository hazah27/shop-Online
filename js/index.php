<?php
    require "connect.php";
    $queryProduct = mysqli_query($con, "SELECT id, name, price, photo, detail FROM product LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Online | Home</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<!-- <style>
    .highlighted-category {
    border: solid;
    height: 250px;
}

.category-male-cloth {
    background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('../image/male-clothing.jpg');
    background-size: cover;
    background-position: center;
}
</style> -->

<body>
    <?php require "navbar.php"; ?>

    <!-- banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Online Shop Fashion</h1>
            <h3>Looking for your style?</h3>
            <div class="col-md-8 offset-md-2">
                <form method="get" action="product.php">
                    <div class="input-group input-group-lg my-4">
                        <input type="text" class="form-control" placeholder="Your Style" 
                        aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword">
                        <button type="submit" class="btn color2 text-white">Seek</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- highlighted category -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Popular Categories</h3>

            <div class="row mt-5">
                <div class="col-md-4 mb-3">
                    <div class="highlighted-category category-male-cloth d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="product.php?categories=Male Clothing">Male Clothes</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlighted-category category-female-cloth d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="product.php?categories=Female Clothing">Female Clothes</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlighted-category category-shoe d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="product.php?categories=Shoe">Shoes</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- about us -->
    <div class="container-fluid color3 py-5">
        <div class="container text-center">
            <h3>About Us</h3>
            <p class="fs-5 mt-3">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptates excepturi, deleniti quam maxime aspernatur voluptas voluptatum ab quia voluptatibus omnis animi fugit accusamus illum magni quasi! Velit delectus reprehenderit iusto, rerum in culpa! Aspernatur at officiis quidem commodi ratione excepturi. Labore at illum natus itaque repellat id voluptate repellendus quaerat quibusdam asperiores, saepe, sed quisquam odio doloribus laboriosam mollitia ad amet minus? Ipsam, tempora accusantium eaque laborum atque harum numquam facilis doloribus rerum, hic repellat, vero eligendi optio aliquam ipsum!
            </p>
        </div>
    </div>

    <!-- product -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Product</h3>

            <div class="row mt-5">
                <?php while($data = mysqli_fetch_array($queryProduct)) { ?>
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="image-box">
                            <img src="../image/<?php echo $data['photo']; ?>" class="card-img-top" alt="">
                        </div>
                        
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $data['name']; ?></h4>
                            <p class="card-text text-truncate">
                                <?php echo $data['detail']; ?>
                            </p>
                            <p class="card-text price-text">RM <?php echo $data['price']; ?></p>
                            <a href="product-detail.php?name=<?php echo $data['name']; ?>" class="btn color2 text-white">See Detail</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
            </div>
            <a class="btn btn-outline-warning mt-3" href="product.php">See More</a>
        </div>
    </div>

    <!-- footer -->
    <?php require "footer.php"; ?>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
    
</body>
</html>