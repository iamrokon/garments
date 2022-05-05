<?php
   ob_start();
   session_start();
   error_reporting(0);
   require_once dirname(__FILE__).('/../DB/db_con.php');

   header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
   header("Cache-Control: post-check=0, pre-check=0", false);
   header("Pragma: no-cache");

   $db = new DB_CON();

   $id = $_SESSION['id'];

   if ($id == NULL) {
        header('Location: ../index.php');
      }

   //this will help to active menu of sidebar
   $hit_page = end(explode("pages", $_SERVER['REQUEST_URI']));
   $_SESSION['active_page'] = "./pages".$hit_page;
   //echo $_SESSION['active_page'];
?>

<?php
require_once dirname(__FILE__).'/rootURL.php';
echo '<base href="'.$baseUrl.'"/>';
?>


   <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $baseName; ?></title>
        <meta name="description" content="Elisyam is a Web App and Admin Dashboard Template built with Bootstrap 4">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Google Fonts -->

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-16x16.png">
        <!-- Stylesheet -->
        <link rel="stylesheet" href="assets/vendors/css/base/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/datatables/datatables.min.css">
        <link rel="stylesheet" href="assets/vendors/css/base/elisyam-1.5.min.css">
        <link rel="stylesheet" href="assets/css/bootstrap-select/bootstrap-select.min.css">

        <link rel="stylesheet" href="assets/css/owl-carousel/owl.carousel.min.css">
        <link rel="stylesheet" href="assets/css/owl-carousel/owl.theme.min.css">
        <link rel="stylesheet" href="assets/css/w3.css">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/AdminLTE.min.css">
        <link rel="stylesheet" href="assets/css/jquery-jvectormap-1.2.2.css">
        <link rel="stylesheet" href="assets/select2/select2.min.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <style>

        /* The Modal (background) */
        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        padding-left: 200px;
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
       .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        }

        /* The Close Button */
        .close {
         color: #aaaaaa;
         float: right;
         font-size: 28px;
         font-weight: bold;
         }

         .close:hover,
         .close:focus {
          color: #000;
          text-decoration: none;
          cursor: pointer;
          }
         </style>


    </head>
