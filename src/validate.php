<?php
/**
 * Created by PhpStorm.
 * User: 傅雨 frank@verystar.cn
 * Date: 2016/5/9
 * Time: 15:03
 */
namespace src;

use Closure;

class validate {
    private $defaultrules = [
        'email', 'ip'
    ];

    public $rules = [];

    protected $errmsg = [];
//
    protected $defaultmsg;

    public function __construct() {
        $this->defaultmsg = 'validate error';//default errmsg
    }

    public function setDefaultMsg($errmsg) {
        $this->$defaultmsg = $errmsg;
    }

    public function setRule($name, Closure $func) {
        if (isset($this->rules[$name]) || !$func instanceof Closure) {
            return false;
        }

        $this->rules[$name] = $func;

        return true;
    }

    //todo 补充方法

    protected function email($val) {
        $pattern = '/^[A-Za-z0-9-_.+%]+@[A-Za-z0-9-.]+\.[A-Za-z]{2,4}$/';
        preg_match($pattern, $val, $matches);

        return $matches ? true : false;
    }

    protected function ip($val) {
        $rs = filter_var($val, FILTER_VALIDATE_IP);

        return $rs ? true : false;
    }

    //例子：validate=[
    //    'func'=>'email',
    //    'val'=>'249734882@qq.com',
    //    'errmsg'=>'wrong',(可空)
    //    'label'=>'邮箱',(可空)
    //    'field'=>'email'
    //];

    public function validate(array $validate) {
        if (!$validate) {
            return false;
        }

        return array_reduce($validate, function ($result, $v) {

            if (!isset($this->rules[$v['func']]) && !in_array($v['func'], $this->defaultrules)) {
                $result[] = ['status' => false, 'msg' => 'validate func not found', 'field' => $v['field'], 'label' => $v['label']];
            } else {
                $status   = isset($this->rules[$v['func']]) ? $this->rules[$v['func']]($v['val']) : call_user_func([get_class($this), $v['func']], $v['val']);
                $result[] = [
                    'status' => $status,
                    'msg'    => $status ? 'ok' : ($v['errmsg'] ? $v['errmsg'] : $v['label'] . ':' . $this->defaultmsg),
                    'field'  => $v['field'],
                    'label'  => $v['label']
                ];
            }
            return $result;
        });
    }


}