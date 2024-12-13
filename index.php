<?php

require './utils/db.php';

session_start();

if(isset($_SESSION['id']) && isset($_SESSION['role'])){
    if($_SESSION['role'] == 'membre'){
        header('Location: ./client/activites.php');
    }else{
        header('Location: ./admin/membres.php');
    }
}else{
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $role = htmlspecialchars($_POST['role']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        if($role == 'admin'){
            $stmt = $conn->prepare("SELECT id, email, password FROM admin WHERE email = ?");
        }else{
            $stmt = $conn->prepare("SELECT id_membre, email, password FROM membre WHERE email = ?");
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id, $em, $pass);

        if($stmt->fetch()){
            if($pass == md5($password)){
                //correct password
                $_SESSION['role'] = $role;
                $_SESSION['id'] = $id;
                if($role == 'admin')
                    header('Location: ./admin/membres.php');
                else
                    header('Location: ./client/activites.php');
            }else{
                echo "<script>alert('wrong password')</script>";
            }
        }else{
            echo "<script>alert('email doesn\'t exist')</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Skydash Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="./vendors/feather/feather.css">
  <link rel="stylesheet" href="./vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="./vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="./css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="./images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="./images/logo.svg" alt="logo">
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" method="POST">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" name="password">
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <label class="form-check-label text-muted">
                            <input type="radio" class="form-check-input" name="role" value="admin">
                            Admin
                        </label>
                    </div>
                    <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="radio" class="form-check-input" name="role" value="membre">
                      Membre
                    </label>
                  </div>
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="./vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="./js/off-canvas.js"></script>
  <script src="./js/hoverable-collapse.js"></script>
  <script src="./js/template.js"></script>
  <script src="./js/settings.js"></script>
  <script src="./js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
