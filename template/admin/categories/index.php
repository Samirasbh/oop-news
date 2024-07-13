<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= url('template/admin/index.css') ?>">
    <title>Document</title>
</head>

<body>
    <header>
        <nav>
            <div class="logo"></div>
            <button class="logout">logout</button>
        </nav>
    </header>
    <section>
        <div class="dashboard">
            <div class="box">
                <a href="<?= url('admin/category') ?>">categories</a>
                <a href="<?= url('admin/post') ?>">posts</a>
            </div>
        </div>
        <div class="content">
            <div class="heading">
                <h3>categories</h3>
                <a href="<?= url('admin/category/create') ?>">create</a>

            </div>
            <table>
                <th> #</th>
                <th> category name</th>
                <th>created at</th>
                <th>updated at</th>
                <th> function</th>

                <?php
                $count_id = 1;
                $res = $categories->fetchAll();
                foreach ($res as $r) {
                    $category_name = $r['name'];
                    $id = $r['id'];
                ?>
                    <tr>
                        <td><?= $count_id ?></td>
                        <td><?= $category_name ?></td>
                        <td><?=$r['created_at']?></td>
                        <td><?=$r['updated_at']?></td>
                        <td>
                            <a href="<?= url("admin/category/edit/$id") ?>">edit</a>
                            <a href="<?= url("admin/category/delete/$id") ?>">delete</a>
                        </td>

                    </tr>
                <?php $count_id++;
                } ?>
            </table>

        </div>
    </section>
</body>

</html>