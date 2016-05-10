<?php

/**
 * Created by PhpStorm.
 * User: 傅雨 frank@verystar.cn
 * Date: 2016/5/9
 * Time: 17:57
 */
include('../src/validate.php');
use src\validate;

$validate = new validate();


$validate->setRule('int', function ($val) {
    return is_int($val) ? true : false;
});

//    'func'=>'email',
//    'val'=>'249734882@qq.com',
//    'errmsg'=>'wrong',(可空)
//    'label'=>'邮箱',(可空)
//    'field'=>'email'
//]

$rules = [
    ['func' => 'email', 'val' => '249734882@qq.com', 'errmsg' => 'wrong', 'label' => '邮箱', 'field' => 'email'],
    ['func' => 'int', 'val' => 22, 'errmsg' => 'wrong', 'label' => '数量', 'field' => 'num']
];


var_dump($validate->validate($rules));