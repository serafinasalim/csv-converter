<?php

include 'config.php';

$id = $_GET['id'];

$sql = "DELETE FROM buku WHERE id=$id";

$response = [];
if ($conn->query($sql) === TRUE) {
    $response['status'] = 'success';
    $response['message'] = 'Record deleted successfully';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error deleting record: ' . $conn->error;
}

$conn->close();

echo json_encode($response);
header('location: index.html');
?>