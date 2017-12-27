<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::get('/', 'index/Index/index');
<<<<<<< HEAD

// Route::resource('users', 'rest/user');
// Route::get('users/read/:id', 'rest/user/readpage');
=======
Route::get('/user/del','admin/user/del');
Route::resource('user', 'admin/User');
Route::get('users/read/:id', 'rest/User/readpage');
>>>>>>> 8aa8129c464630872995f1daeb3f6430c7bedb79


return [

];
