<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db_config.php';
    $conn = getDBConnection();
    
    if (isset($_POST['key'])) {
        $key = $_POST['key'];
		
		$unfreezeQuery = "SELECT `expiry_date`, `freeze_date` FROM `keys` WHERE `key`='$key'";
		
		$result = $conn->query($unfreezeQuery);
		if ($row = $result->fetch_assoc()) {
			$expiryDate = new DateTime($row['expiry_date']);
			$freezeDate = new DateTime($row['freeze_date']);
			$today = new DateTime();
			$interval = $today->diff($freezeDate);
			$expiryDate->add($interval);
			
			$updateQuery = "UPDATE `keys` SET `frozen`=FALSE, `expiry_date`='".$expiryDate->format('Y-m-d')."', `freeze_date`=NULL WHERE `key`='$key'";
			$conn->query($updateQuery);
			echo "Key has been successfully unfrozen with new expiry date: " . $expiryDate->format('Y-m-d');
		} else {
			echo "Key not found or already unfrozen";
		}
    } else {
        echo "Key is missing in the POST request";
    }
	
    $conn->close();
} else {
    echo "Invalid request method";
}
?>
