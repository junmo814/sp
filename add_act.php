<?php
$pum = $_POST['username'];
$pd = $_POST['date'];
file_put_contents('./user/'.$pum.'/'.$pd, $_POST['newtodo'].':no/'.PHP_EOL, FILE_APPEND);
header('Location: index.php?user='.$pum.'&date='.$pd);
?>
