<?php
    require "session.php";
    require "../js/connect.php";

    $id = $_GET['p'];

    $query = mysqli_query($con, "SELECT * FROM categories WHERE id='$id'");
    $data = mysqli_fetch_array($query);
    // var_dump($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories Details</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

</head>
<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h2>Categories Details</h2>
    
        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="categories">Categories</label>
                    <input type="text" name="categories" id="categories" class="form-control" value="<?php echo
                    $data['name']; ?>">
                </div>

                <div class="mt-5 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="editBtn">Edit</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                </div>
            </form>

            <?php
                if(isset($_POST['editBtn']))
                {
                    $categories = htmlspecialchars($_POST['categories']);

                    if($data['name']==$categories)
                    {
                        ?>
                        <meta http-equiv="refresh" content="0; url=categories.php"/>
                        <?php
                    }
                    else
                    {
                        $query = mysqli_query($con, "SELECT * FROM categories WHERE name='$categories'");
                        $totalData = mysqli_num_rows($query);

                        if($totalData > 0)
                        {
                            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Category is alreay existed!
                            </div>
                            <?php
                        }
                        else
                        {
                            $querySubmit = mysqli_query($con, "UPDATE categories SET name='$categories' WHERE id='$id'");

                            if($querySubmit)
                            {
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Categories successfully updated!
                                </div>
                                <meta http-equiv="refresh" content="2; url=categories.php"/>
                                <?php
                            }
                            else
                            {
                                echo mysqli_error($con);
                            }
                        }

                    }
                }

                if(isset($_POST['deleteBtn']))
                {
                    $queryCheck = mysqli_query($con, "SELECT * FROM product WHERE categories_id='$id'");
                    $dataCount = mysqli_num_rows($queryCheck);
                    // echo $dataCount;
                    // die();

                    if($dataCount>0)
                    {
                        ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Category cannot be delete due use in product
                        </div>
                        <?php
                        die();
                    }

                    $queryDelete = mysqli_query($con, "DELETE FROM categories WHERE id='$id'");

                    if($queryDelete)
                    {
                        ?>
                            <div class="alert alert-primary mt-3" role="alert">
                                Category successfully deleted!
                            </div>

                            <meta http-equiv="refresh" content="2; url=categories.php" />
                        <?php
                    }
                    else
                    {
                        echo mysqli_error($con);
                    }
                }
            ?>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>