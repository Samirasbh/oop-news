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

        /* ---------  ---------- */
        // $db = new DataBase;
        // $imgPath =  "assets/" . $request['img_address']['name'];
        // $this->saveImage($request['img_address'], $imgPath);
        // $request['img_address'] = asset("assets/" . $request['img_address']['full_path']);
        // $db->insert("posts", array_keys($request), $request);
        // $this->redirect("admin/post");


        date_default_timezone_set('Iran');
        $realTimestampt = substr($request['published_at'], 0, 10);
        $request['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampt);
        $db = new DataBase();
        if ($request['category_id'] != null) {
            $this->saveImage($request['img_address'], $request['img_address']['name']);
            $request['img_address'] = asset("assets/" . $request['img_address']['full_path']);
            if ($request['img_address']) {
                $db->insert('posts', array_keys($request), $request);
                $this->redirect('admin/post');
            } else {
                $this->redirect('admin/post');
            }
        } else {
            $this->redirect('admin/post');
        }
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
        // $db = new DataBase;
        // $imgPath =  "assets/" . $request['img_address']['name'];
        // $this->saveImage($request['img_address'], $imgPath);

        // $request['img_address'] = asset("assets/" . $request['img_address']['full_path']);
        // $db->update('posts', $id, array_keys($request), $request);
        // $this->redirect('admin/post');

        date_default_timezone_set('Iran');
        $realTimestampt = substr($request['published_at'], 0, 10);
        $request['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampt);
        $db = new DataBase();
        if ($request['category_id'] != null) {
            if ($request['img_address']['tmp_name'] != null) {
                $post = $db->select('SELECT * FROM posts WHERE id = ?;', [$id])->fetch();

                $this->removeImage($post['img_address']);
                $imgPath = $request['img_address']['name'];
                $this->saveImage($request['img_address'], $imgPath);
                $request['img_address'] = asset("assets/" . $request['img_address']['full_path']);
            } else {
                unset($request['img_address']);
            }
            $db->update('posts', $id, array_keys($request), $request);
            $this->redirect('admin/post');
        } else {
            $this->redirect('admin/post');
        }
        // dd($request);
    }

    public function delete($id)
    {
        // $db = new DataBase;
        // $db->delete("posts", $id);
        // $this->redirect("admin/post");

        $db = new DataBase();
        $post = $db->select('SELECT * FROM posts WHERE id = ?;', [$id])->fetch();
        $this->removeImage($post['img_address']);
        $db->delete('posts', $id);
        $this->redirectBack();
    }
}
