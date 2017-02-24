<?php
namespace app\index\controller;
use think\Controller;   // 用于与V层进行数据传递
use app\model\Teacher;  // 教师模型
use think\Request;
/**
 * 教师管理, 继承think\Controller后，就可以利用V层对数据进行打包了。
 */
class TeacherController extends Controller
{
    public function index()
    {
        $Teacher = new Teacher; 
        $teachers = $Teacher->select();

        // 向V层传数据
        $this->assign('teachers', $teachers);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }

    public function add()
    {
        $htmls = $this->fetch();
        return $htmls;
    }

    public function insert()
    {
        // 接收传入数据
        $teacher = input('post.');
        $teacher['create_time'] = time();   // 加入时间戳

        // 引用Teacher模型
        $Teacher = new Teacher();

        // 加入验证信息
        $result = $Teacher->validate(true)->data($teacher)->save();

        // 反馈结果
        if (false === $result)
        {
            return '新增失败:' . $Teacher->getError();
        } else {
            return $teacher['name'] . '新增成功';
        }
    }

    public function delete()
    {
        // 接收ID，并转换为int类型
        $id = input('get.id/d');

        // 获取要删除的对象
        $Teacher = Teacher::get($id);

        if (false === $Teacher)
        {
            return $this->error('不存在id为' . $id . '的教师，删除失败');
        }

        // 删除获取到的对象
        if (false === $Teacher->delete())
        {
            return $this->error('删除失败:' . $Teacher->getError());
        }

        // 进行跳转
        return $this->success('删除成功', url('index'));
    }

    public function edit()
    {
        // 获取传入ID
        $id = Request::instance()->param('id/d');

        // 在Teacher表模型中获取当前记录
        if ($Teacher = Teacher::get($id)) {
            // 将数据传给V层
            $this->assign('Teacher', $Teacher);

            // 获取封装好的V层内容
            $htmls = $this->fetch();

            // 将封装好的V层内容返回给用户
            return $htmls;
        } else {
            return '系统未找到ID为' . $id . '的记录';
        }
    }

    public function update()
    {
        //var_dump(Request::instance()->post());
        //接收数据
        $teacher=Request::instance()->post();

        //将数据存入Teacher表
        $Teacher=new Teacher();
        $state=$Teacher->validate(true)->isUpdate(true)->save($teacher);
        var_dump($state);
        if($state)
        {return '更新成功';


        }else { return '更新失败';
            # code...
        }
        //依据状态定制提示信息
    }
}