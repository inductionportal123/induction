<?php

include('connection/conn.php');

$value = $_POST['post_id'];

if($value == 1)
{
$sql = "SELECT `pid`,`name` FROM `posts` WHERE `cat` = 1 AND `gender` = 'male'";
}
else if($value == 2)
{
$sql = "SELECT `pid`,`name` FROM `posts` WHERE `cat` = 1 AND `gender` = 'female'";
}
else if($value == 3)
{
$sql = "SELECT `pid`,`name` FROM `posts` WHERE `cat` = 2 AND `gender` = 'male'";
}
else
{
$sql = "SELECT `pid`,`name` FROM `posts` WHERE `cat` = 2 AND `gender` = 'female'";
}


$query =mysqli_query($conn,$sql) or die("query Unsuccessful");

$str = "";
while($row = mysqli_fetch_array($query))
{

		$str.= "<option value='{$row['name']}'> {$row['name']} </option>";

}

echo $str;

?>