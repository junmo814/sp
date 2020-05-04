<?php
$pum= $_POST['username'];
mkdir('./user/'.$pum);
header('Location: index.php');
?>
