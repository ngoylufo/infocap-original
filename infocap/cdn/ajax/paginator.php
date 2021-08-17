<?php
require('../../application/config.php');
$page = filter_input(INPUT_POST, 'page', FILTER_VALIDATE_INT);

$read = New Small\Database\Read;
$read->Select('people', '*');
$rows = $read->getRowCount();

if ($rows > 10):
   $pages = ceil($rows / 10);
   $maxlinks = 4;
   if ((int) $page > 1):
?>
   <li class="page-item">
      <a id="prev" class="page-link" href="javascript:void(0)" aria-label="Back" data-toggle="tooltip" title="Get the previous set of results asynchronously!">
         <span aria-hidden="true">&laquo;</span>
         <span class="sr-only">Previous</span>
      </a>
   </li>
<?php
   endif;

   for($p = $page - $maxlinks; $p <= $page - 1; $p++){
      if ($p >= 1)
         echo "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:void(0)\">{$p}</a></li>";
   }
   echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"javascript:void(0)\">{$page}</a></li>";
   for($n = $page + 1; $n <= $page + $maxlinks; $n++){
      if($n <= $pages)
         echo "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:void(0)\">{$n}</a></li>";
   }

   if ($page < $pages):
?>
   <li class="page-item">
      <a id="next" class="page-link" href="javascript:void(0)" aria-label="Next" data-toggle="tooltip" title="Get the next set of results asynchronously!">
         <span aria-hidden="true">&raquo;</span>
         <span class="sr-only">Next</span>
      </a>
   </li>
<?php
   endif;
endif;
