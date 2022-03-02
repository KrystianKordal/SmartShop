<?php include(template('partials/header', true)) ?>
<h1>Orders panel</h1>
<table>
    <thead>
        <tr>
            <td>ID</td>
            <td>Total price</td>
            <td>Date placed</td>
        </tr>
    </thead>
    <?php foreach($orders as $order): ?>
        <tr>
            <td><?= $order['id'] ?></td>
            <td><?= $order['total_price'] ?></td>
            <td><?= $order['date_placed']->format("Y-m-d H:i:s") ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include(template('partials/footer', true)); ?>