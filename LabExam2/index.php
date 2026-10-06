<?php
require 'db.php';
require 'form.php';

$reservations = $pdo->query('SELECT * FROM reservations ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);

page_start('All Reservations');
?>
<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?= e($_GET['msg']) ?></div>
<?php endif; ?>

<div class="d-flex justify-content-between mb-3">
    <h3>All Reservations</h3>
    <a href="create.php" class="btn btn-primary">+ New Reservation</a>
</div>

<table class="table table-bordered bg-white">
    <thead class="table-dark">
        <tr><th>#</th><th>Customer</th><th>Email</th><th>Table</th><th>Party Size</th>
            <th>Date</th><th>Time</th><th>Status</th><th width="150">Actions</th></tr>
    </thead>
    <tbody>
    <?php if (!$reservations): ?>
        <tr><td colspan="9" class="text-center">No reservations yet.</td></tr>
    <?php endif; ?>
    <?php foreach ($reservations as $r): ?>
        <tr>
            <td><?= $r['id'] ?></td>
            <td><?= e($r['customer_name']) ?></td>
            <td><?= e($r['email']) ?></td>
            <td><?= e($r['table_type']) ?></td>
            <td><?= $r['party_size'] ?></td>
            <td><?= e($r['reservation_date']) ?></td>
            <td><?= e(substr($r['reservation_time'], 0, 5)) ?></td>
            <td><?= e($r['status']) ?></td>
            <td>
                <a href="edit.php?id=<?= $r['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete.php?id=<?= $r['id'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Delete this reservation?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php page_end(); ?>
