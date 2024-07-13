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
            <form method="post" action="<?=url("admin/post/update/$id") ?>" enctype="multipart/form-data">
            <label for="category_name"> category name of post </label>
            <select name="category_id" id="category_name">
                    <?php 
                    $category_name = $category_of_post['name'];
                    $res = $categories->fetchAll();
                    foreach($res as $r){?>
                    <option <?= $category_name ==$r['name']? "selected" : "" ?> value="<?=$r['id']?>"><?=$r['name']?></option>
                    <?php } ?>
                </select>
                <label for="ttile"> post title</label>
                <textarea name="title" id="title"><?= $post['title']?></textarea>
                <label for="summary"> port summary</label>
                <textarea name="summary" id="summary"><?=$post['summary'] ?></textarea>
                <label for="content">post content</label>
                <textarea name="content" id="content"><?=$post['content'] ?></textarea>
                <label for="status"> post visibility status </label>
                <select name="status" id="status">
                    <option value="1" <?= $post['status'] == 1 ? "selected" : "" ?>>active</option>
                    <option value="0" <?= $post['status'] == 0 ? "selected" : "" ?>>disable</option>
                </select>
                <label for="img"> select an image for post</label>
                <input type="file" name="img_address" accept="image/png, image/jpeg" id="img">
                <button type="submit">edit</button>
            </form>
        </div>
    </section>
</body>
</html>