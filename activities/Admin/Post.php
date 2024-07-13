<?php


namespace Admin;

use database\DataBase;

class Post extends Admin
{
    public function index()
    {
        $db = new DataBase;
        $posts = $db->select('SELECT posts.*, categories.name AS category_name from posts LEFT JOIN categories ON categories.id = posts.category_id ORDER BY id DESC');
        require_once(BASE_PATH . '/template/admin/posts/index.php');
    }

    public function create()
    {
        $db = new DataBase;
        $categories = $db->select('SELECT * FROM categories');
        require_once(BASE_PATH . "/template/admin/posts/create.php");
    }

    public function store($request)
    {
        $db = new DataBase;
        $imgPath =  "assets/" . $request['img_address']['name'];
        $this->saveImage($request['img_address'], $imgPath);
        $request['img_address'] = asset("assets/" . $request['img_address']['full_path']);
        $db->insert("posts", array_keys($request), $request);
        $this->redirect("admin/post");
    }

    public function edit($id)
    {
        $db = new DataBase;
        $post = $db->select('SELECT * FROM posts WHERE id = ?', [$id])->fetch();
        if (empty($post)) {
            $this->redirect('admin/post');
        }
        $category_of_post = $db->select('SELECT * FROM categories WHERE id = ?', [$post['category_id']])->fetch(); // for category name of post
        $categories = $db->select('SELECT * FROM categories');  //for cataegory seslect option
        require_once(BASE_PATH . '/template/admin/posts/edit.php');
    }

    public function update($request, $id)
    {
        $db = new DataBase;

        // *****     this code saves image / without saveImage function     ****** 
        // $imgPath = "./public/assets/".$request['img_address']['name'];
        // move_uploaded_file($request['img_address']['tmp_name'] , $imgPath);

        $imgPath =  "assets/" . $request['img_address']['name'];
        $this->saveImage($request['img_address'], $imgPath);

        $request['img_address'] = asset("assets/" . $request['img_address']['full_path']);
        $db->update('posts', $id, array_keys($request), $request);
        $this->redirect('admin/post');
    }

    public function delete($id)
    {
        $db = new DataBase;

        $db->delete("posts", $id);
        $this->redirect("admin/post");
    }
}
