<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/php_basic/04-ex/template/admin/index.css">
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
                <h3>posts</h3>
                <a href="<?=url("admin/post/create")?>"> create</a>
            </div>
            <table>

                <th>#</th>
                <th>category name</th>
                <th>title</th>
                <th>summary</th>
                <th>content</th>
                <th>status</th>
                <th>image</th>
                <th>created at</th>
                <th>updated at</th>
                <th>published at</th>
                <th>function</th>

                <?php
                $count_id = 1;
                $res = $posts->fetchAll();
                foreach ($res as $r) {
                    $id = $r['id'];
                    $title = $r['title'];
                    $summary = $r['summary'];
                    $content = $r['content'];
                    $status = $r['status'];
                    $img_address = $r['img_address'];
                ?>
                    <tr>
                        <td><?= $count_id ?></td>
                        <td><?= $r['category_name'] ?></td>
                        <td><?= $title ?></td>
                        <td><?= $summary ?></td>
                        <td><?= $content ?></td>
                        <td>
                            <button class="<?= $status == 1 ? 'active' : 'disable' ?>" id="<?= $status == 1 ? `active-$id` : `disable-$id` ?>">
                                <?= $status == 1 ? 'active' : 'disable' ?>
                            </button>
                        </td>
                        <td class="img">
                            <img  src="<?=$img_address?>" alt="image of post">
                        </td>
                        <td><?=$r['created_at']?></td>
                        <td><?=$r['updated_at']?></td>
                        <td><?=$r['published_at']?></td>
                        <td>
                            <a href="<?= url("admin/post/edit/$id") ?>">edit</a>
                            <a href="<?= url("admin/post/delete/$id") ?>">delete</a>
                        </td>
                    </tr>

                <?php $count_id++;
                } ?>
            </table>
        </div>
    </section>
</body>

</html>