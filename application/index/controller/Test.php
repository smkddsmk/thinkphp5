<?php
namespace app\index\controller;
use think\Db;
class Test
{
    public function index()
    {
        $teachers= Db::name('teacher')->select();
        var_dump($teachers);
        echo $teachers[0]['name'];
        return $teachers[1]['name'];
    }
}
