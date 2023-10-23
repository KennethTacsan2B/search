<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="wew.css">
    <title>Search Database Data</title>
</head>
<body>

    <div class="container">
        <div class="row">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <form action="" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" name="search" required value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Search data">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Operation</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $con = mysqli_connect("localhost","root","","form");
                                    if(isset($_GET['delete'])){
                                        $id = $_GET['delete'];
                                    
                                        $con = mysqli_connect("localhost","root","","form");
                                    
                                        $query = "DELETE FROM user WHERE id = $id";
                                    
                                        if(mysqli_query($con, $query)){
                                            header("Location: index.php");
                                        }else{
                                            echo "Error deleting record";
                                        }
                                    }


                                    if(isset($_GET['search']))
                                    {
                                        $filtervalues = $_GET['search'];
                                        $query = "SELECT * FROM user WHERE CONCAT(first_name,last_name,email) LIKE '%$filtervalues%' ";
                                        $query_run = mysqli_query($con, $query);

                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $row)
                                            {
                                                ?>
                                         
                                                <tr>
                                                    <td></td>
                                                    <td><?= $row['first_name']; ?></td>
                                                    <td><?= $row['last_name']; ?></td>
                                                    <td><?= $row['email']; ?></td>
                                                    <td>
                                                    <a href="index.php?delete=<?= $row['id']; ?>">Delete</a>
                                                    </td>
                                                    <td>
                                                    <a href="try.php?update=<?= $row['id']; ?>">Update</a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                                <tr>
                                                    <td colspan="4">No Record Found</td>
                                                </tr>
                                            <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>