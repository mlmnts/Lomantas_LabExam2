<?php
function validate(array $d): array {
    $errors = [];
    if (trim($d['customer_name'] ?? '') === '') $errors[] = 'Customer name is required.';
    if (!filter_var($d['email'] ?? '', FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if (!in_array($d['table_type'] ?? '', ['Indoor', 'Outdoor', 'Private Room'])) $errors[] = 'Invalid table type.';
    if (($d['party_size'] ?? 0) < 1) $errors[] = 'Party size must be at least 1.';
    if (empty($d['reservation_date'])) $errors[] = 'Reservation date is required.';
    if (empty($d['reservation_time'])) $errors[] = 'Reservation time is required.';
    if (!in_array($d['status'] ?? '', ['Pending', 'Confirmed', 'Cancelled'])) $errors[] = 'Invalid status.';
    return $errors;
}

function render_form(array $b, array $errors, string $button) { ?>
    <?php if ($errors): ?>
        <div class="alert alert-danger"><ul class="mb-0">
            <?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?>
        </ul></div>
    <?php endif; ?>

    <form method="POST" class="card card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Customer Name</label>
                <input type="text" name="customer_name" class="form-control" value="<?= e($b['customer_name']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= e($b['email']) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Table Type</label>
                <select name="table_type" class="form-select">
                    <?php foreach (['Indoor', 'Outdoor', 'Private Room'] as $t): ?>
                        <option <?= $b['table_type'] === $t ? 'selected' : '' ?>><?= $t ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Party Size</label>
                <input type="number" name="party_size" min="1" class="form-control" value="<?= e($b['party_size']) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Reservation Date</label>
                <input type="date" name="reservation_date" class="form-control" value="<?= e($b['reservation_date']) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Reservation Time</label>
                <input type="time" name="reservation_time" class="form-control" value="<?= e(substr($b['reservation_time'], 0, 5)) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <?php foreach (['Pending', 'Confirmed', 'Cancelled'] as $s): ?>
                        <option <?= $b['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="mt-3">
            <button class="btn btn-success"><?= e($button) ?></button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
<?php }

function page_start(string $title) { ?>
<!DOCTYPE html>
<html>
<head>
    <title><?= e($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container"><a class="navbar-brand" href="index.php">🍽️ Restaurant Reservations</a></div>
</nav>
<div class="container">
<?php }

function page_end() { ?>
</div></body></html>
<?php }
