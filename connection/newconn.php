<?php
function getDatabaseConnection($ip) {
    $databases = [
        [
            'host' => '210.56.13.236',
            'user' => 'fgeigov_induction',
            'pass' => '}!NmKab+CTjc-aNoHU',
            'name' => 'fgeigov_induction'
        ],
        [
            'host' => '210.56.13.236',
            'user' => 'fgeigov_fgeigov_2nd',
            'pass' => '^&*()()(%$asdf',
            'name' => 'fgeigov_2nd'
        ],
        [
            'host' => '210.56.14.235',
            'user' => 'fgeigov_four',
            'pass' => 'four@#$*&^%ASDF',
            'name' => 'fgeigov_fourth'
        ],
        [
            'host' => '210.56.13.236',
            'user' => 'fgeigov_3rd',
            'pass' => '$%^&*334ASDF',
            'name' => 'fgeigov_3rd'
        ],
        [
            'host' => '210.56.14.235',
            'user' => 'fgeigov_5',
            'pass' => '@#$@#$dfwe534@$',
            'name' => 'fgeigov_5th'
        ]
        
    ];

    // Try connecting to the primary database
    $dbIndex = crc32($ip) % count($databases);
    echo $dbIndex;
    $db = $databases[$dbIndex];
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = new mysqli($db['host'], $db['user'], $db['pass'], $db['name']);
        return $conn;
    } catch (Exception $e) {
        // If primary fails, try the next database
        $dbIndex = ($dbIndex + 1) % count($databases);
        $db = $databases[$dbIndex];
        try {
            $conn = new mysqli($db['host'], $db['user'], $db['pass'], $db['name']);
            return $conn;
            
        } catch (Exception $e) {
            
            die("All databases are unavailable: " . $e->getMessage());
        }
    }
}

// Get user's IP address
$userIP = $_SERVER['REMOTE_ADDR'];
// Get the database connection
$conn = getDatabaseConnection($userIP);

?>