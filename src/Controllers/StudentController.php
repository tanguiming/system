<?php

/**
 *  StudentController.php 
 *  
 * 	@author		wpz
 * @date			2015-09-10
 * @version	1.0
 */

namespace Weitac\System\Controllers;

use Auth;
use Response;
use App\Http\Controllers\Controller;
use Weitac\System\models\Student as Student;
use Illuminate\Support\Facades\Input;

class StudentController extends Controller {

    /**
     * 显示用户列表
     */
    public function index()
    {
        return view('system::student.index');
        //return view('system::student.index')->with('message', "111111");
    }

    /**
     * 
     * @return type
     */
    public function ajaxIndex()
    {
        $content = new Student;
        $where = array();

        //条件
        if (Input::has('name')) {
            if (Input::get('name')) {
                $where['name like '] = "%" . Input::get('name') . "%";
            }
        }

        $page = isset($_GET['page']) ? intval($_GET['page']) : 0;

        $pagesize = isset($_GET['pagesize']) ? intval($_GET['pagesize']) : $this->pagesize;

        $obj = $content->setWhere($where);

        if (isset($_GET['orderby'])) {
            $order = explode('|', $_REQUEST['orderby']);
            $res = $obj->orderBy($order[0], $order[1])->paginate($pagesize)->toArray();
        } else {
            $res = $obj->paginate($pagesize)->toArray();
        }

		//循环遍历数据将数据库中的时间戳，转换成Y-m-d H:i:s的形式
        foreach ($res['data'] as $k => &$v) {
			$res['data'][$k]['sex'] = $v['sex'] == '1'?'男':'女';
        } 
		
        return Response::json($res);
    }

    public function add()
    {
        return view('system::student.add');
    }

    public function insert()
    {
        $data =Input::except('/admin/core/system/student/insert', '_');
		
		$obj = new Student();
		$return = $obj->check($data);
		if ($return['status']) {
			$return = $obj->add($data);
		}
		
		return Response::json($return);
    }
	
	/**
	 * 修改获取模板
	 * @return type
	 */
	public function edit() {
		$id = Input::get('id');
		$data = Student::find($id)->toArray();
		return view('system::student.edit',$data);
    }
	
	public function edit1() {
		
		$id = Input::get('id');
		$data = Student::find($id)->toArray();
		return view('system::student.edit1',$data);
    }
	
    /**
     * 保存修改
     * @return type
     */
    public function update() {
		$data = Input::except('/admin/core/system/student/update','_token');
		$obj = new Student;
        $result = $obj->check($data);

        if ($result['status'] == true) {
            $result = $obj->edit($data);
        }
        return Response::json($result);
    }
	
	/**
     *  删除
     */
    public function del() {
            $id = Input::get('listid');
            $obj = new Student;
            return Response::json($obj->del($id));
    }
}
