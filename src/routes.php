<?php
Route::get('admin/index',array('as'=>'admin.system.index', 'uses'=>'SystemController@index')); 
Route::get('admin/default',array('as'=>'admin.system.default', 'uses'=>'SystemController@defaults')); 


//学生
Route::get('admin/core/system/student/index',array('as'=>'admin.core.system.student.index', 'uses'=>'StudentController@index')); 
Route::get('admin/core/system/student/ajaxindex',array('as'=>'admin.core.system.student.ajaxindex', 'uses'=>'StudentController@ajaxindex')); 
Route::get('admin/core/system/student/add',array('as'=>'admin.core.system.student.add', 'uses'=>'StudentController@add')); 
Route::get('admin/core/system/student/insert',array('as'=>'admin.core.system.student.insert', 'uses'=>'StudentController@insert')); 
Route::get('admin/core/system/student/edit',array('as'=>'admin.core.system.student.edit', 'uses'=>'StudentController@edit')); 
Route::get('admin/core/system/student/edit1',array('as'=>'admin.core.system.student.edit1', 'uses'=>'StudentController@edit1')); 
Route::get('admin/core/system/student/update',array('as'=>'admin.core.system.student.update', 'uses'=>'StudentController@update')); 
Route::get('admin/core/system/student/del',array('as'=>'admin.core.system.student.del', 'uses'=>'StudentController@del'));


Route::get('admin/core/system/text/index',array('as'=>'admin.core.system.text.index', 'uses'=>'TextController@index')); 
Route::get('admin/core/system/text/ajaxindex',array('as'=>'admin.core.system.text.ajaxindex', 'uses'=>'TextController@ajaxindex'));
Route::get('admin/core/system/text/add',array('as'=>'admin.core.system.text.add', 'uses'=>'TextController@add')); 
Route::get('admin/core/system/text/insert',array('as'=>'admin.core.system.text.insert', 'uses'=>'TextController@insert')); 
Route::get('admin/core/system/text/edit',array('as'=>'admin.core.system.text.edit', 'uses'=>'TextController@edit')); 
Route::get('admin/core/system/text/update',array('as'=>'admin.core.system.text.update', 'uses'=>'TextController@update')); 
Route::get('admin/core/system/text/del',array('as'=>'admin.core.system.text.del', 'uses'=>'TextController@del'));

// 系统：系统菜单功能 by xiaguanghua 2015-09-16
Route::get('/admin/core/system/menu/index',array('as'=>'admin.core.system.menu.index', 'uses'=>'MenuController@index')); 
Route::get('/admin/core/system/menu/ajaxindex',array('as'=>'admin.core.system.menu.ajaxindex', 'uses'=>'MenuController@ajaxIndex')); 
Route::get('/admin/core/system/menu/add',array('as'=>'admin.core.system.menu.add', 'uses'=>'MenuController@add')); 
Route::any('/admin/core/system/menu/insert',array('as'=>'admin.core.system.menu.insert', 'uses'=>'MenuController@insert')); 
Route::get('/admin/core/system/menu/edit',array('as'=>'admin.core.system.menu.edit', 'uses'=>'MenuController@edit')); 
Route::get('/admin/core/system/menu/update',array('as'=>'admin.core.system.menu.update', 'uses'=>'MenuController@update')); 
Route::get('/admin/core/system/menu/del',array('as'=>'admin.core.system.menu.del', 'uses'=>'MenuController@del')); 
Route::get('/admin/core/system/menu/getchilds',array('as'=>'admin.core.system.menu.getchilds', 'uses'=>'MenuController@getChilds')); 


/*修改密码*/
/*修改密码页面显示路由*/
Route::get("admin/user/editPwd",array("as"=>"admin.user.editPwd","uses"=>"SystemController@editPwd"));
/*修改密码保存操作*/
Route::post("admin/weixin/updatePwd",array("as"=>"admin.weixin.updatePwd","uses"=>"SystemController@updatePwd"));