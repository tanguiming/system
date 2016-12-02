<?php

/**
 * Menu
 * 
 * @author      xiaguanghua
 * @date        2015-09-16
 * @version     1.0
 */

namespace Weitac\System\models;

use Auth;
use Session;
use DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Weitac\User\Http\Models\UserMenu as UserMenu;

class Menu extends Model {

    protected $table = 'menu';
    protected $primaryKey = 'menuid';
    protected $_where;
    protected $fields = array('');
    protected $_order = 'menuid desc';
    public $timestamps = false;

    /**
     *  设置条件
     *  
     *  @param array $where 键值对， 键为 字段和条件   值为 值
     *  @param string $type   "and" "or"
     *  @return $this
     */
    public function setWhere($where = null, $type = 'and')
    {

        if (empty($where) || !is_array($where))
        //echo '<pre>';
            return $this;

        $data = array();
        $searchString = '';

        foreach ($where as $search => $value) {

            $isIn = strstr($search, 'in');
            $isNull = strstr($search, 'IS');

            if ($isIn) {
                $searchString .= ' ' . trim($search) . " ($value) " . $type;
            } elseif ($isNull) {
                $searchString .= ' ' . trim($search) . " $value " . $type;
            } else {
                $searchString .= ' ' . trim($search) . ' ? ' . $type;
                $data['bind'][] = trim($value);
            }
        }


        $data['param'] = substr_replace(trim($searchString, ' '), '', -4); // 去掉最后的 " and"

        if (!empty($data) && isset($data['bind'])) {
            $obj = $this->whereRaw($data['param'], $data['bind']);
        } else {
            $obj = $this->whereRaw($data['param']);
        }

        return $obj;
    }

    /**
     * 
     * @param type $date
     * @return type
     */
    public function check($date)
    {
        /**
         * 对数据的检查，如果数据不正确就返回flase
         * */
        return array('status' => TRUE, 'msg' => '表单验证通过');
    }

    /**
     * 添加总
     * @param type $data
     * @return type
     */
    public function add($data)
    {

        $this->attributes = $data;
        if ($this->save()) {
            return array('status' => TRUE, 'msg' => '添加成功');
        } else {
            return array('status' => FALSE, 'msg' => '添加失败');
        }
    }

    /**
     * 添加总
     * @param type $data
     * @return type
     */
    public function edit($data)
    {

        $menuid = $data['menuid'];
        unset($data['menuid']);

        if ($this::where('menuid', '=', $menuid)->update($data)) {
            return array('status' => TRUE, 'msg' => '修改成功');
        } else {
            return array('status' => FALSE, 'msg' => '修改失败');
        }
    }

    /**
     * 
     * @param type $id
     */
    public function del($menuid)
    {
        $user = $this::find($menuid);

        if ($user->delete()) {
            return array('status' => TRUE, 'msg' => '删除成功!');
        } else {
            return array('status' => FALSE, 'msg' => '删除失败!');
        }
    }

    public function getChilds($status = true)
    {

        //从Session中拿到 user_id	
        $user_id = Session::get('admin.user.user_id');
        if ($user_id != 1) {
            //从拿到的user_id 再从user_menu(权限表)中拿到该id对应的目录

            $user_temp = DB::table('user_menu')->where('user_id', intval($user_id))->first();
            $user_arr = array();
            //进行判断处理
            if ($user_temp) {
                $user_str = rtrim($user_temp->value, '|');
                $user_arr = explode('|', $user_str);
                foreach ($user_arr as $v) {
                    $pid = UserMenu::where('menuid', $v)->select('parentid')->get()->first();
                    if ($pid) {
                        $user_arr[] = $pid->parentid;
                    }
                }
                //dd($user_arr);
            }
            //从栏目表里拿到所需的字段及其值
            $menu_temp = UserMenu::where('parentid', null)->select('menuid', 'parentid', 'name', 'childids')->get()->toArray();
            //对于拿到的值进行处理
            //dd($menu_temp);
            if ($menu_temp) {
                $menu_str = rtrim($this->childids, ',');

                $menu_arr = explode(',', $menu_str);
            }
            //求出俩个数组的交集
            $childsArr = array_intersect($user_arr, $menu_arr);
        } else {
            $childsArr = explode(',', $this->childids);
        }

        $childs = array();
        if ($childsArr) {
            //$childsArr = explode(',', $this->childids);

            $childs = Menu::whereIn('menuid', $childsArr)->orderBy('sort', 'asc');


            if ($status) {
                $childs = $childs->whereRaw('status=1');
            }
            $childs = $childs->get();
        }

        return $childs;
    }

}
