<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 400px;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
    <title>Car Rental</title>
</head>
<body>
<h1>Car Rental Service</h1>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Model</th>
            <th>Fuel economy (L/100km)</th>
            <th>Price per day</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cars as $car) : ?>
            <tr>
                <td><?= $car->getId() ?></td>
                <td><?= $car->getName() ?></td>
                <td><?= $car->getModel() ?></td>
                <td><?= $car->getFuelEconomy() ?></td>
                <td><?= $car->getPrice() ?></td>
                <td><?= $car->getStatusText() ?></td>
                <td>
                    <form action="/" method="post">
                        <input type="hidden" name="carId" value="<?= $car->getId() ?>">
                        <?php if ($car->getStatus() === 0) : ?>
                            <input type="hidden" name="action" value="rent">
                            <input type="submit" value="Rent">
                        <?php elseif ($car->getStatus() === 1) : ?>
                            <input type="hidden" name="action" value="return">
                            <input type="submit" value="Return">
                        <?php else : ?>
                            <input type="hidden" name="action" value="none">
                            <input type="submit" value="Rent" disabled>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
