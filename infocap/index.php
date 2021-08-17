<?php
require('./application/config.php');

$read = new Small\Database\Read();
$url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);

$read->Select('menu');
if ($read->success)
   $menuArray = $read->getResultSet();
else {
   $menuArray = [
      ['text' => 'Home', 'link' => 'home'],
   ];
}
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>InfoCap</title>
   <link rel="stylesheet" href="http://localhost/infocap/cdn/styles/bootstrap.min.css">
   <link rel="stylesheet" href="http://localhost/infocap/cdn/styles/default.css">
</head>
<body>
   <header>
      <div class="jumbotron text-center bg-white py-4 m-0">
         <h1 class="display-4">InfoCap</h1>
         <p class="tagline lead">We capture and keep your information for no good reason.</p>
         <hr class="my-2">
         <p class="m-1">We also often sell this info and share none of the profits with you.</p>
      </div>

      <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #20567B;">
         <div class="container">
            <a class="navbar-brand" href="http://localhost/infocap">InfoCap</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu">
               <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
               <ul class="navbar-nav ml-auto">
                  <?php foreach ($menuArray as $link): ?>
                  <li class="nav-item <?= strstr(strtolower($link['text']), $url) ? 'active' : '' ?>">
                     <a class="nav-link" href="<?= $link['link']?>"><?= $link['text']?></span></a>
                  </li>
                  <?php endforeach; ?>
               </ul>
            </div>
         </div>
      </nav>
   </header><!-- /header -->

   <main>
      <div class="container mt-5">
         <?php
         $url = $url ? $url : 'home';
         if ($url && file_exists("pages/$url.php"))
            require("pages/$url.php");
         else
            require("pages/404.html");
         ?>
      </div>
   </main>

<script src="http://localhost/infocap/cdn/scripts/jquery.min.js"></script>
<script src="http://localhost/infocap/cdn/scripts/popper.min.js"></script>
<script src="http://localhost/infocap/cdn/scripts/bootstrap.min.js"></script>
<script src="http://localhost/infocap/cdn/scripts/jquery.form.min.js"></script>
<script src="http://localhost/infocap/cdn/scripts/default.js"></script>
</body>
</html>
