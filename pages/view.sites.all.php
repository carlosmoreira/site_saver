<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>
<table class="table">
    <tr>
        <th>Url</th>
        <th>Description</th>
    </tr>
    <?php foreach ($sites as $site) : ?>
        <tr>
            <td><a target="_blank" href="<?php echo $site->getUrl(); ?>"><?php echo $site->getUrl(); ?></a></td>
            <td><?php echo $site->getDescription(); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>