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
            <form method="post" action="<?= url('admin/category/update/' . $category['id'])?>">
                <label for="name">edit category name with id : <?= $category['id'] ?></label>
                <input type="text" value="<?= $category['name'] ?>" name="name" id="name">
                 <button type="submit">edit</button>
            </form>
        </div>

    </section>
</body>

</html>