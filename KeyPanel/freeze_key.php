<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db_config.php';
	$conn = getDBConnection();
	
    if (isset($_POST['key'])) {
        $key = $_POST['key'];
		$today = date('Y-m-d');
		
		$freezeQuery = "UPDATE `keys` SET `frozen`=TRUE, `freeze_date`='$today' WHERE `key`='$key'";

        if ($conn->query($freezeQuery) === TRUE) {
            echo "Key has been successfully frozen.";
        } else {
            echo "Error when freezing the key: " . $conn->error;
        }
    } else {
        echo "Key is missing in the POST request";
    }
	
    $conn->close();
} else {
    echo "Invalid request method";
}
?>
