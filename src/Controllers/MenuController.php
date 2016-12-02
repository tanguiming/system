<?php

/**
 *  MenuController.php   系统菜单管理  控制器
 *  
 * 	@author		xiaguanghua
 * @date			2015-09-16
 * @version	1.0
 */

namespace Weitac\System\Controllers;

use Auth;
use Response;
use App\Http\Controllers\Controller;
//use Core\System\models\Menu as Menu;
use Illuminate\Support\Facades\Input;
use DB;
use Weitac\System\models\Menu as Menu;

class MenuController extends Controller {

    public $pagesize = 10;

    public function __construct()
    {
        $this->middleware('auth.aca');
    }

    /**
     * 显示用户列表
     */
    public function index()
    {
        // $parentid =Input::get('parentid');
        $menuid = Input::get('menuid') ? Input::get('menuid') : '';

        if ($menuid == "") {
            //如果id为空，说是顶级
            $return_id = "";
        } else {
            //如果不为空，说明是子类，需要查询它的上一级父id
            $return_id = DB::table('menu')->where('menuid', $menuid)->pluck('parentid');
        }

        $res = array('return_id' => $return_id, 'menuid' => $menuid);
        return view('system::admin.menu.index', $res);
    }

    /**
     * 
     * @return type
     */
    public function ajaxIndex()
    {
        $content = new Menu;
        $where = array();

        //条件
        if (Input::has('menuid')) {
            if (Input::get('menuid')) {
                $where['parentid = '] = Input::get('menuid');
            }
        } else {
            $where['parentid IS'] = " NULL";
        }

        // else{
        //     //parentid为空的时候走
        //     $where['parentid ='] = Input::get('parentid');
        // }

        $page = isset($_GET['page']) ? intval($_GET['page']) : 0;

        $pagesize = isset($_GET['pagesize']) ? intval($_GET['pagesize']) : $this->pagesize;

        $obj = $content->setWhere($where);

        // echo '<pre>';
        // dd($obj);

        if (isset($_GET['orderby'])) {
            $order = explode('|', $_REQUEST['orderby']);
            $res = $obj->orderBy($order[0], $order[1])->paginate($pagesize)->toArray();
        } else {
            $res = $obj->paginate($pagesize)->toArray();
        }

        //   echo '<pre>';
        // dd($res);
        //循环遍历数据将数据库中的时间戳，转换成Y-m-d H:i:s的形式
        foreach ($res['data'] as $k => &$v) {
            $res['data'][$k]['status'] = $v['status'] == '1' ? '显示' : '<span style="color:red">禁用</span>';
        }

        return Response::json($res);
    }

    public function add()
    {
        $menuid = Input::get('menuid');
        //   echo '<pre>';
        // dd($menuid);
        $res = array('menuid' => $menuid);
        return view('system::admin.menu.add', $res);
    }

    public function insert()
    {

        $data = Input::except('/admin/core/system/menu/insert', '_', 'return_id');
        $parentid = $data['parentid']; //获取当前父类ID
        $data = array_filter($data);
        // echo '<pre>';
        // dd($data);

        $obj = new Menu();
        $result = $obj->check($data);

        if ($result['status']) {
            // dd($data);
            $return = $obj->add($data);

            // 调用父类
            $this->updateParents($parentid);
        }
        return Response::json($return);
    }

    /**
     * 修改获取模板
     * @return type
     */
    public function edit()
    {
        $menuid = Input::get('menuid'); //菜单主键
        $data = Menu::find($menuid)->toArray();

        $res = array('menuid' => $menuid, 'data' => $data);
        return view('system::admin.menu.edit', $res);
    }

    /**
     * 保存修改
     * @return type
     */
    public function update()
    {

        $data = Input::except('/admin/core/system/menu/update', '_', 'return_id');

        // echo '<pre>';
        // dd($data);
        $obj = new Menu;
        $result = $obj->check($data);

        if ($result['status'] == true) {
            $result = $obj->edit($data);
        }
        return Response::json($result);
    }

    /**
     *  删除
     */
    public function del()
    {
        $menuid = Input::get('menuid');
        $result = $this->count_parent($menuid);

        if ($result == 0) {
            $obj = new Menu;
            return Response::json($obj->del($menuid));
        } else {

            return Response::json(array('status' => FALSE, 'msg' => '菜单下有分类不能删除!'));
        }
    }

    //统计指定父类ID，条数

    public function count_parent($menuid)
    {
        $num = DB::table('menu')->where('parentid', $menuid)->count();
        return $num;
    }

    /**
     * 获取子列表
     */
    public function getChilds($menuid = false)
    {
        $menuid = $menuid ? $menuid : Input::get('menuid');
        $menu = Menu::find($menuid);
        $childs = array();

        if ($menu) {
            $childsArr = $menu->getChilds();

            foreach ($childsArr as $child) {
                $arr['name'] = $child->name;
                $arr['url'] = $child->url;
                $arr['menuid'] = $child->menuid;
                $arr['childids'] = $child->childids;
                $childs[] = $arr;
            }


            $data = array(
                'name' => $menu->name,
                'menuid' => $menu->menuid,
                'url' => $menu->url,
                'childs' => $childs,
                'ischilds' => count($childs)
            );

            return json_encode($data);
        }
    }

    //更新上级目录 child字段
    public function updateParents($parentid)
    {

        //判断父类ID是否为空如果是空说明是顶级分类。
        if ($parentid == "") {
            $data = DB::table('menu')->whereRaw('parentid is null')->get();
        } else {
            $data = DB::table('menu')->where('parentid', $parentid)->get();
        }

        $childsArr = array();
        foreach ($data as $key => $value) {
            $childsArr[] = $value->menuid;
        }

        //拼接成字符串
        $childids = implode(',', $childsArr);

        //更新数据表,非顶级分类的时候就更新
        if ($parentid != "") {
            DB::table('menu')->where('menuid', $parentid)->update(['childids' => $childids]);
        }

        return true;
    }

}
