<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db_config.php';
	$conn = getDBConnection();
	
    if (isset($_POST['key'])) {
        $key = $_POST['key'];
		
        $deleteQuery = "DELETE FROM `keys` WHERE `key`='$key'";

        if ($conn->query($deleteQuery) === TRUE) {
            echo "Key was successfully deleted.";
        } else {
            echo "Error when deleting a key: " . $conn->error;
        }
    } else {
        echo "Key is missing in the POST request";
    }
	
    $conn->close();
} else {
    echo "Invalid request method";
}
?>
