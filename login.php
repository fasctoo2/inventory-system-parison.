<?php
require 'function.php';

// cek login
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    //cocokin dengan database, cari ada atau engga tuh data
    $cekdatabase = mysqli_query($conn, "SELECT * FROM login where email = '$email' and password = '$password'");
    //hitung jumlah data
    $hitung = mysqli_num_rows($cekdatabase);

    if($hitung>0){
        $_SESSION['log'] = 'True';
        header('location:index.php');
    } else {
        header('location:login.php');
    };
};

if(!isset($_SESSION['log'])){

} else {
    header('location:index.php');
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <title>Login Inventory Parison</title>
</head>

<body>


    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2"
            style="background-image: url('img/parison_bg.jpeg');">
        </div>
        <div class="contents order-2 order-md-1">

            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7">

                        <div class="text-center">
                            <img src="https://id.joblum.com/uploads/43/42515.jpg" style="width: 150px;" alt="logo">
                        </div>
                        <h3>Login to <strong>Inventory System</strong></h3>
                        <p></p>
                        <form action="#" method="post">
                            <div class="form-group first">
                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                <input class="form-control py-4" name="email" id="inputEmailAddress" type="email"
                                    placeholder="Enter email address" required/>
                            </div>
                            <div class="form-group last mb-3">
                                <label class="small mb-1" for="inputPassword">Password</label>
                                <input class="form-control py-4" name="password" id="inputPassword" type="password"
                                    placeholder="Enter password" required/>
                            </div>

                            <div class="d-flex mb-5 align-items-center">
                                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                                    <input type="checkbox" checked="checked" />
                                    <div class="control__indicator"></div>
                                </label>
                                <span class="ml-auto"><a href="lupa_pass.php" class="forgot-pass">Forgot Password</a></span>
                            </div>

                            <button class="btn btn-block btn-primary" name="login">Login</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>