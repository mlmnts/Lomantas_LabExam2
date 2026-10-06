<?php
require 'db.php';
require 'form.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM reservations WHERE id = ?');
$stmt->execute([$id]);
$b = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$b) { die('Reservation not found.'); }
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $b = array_merge($b, $_POST);
    $errors = validate($b);

    if (!$errors) {
        $stmt = $pdo->prepare(
            'UPDATE reservations SET customer_name=?, email=?, table_type=?, party_size=?,
             reservation_date=?, reservation_time=?, status=? WHERE id=?'
        );
        $stmt->execute([$b['customer_name'], $b['email'], $b['table_type'],
                        $b['party_size'], $b['reservation_date'], $b['reservation_time'], $b['status'], $id]);
        header('Location: index.php?msg=' . urlencode('Reservation updated!'));
        exit;
    }
}

page_start('Edit Reservation');
echo '<h3>Edit Reservation #' . $id . '</h3>';
render_form($b, $errors, 'Update');
page_end();
