<?php

namespace Admin;

class Admin
{
    protected $currentDomain;
    protected $basePath;

    function __construct()
    {
        $this->currentDomain = CURRENT_DOMAIN;
        $this->basePath = BASE_PATH;
    }

    public function index(){
        require_once(BASE_PATH.'/template/admin/index.php');
    }

    protected function redirect($url)
    {
        header("Location: " . trim($this->currentDomain, '/ ') . '/' . trim($url, '/ '));
        exit;
    }

    protected function redirectBack()
    {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    protected function saveImage($image, $imagePath, $imageName = null)
    {
        // if (is_null($imageName)) {
        //     $extention = explode('/', $image['type'])[1];
        //     $imageName = date('Y-m-d-H-i-s') . '.' . $extention;
        // } else {
        //     $extention = explode('/', $image['type'])[1];
        //     $imageName = $imageName . '.' . $extention;
        // }

        $imageTmp = $image['tmp_name'];
        $imagePath = './public/assets/' . $imagePath . '/';

        if (is_uploaded_file($imageTmp)) {
            if (move_uploaded_file($imageTmp, $imageName . $imagePath)) {
                return $imageName . $imagePath;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    protected function removeImage($path)
    {

        $path = str_replace(CURRENT_DOMAIN , "" , $path);
        if (file_exists($path)) {
            unlink(trim($this->basePath, '/ ') ."/". trim($path , "/"));
            clearstatcache() ;
        }
    }

}