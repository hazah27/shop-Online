<?php
    require "session.php";
    require "../js/connect.php";

    $id = $_GET['p'];

    $query = mysqli_query($con, "SELECT a.*, b.name AS name_categories FROM product a JOIN categories b ON a.categories_id=b.id WHERE a.id='$id'");
    // $query = mysqli_query($con, "SELECT a.*, b.name AS name_categories FROM product a JOIN categories b ON a.categories_id=b.id");
    $data = mysqli_fetch_array($query);
    // var_dump($data);

    $queryCategories = mysqli_query($con, "SELECT * FROM categories WHERE id!='$data[categories_id]'");

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
    <title>Product Details</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<style>
    form div{
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h2>Categories Details</h2>

        <div class="col-12 col-md-6 mb-5">
            <form action="" method="post" entype="multipart/form-data">
                <div>
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" autocomplete="off" required value="<?php echo
                    $data['name']; ?>">
                </div>

                <div>
                    <label for="categories">Categories</label>
                    <select name="categories" id="categories" class="form-control" required>
                        <option value="<?php echo $data['categories_id']; ?>"><?php echo $data['name_categories']; ?></option>
                        <?php
                            while($dataCategories=mysqli_fetch_array($queryCategories))
                            {
                                ?>
                                <option value="<?php echo $dataCategories['id']; ?>"><?php echo $dataCategories['name']; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="price">Price</label>
                    <input type="number" class="form-control" value="<?php echo $data['price']; ?>" name="price" autocomplete="off" required>
                </div>

                <div>
                    <label for="currentImage">Current Image</label>
                    <img src="../image/<?php echo $data['photo'] ?>" alt="" width="300px">
                </div>

                <div>
                    <label for="image">Photo</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control">
                        <?php echo $data['detail']; ?>
                    </textarea>
                </div>

                <div>
                    <label for="ready_stock">Ready Stock</label>
                    <select name="ready_stock" id="ready_stock" class="form-control">
                        <option value="<?php echo $data['in_stock'] ?>"><?php echo $data['in_stock'] ?></option>
                        <?php
                            if($data['in_stock']=='instock')
                            {
                                ?>
                                <option value="sold">Sold</option>
                                <?php
                            } 
                            else
                            {
                                ?>
                                <option value="instock">In Stock</option>
                                <?php
                            }
                        ?>
                        
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
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
                    var_dump ($target_dir);
                    $name_file = basename($_FILES["image"]["name"]);
                    // $name_file = basename($_POST["image"]);
                    var_dump ($name_file);
                    $target_file = $target_dir.$name_file;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $image_size = $_FILES["image"]["size"];
                    $randome_name = generateRandomString(20);
                    $new_name = $randome_name.".".$imageFileType;   
                    
                    echo 'target: '.$target_dir."<br>";
                    echo 'file: '.$name_file."<br>";
                    echo $target_file."<br>";
                    echo $imageFileType."<br>";
                    echo $image_size."<br>";

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
                        $queryUpdate = mysqli_query($con, "UPDATE product SET categories_id='$category',
                        name='$name', price='$price', detail='$detail', in_stock='$stock' WHERE id=$id");

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
                                    // move_uploaded_file($_POST["image"],$target_dir.$new_name);

                                    $queryUpdateFile = mysqli_query($con, "UPDATE product SET photo='$new_name' WHERE id='$id'");
                                    // $queryUpdate = mysqli_query($con, "UPDATE product SET categories_id='$category',
                                    // name='$name', price='$price', detail='$detail', in_stock='$stock', photo='$new_name' WHERE id='$id'");

                                    if($queryUpdateFile)
                                    {
                                        ?>
                                        <div class="alert alert-primary mt-3" role="alert">
                                            Product successfully updated!
                                        </div>

                                        <!-- <meta http-equiv="refresh" content="2; url=product.php" /> -->
                                        <?php
                                    }
                                    else
                                    {
                                        echo mysqli_error($con);
                                    }
                                }
                            }
                        }
                    }
                }
                
                if(isset($_POST['delete']))
                {
                    $queryDelete = mysqli_query($con, "DELETE FROM product WHERE id='$id'");

                    if($queryDelete)
                    {
                        ?>
                        <div class="alert alert-primary mt-3" role="alert">
                            Product successfully deleted!
                        </div>

                        <meta http-equiv="refresh" content="2; url=product.php" />
                        <?php
                    }
                }
            ?>

            

        </div>

       



        
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>