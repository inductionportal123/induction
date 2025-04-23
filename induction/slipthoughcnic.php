<?php
include('connection/conn.php');

if (isset($_POST['said'])) {

    $userid = $_POST['said'];
    // $arr = explode(' ', trim($user));
    // $newuser = ucfirst("$arr[0]");

    $postid = $_POST['postid'];
    $rollnum = $_POST['rollno'];
    $centerid = $_POST['centerid'];

    // // Error handling flag
    // $error_occurred = false;

    // Fetch post details
    $postquery1 = "SELECT * FROM `posts` WHERE pid='$postid'";
    $postexe1 = mysqli_query($conn, $postquery1);
    if ($postexe1 && mysqli_num_rows($postexe1) == 1) {
        $postrows1 = mysqli_fetch_array($postexe1);
        $postname = strtoupper($postrows1['name']);
        $postgender = strtoupper($postrows1['gender']);
        $postbps = strtoupper($postrows1['bps']);
    } else {
        $error_occurred = true;
    }

    // Fetch center details
    $centerquery1 = "SELECT `center` FROM `centes` WHERE id='$centerid'";
    $centerexe1 = mysqli_query($conn, $centerquery1);
    if ($centerexe1 && mysqli_num_rows($centerexe1) == 1) {
        $centerrows1 = mysqli_fetch_array($centerexe1);
        $centername = strtoupper($centerrows1['center']);
    } else {
        $error_occurred = true;
    }

    // Fetch test schedule
    $datequery = "SELECT `date_time` FROM `test_schedule` WHERE post_id='$postid'";
    $dateexe = mysqli_query($conn, $datequery);
    if ($dateexe && mysqli_num_rows($dateexe) == 1) {
        $daterows = mysqli_fetch_array($dateexe);
        $date = $daterows['date_time'];
        $dt = new DateTime($date);
        $datesep = $dt->format('d-M-Y');
        $timesep = $dt->format('H:i:sA');
        $day = $dt->format('D');
    } else {
        $error_occurred = true;
    }

    // Fetch user image
    $pic = "SELECT image FROM emp_document WHERE said='$userid'";
    $exepic = mysqli_query($conn, $pic);
    if ($exepic && mysqli_num_rows($exepic) > 0) {
        $picdata = mysqli_fetch_array($exepic);
    } else {
        $error_occurred = false;
        $picdata=NULL;
    }

    // Fetch personal info
    $query = "SELECT * FROM per_info WHERE said='$userid'";
    $exe = mysqli_query($conn, $query);
    if ($exe && mysqli_num_rows($exe) == 1) {
        $rows = mysqli_fetch_array($exe);
        $name = $rows['basic_full_name'];
        $fathername = $rows['basic_father_name'];
        $cnic = $rows['contact_cnic'];
    } else {
        $error_occurred = true;
    }

    if (!$error_occurred) {
        ob_start();
        try {
            require_once('fpdi2/src/autoload.php');
            require("fpdf/fpdf.php");
            $pdf = new \setasign\Fpdi\Fpdi();
            $pdf->AddPage();
            $pdf->setSourceFile('slip.pdf');
            $tplIdx = $pdf->importPage(1);
            $pdf->useTemplate($tplIdx, 1, 13, 200);

            if (!empty($picdata['image'])) {
    $target1 = $picdata['image'];
    $converted_path = "documents/converted_temp.jpg";
    $image = @imagecreatefromstring(file_get_contents($target1));

    if ($image) {
        imagejpeg($image, $converted_path, 100);
        imagedestroy($image);
        $pdf->Image($converted_path, 140, 78, 40, 37);
    } else {
        // If image creation fails, show placeholder text
        $pdf->SetFont('Helvetica');
        $pdf->SetFontSize('13');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(148, 85);
        $pdf->Write(0, "Paste Your");
        $pdf->SetXY(148, 95);
        $pdf->Write(0, "Picture Here");
    }
} else {
    // If no image is found in the database, show placeholder text
    $pdf->SetFont('Helvetica');
    $pdf->SetFontSize('13');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetXY(148, 85);
    $pdf->Write(0, "Paste Your");
    $pdf->SetXY(148, 95);
    $pdf->Write(0, "Picture Here");
}



            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->SetFontSize('12');
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetXY(92, 151);
            $pdf->Write(0, $rollnum);
            $pdf->SetFont('Helvetica');
            $pdf->SetFontSize('13');
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetXY(63, 98);
            $pdf->Write(0, $name);
            $pdf->SetXY(63, 112);
            $pdf->Write(0, $fathername);
            $pdf->SetXY(62, 124);
            $pdf->Write(0, $cnic);
            $postText = $postname . " (" . $postgender . ") BPS-" . "(" . $postbps . ")";
            $maxLength = 50; // Maximum length before wrapping to a new line (you can adjust this value)
            
            $pdf->SetXY(62, 133);
            $pdf->SetFontSize('12');
            
            if (strlen($postText) > $maxLength) {
                $lines = wordwrap($postText, $maxLength, "\n", true);
                $linesArray = explode("\n", $lines);
                foreach ($linesArray as $index => $line) {
                    $pdf->SetXY(62, 134 + ($index * 5)); // Adjust Y position for each new line
                    $pdf->Write(0, $line);
                }
            } else {
                $pdf->Write(0, $postText);
            }
            $pdf->SetXY(35, 174);
            $pdf->Write(0, $datesep);
            $pdf->SetXY(60, 174);
            $pdf->Write(0, "  (" . $day . ")");
            $pdf->SetXY(125, 174);
            $pdf->Write(0, $timesep);
            $pdf->SetXY(20, 197);
$pdf->SetFontSize(10);
$pdf->MultiCell(0, 5, $centername);

            $pdf->Output();
            ob_end_flush();

            // Log the download event after successful PDF generation
            $sql = "INSERT INTO download_logs (user_id, post_id, download_time) VALUES (?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $userid, $postid);
            $stmt->execute();
        } catch (Exception $e) {
            ob_end_clean();
            echo "An error occurred while generating the PDF: " . $e->getMessage();
        }
    } else {
        echo "An error occurred while fetching data.";
    }
} else {
    header("cnic_searchslip.php");
}

$conn->close();

?>
