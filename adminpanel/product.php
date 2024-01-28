<?php
    require "session.php";
    require "../js/connect.php";

    $queryProduct = mysqli_query($con, "SELECT a.*, b.name AS name_categories FROM product a JOIN categories b ON a.categories_id=b.id");
    $totalProduct = mysqli_num_rows($queryProduct);
    // echo $totalProduct;

    $queryCategories = mysqli_query($con, "SELECT * FROM categories");
    
    // create name to image
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for($i = 0; $i < $length; $i++)
        {
            $randomString .= $characters[rand(0,$charactersLength - 1)];
        }
        return $randomString;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }

    form div{
        margin-bottom: 10px;
    }
</style>

<body>

    <?php require "navbar.php"; ?>
        <div class="container mt-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="../adminpanel" class="no-decoration text-muted">
                            <i class="fas fa-home"></i> Home</a></li>
                        
                        <li class="breadcrumb-item active" aria-current="page">
                        Products</li>
                </ol>
            </nav>

            <!--add product -->
            <div class="my-5 col-12 col-md-6">
                <h3>Add Categories</h3>

                <form action="" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" autocomplete="off" required>
                    </div>

                    <div>
                        <label for="categories">Categories</label>
                        <select name="categories" id="categories" class="form-control" required>
                            <option value="">Please Choose</option>
                            <?php
                                while($data=mysqli_fetch_array($queryCategories))
                                {
                                    ?>
                                    <option value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="price">Price</label>
                        <input type="number" class="form-control" name="price" autocomplete="off" required>
                    </div>

                    <div>
                        <label for="image">Photo</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <div>
                        <label for="detail">Detail</label>
                        <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
                    </div>

                    <div>
                        <label for="ready_stock">Ready Stock</label>
                        <select name="ready_stock" id="ready_stock" class="form-control">
                            <option value="instock">Instock</option>
                            <option value="sold">Sold</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                </form>

                <?php
                    if(isset($_POST['submit']))
                    {
                        $name = htmlspecialchars($_POST['name']);
                        $category = htmlspecialchars($_POST['categories']);
                        $price = htmlspecialchars($_POST['price']);
                        $detail = htmlspecialchars($_POST['detail']);
                        $stock = htmlspecialchars($_POST['ready_stock']);

                        $target_dir = "../image/";
                        // var_dump ($target_dir);
                        $name_file = basename($_FILES["image"]["name"]);
                        // var_dump ($name_file);
                        $target_file = $target_dir.$name_file;
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                        $image_size = $_FILES["image"]["size"];
                        $randome_name = generateRandomString(20);
                        $new_name = $randome_name.".".$imageFileType;

                        // echo $target_dir."<br>";
                        // echo $name_file."<br>";
                        // echo $target_file."<br>";
                        // echo $imageFileType."<br>";
                        // echo $image_size."<br>";

                        if($name=='' || $category=='' || $price=='')
                        {
                            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Name, category and price are mandatory to fill up!
                            </div>
                            <?php
                        }
                        else
                        {
                            if($name_file!='')
                            {
                                if($image_size > 500000)
                                {
                                    ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File cannot more than 500 kb
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif')
                                    {
                                        ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            File must in jpg or png or gif
                                        </div>
                                        <?php
                                    }
                                    else
                                    {
                                        move_uploaded_file($_FILES["image"]["tmp_name"],$target_dir.$new_name);
                                    }
                                }
                            }
                            //query insert to product table
                            $queryInsert = mysqli_query($con, "INSERT INTO product (categories_id, name, price, photo, 
                            detail, in_stock) VALUES ('$category','$name','$price','$new_name','$detail','$stock')");

                            if($queryInsert)
                            {
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Product successfully inserted!
                                </div>

                                <meta http-equiv="refresh" content="2; url=product.php" />
                                <?php
                            }
                            else
                            {
                                echo mysqli_error($con);
                            }
                        }
                    }
                ?>
            </div>

            <div class="mt-3 mb-5">
                <h2>List Products</h2>

                <div class="table-responsive mt-5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Ready Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($totalProduct==0)
                                {
                                    ?>
                                    <tr>
                                        <td colspan=6 class="text-center">No product data insert!!!</td>
                                    </tr>
                                    <?php
                                }
                                else
                                {
                                    $number=1;
                                    while($data=mysqli_fetch_array($queryProduct))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $number; ?></td>
                                            <td><?php echo $data['name']; ?></td>
                                            <td><?php echo $data['name_categories']; ?></td>
                                            <td><?php echo $data['price']; ?></td>
                                            <td><?php echo $data['in_stock']; ?></td>
                                            <td>
                                                <a href="product-detail.php?p=<?php echo $data['id']; ?>"
                                                class="btn btn-info"><i class="fas fa-search"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                        $number++;
                                    }
                                }
                                ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
    
</body>
</html>