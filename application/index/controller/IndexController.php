<?php
namespace app\index\controller;
use think\Db;

class IndexController
{
    public function index()
    {
        var_dump(Db::name('teacher')->find());
    }
}
