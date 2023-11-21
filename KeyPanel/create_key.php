<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db_config.php';
	$conn = getDBConnection();
	
    if (isset($_POST['expiryDays'])) {
        $expiryDays = intval($_POST['expiryDays']);
        $key = generateKey();
        $expiryDate = date('Y-m-d', strtotime("+$expiryDays days"));
		
        $sql = "INSERT INTO `keys` (`key`, `expiry_date`) VALUES ('$key', '$expiryDate')";

        if ($conn->query($sql) === TRUE) {
            echo "Key was successfully created with an expiration date of $expiryDays days";
        } else {
            echo "Error creating key: " . $conn->error;
        }
    } else {
        echo "There is no expiration date in the POST request";
    }
	
    $conn->close();
} else {
    echo "Invalid request method";
}

function generateKey() {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $segments = [];

    for ($i = 0; $i < 3; $i++) {
        $segment = '';
        for ($j = 0; $j < 4; $j++) {
            $segment .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        $segments[] = $segment;
    }

    return implode('-', $segments);
}
?>

