<?php
$output = '';
$stu_id = $_POST['stu_id'];
$output .= '
    <textarea name="message" class="form-control mesgs" rows="3"></textarea>
    <br>
    Do you want to revert the application? 
    <label>
        Yes <input type="radio" name="option" value="1">
    </label>
    <label>
        No <input type="radio" name="option" value="0">
    </label>
    <br>
    <input type="submit" value="Submit" id="' . $stu_id . '" class="btn btn-primary reject">
';

echo $output;
?>