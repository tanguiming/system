<?php

namespace Weitac\System\Controllers;

use App\Http\Controllers\Controller;
use Weitac\System\models\Menu as Menu;
use DB;
use Session;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Weitac;

use Core\User\Http\Models\User as User;
class SystemController extends Controller {

    public function __construct()
    {
        $this->middleware('auth.aca');
    }

    public function index()
    {

        $menu_data = DB::table('menu')
                ->whereRaw('status =1 and parentid  is null')
                ->select('menuid', 'childids', 'url', 'name')
                ->orderBy('sort', 'asc')
                ->get();
			
		//过滤数组 2016 10 19 改的 
		foreach($menu_data as $k=>$v){
			
				$ress[$k]= $this->getChilds($v->menuid);
				
				//	判断里面的值ischilds  如果为空 则过滤掉
					if(empty($ress[$k]['ischilds'])){
						unset($ress[$k]);
					}else{
						
						$ress[$k] =$v;
					}
				
		}
		
		
		
		//头像相关东西
		$username = Session::get('admin.user.username');
		$user_id = Session::get('admin.user.user_id');
        $res = array('menu_data' => $ress, 'username'=>$username, 'user_id'=>$user_id);
				
        return view('system::admin.default', $res);
    }

    public function defaults()
    {

        return view('system::admin.index');
    }

    /*
    修改密码页面显示操作
    */
    public function editPwd(){
        return view("system::admin.editPwd");
    }


    /*
    修改密码保存操作
    */
    public function updatePwd(){
        $sessionUerId=Session::get("admin.user.user_id");  //获取当前登录人id
        $data['user_id'] =$sessionUerId;
        $data['password'] = Input::get('password');
        if (!empty($data['password'])) {
            $obj = new User;
            //dd($obj);
            $info = $obj->check($data, 'pwd');

            if ($info['status'] == true) {
                $info = $obj->changePassword($data);

                //Event::fire('log.action', array('user.pwd', $data['user_id']));
            }

            return Response::json($info);
        } else {
            $info = array('status' => false, 'msg' => '密码不可以为空');
            return Response::json($info);
        }
    }

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

            return $data;
        }
    }
	
	
	
}
