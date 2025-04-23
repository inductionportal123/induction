<?php
if(isset($_POST["employees_id"])){
	$x = $_POST["employees_id"];
	$q = $_GET['pagno'];
	$output = '';
	$output .= '
		<form action="updatefeedback.php?pagen='.$q.'&stu_id='.$x.'" method="POST">
	';
		
		$output .= '

			<textarea name="message" class="form-control" rows="6" > </textarea>
			<br>
			<input type="submit" value="Submit" class="btn btn-primary">
		';
	$output .= "</form>";
	echo $output;
}
?>