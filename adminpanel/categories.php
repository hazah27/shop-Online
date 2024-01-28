<?php
    require "session.php";
    require "../js/connect.php";

    $queryCategories = mysqli_query($con, "SELECT * FROM categories");
    $totalCategories = mysqli_num_rows($queryCategories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
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
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fas fa-home"></i> Home</a></li>
                    
                    <li class="breadcrumb-item active" aria-current="page">
                    Categories</li>
            </ol>
        </nav>

        <div class="my-5 col-12 col-md-6">
            <h3>Add Categories</h3>

            <form action="" method="post">
                <div>
                    <label for="categories">Categories</label>
                    <input type="text" id="categories" name="categories" placeholder="input categories name"
                    class="form-control">
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="submit_categories">Submit</button>
                </div>
            </form>

            <?php
                if(isset($_POST['submit_categories']))
                {
                    $categories=htmlspecialchars($_POST['categories']);

                    $queryExist = mysqli_query($con, "SELECT name FROM categories WHERE name='$categories'");
                    $totalNewDataCategories = mysqli_num_rows($queryExist);

                    if($totalNewDataCategories > 0)
                    {
                        ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Category is already existed!
                        </div>
                        <?php
                    }
                    else
                    {
                        $querySubmit = mysqli_query($con, "INSERT INTO categories (name) VALUES ('$categories')");

                        if($querySubmit)
                        {
                            ?>
                            <div class="alert alert-primary mt-3" role="alert">
                                Categories successfully insert!
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
            ?>
        </div>

        <div class="mt-3">
            <h2>List Categories</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                             if($totalCategories==0)
                            {
                                ?>
                                <tr>
                                    <td colspan=3 class="text-center">No category data insert!!!</td>
                                </tr>
                                <?php
                            }
                            else
                            {
                                $number=1;
                                while($data=mysqli_fetch_array($queryCategories))
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $number; ?></td>
                                        <td><?php echo $data['name']; ?></td>
                                        <td>
                                            <a href="categories-detail.php?p=<?php echo $data['id']; ?>"
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