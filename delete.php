<?php
header('Content-Type: application/json');

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
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch('getBooks.php')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('bookTableBody');
                data.forEach(book => {
                    const row = document.createElement('tr');
                    row.className = 'table-light';
                    row.innerHTML = `
                        <td>${book.id}</td>
                        <td>${book.judul}</td>
                        <td>${book.penulis}</td>
                        <td>${book.genre}</td>
                        <td>${book.tahun_terbit}</td>
                        <td>${book.penerbit}</td>
                        <td>
                            <a href='#' class='link-dark' onclick='deleteBook(${book.id}, this)'><i class='fa-solid fa-trash fs-5 '></i></a>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    });

    function confirmDelete() {
        return confirm("Yakin untuk menghapus?");
    }

    function deleteBook(id, link) {
        if (confirmDelete()) {
            fetch(`delete.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const row = link.closest('tr');
                        row.parentNode.removeChild(row);
                    } else {
                        alert('Error deleting record: ' + data.message);
                    }
                })
                .catch(error => console.error('Error deleting data:', error));
        }
    }
</script>
