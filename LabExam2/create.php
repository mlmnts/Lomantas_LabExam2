<?php
require 'db.php';
require 'form.php';

$b = ['customer_name' => '', 'email' => '', 'table_type' => 'Indoor', 'party_size' => 1,
      'reservation_date' => '', 'reservation_time' => '', 'status' => 'Pending'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $b = array_merge($b, $_POST);
    $errors = validate($b);

    if (!$errors) {
        $stmt = $pdo->prepare(
            'INSERT INTO reservations (customer_name, email, table_type, party_size, reservation_date, reservation_time, status)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$b['customer_name'], $b['email'], $b['table_type'],
                        $b['party_size'], $b['reservation_date'], $b['reservation_time'], $b['status']]);
        header('Location: index.php?msg=' . urlencode('Reservation created!'));
        exit;
    }
}

page_start('New Reservation');
echo '<h3>New Reservation</h3>';
render_form($b, $errors, 'Save');
page_end();
