<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db_config.php';
    $conn = getDBConnection();
	
    if (isset($_POST['key'])) {
        $key = $_POST['key'];
		
        $checkQuery = "SELECT `hwid_bound` FROM `keys` WHERE `key`='$key' LIMIT 1";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows === 1) {
            $row = $checkResult->fetch_assoc();
            if ($row['hwid_bound']) {
                $unbindQuery = "UPDATE `keys` SET `hwid_bound`=FALSE, `bound_hwid`=NULL WHERE `key`='$key'";

                if ($conn->query($unbindQuery) === TRUE) {
                    echo "HWID has been successfully unbinded from the key";
                } else {
                    echo "Error when unbinding HWID from key: " . $conn->error;
                }
            } else {
                echo "HWID is not bound with this key";
            }
        } else {
            echo "Key not found";
        }
    } else {
        echo "Key is missing in the POST request";
    }
	
    $conn->close();
} else {
    echo "Invalid request method";
}
?>