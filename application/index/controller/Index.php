<?php

namespace app\index\controller;

use app\index\common\ReadModel;
use app\index\common\SocketCommunicationUtils;
use think\Controller;

class Index extends Controller
{
    /**
     * 通讯套接字
     *
     * @var SocketInitializationUtils
     */
    private $communicationUtil;

    private $usernameTest = "Super";
    private $passwordTest = "123456";

    public function index()
    {
        $this->communicationUtil = new SocketCommunicationUtils();
        $input = input('post.');
        $readData = '';
        $result = $this->communicationUtil->write("11", 24, pack("a12a12", $this->usernameTest, $this->passwordTest));
        if (!$result) {
//            $this->error('远程通讯失败', url('index/login'));
        } else {
            $readData = $this->communicationUtil->read($this->communicationUtil->getSocket());
        }
        echo 'response: ' . $readData.'<br/>';
        $readModel = new ReadModel();
        $readModel->setId(substr($readData, 1, 2));
        $readModel->setData(unpack("a", substr($readData, 3, strlen($readData) - 3)));
        echo '<br/>';
        $id=$readModel->getId();
        $data=$readModel->getData();
        var_dump($id);
        echo '<br/>';
        var_dump(unpack("h2", substr($readData, 3, 1)));
        echo '<br/>';
        var_dump(unpack("h2", substr($readData, 4, 1)));
        echo '<br/>';
        var_dump(unpack("h2", substr($readData, 5, 1)));
        echo '<br/>';
        var_dump($data);
        echo '<br/>';
        echo 'data: ' ;
        /*if(isset($_COOKIE['admin'])){
            $sure = input('sure',0,'intval');
            if($sure==1) {
                $data = input('post.');
                return $this->fetch('index/index',['sure'=>$sure]);
            }else{
                return $this->fetch('index/index',['sure'=>$sure]);
            }
        }else{
            $this->error('请先登录',url('index/login'));
        }*/
    }

    //登录
    public function login()
    {
        return $this->fetch('index/login');
    }

    /**
     * 登录验证
     */
    public function loginCheck()
    {
        $this->sorket = new SocketInitializationUtils();
        /*$data = file_get_contents('index.txt');
        $arr = explode('&@#',$data);*/
        var_dump("used!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
        $this->sorket->code = 11;
        $input = input('post.');
        $data[0] = $input['Username'];
        $data[1] = $input['Password'];
        $this->sorket->write($data);
        /*$input = input('post.');
        if($arr[0]!=$input['Username'] || $arr[1]!=$input['Password']){
            $this->error('登录失败',url('Index/login'));
        }else{
            cookie('admin',$input['Username']);
            $this->redirect(url('index/index/index'));
        }*/
    }

    //退出登录
    public function logout()
    {
        cookie('admin', null);
        $this->redirect('Index/login');
    }

    //修改密码
    public function changePass()
    {
        $data = file_get_contents('index.txt');
        $arr = explode('&@#', $data);
        $input = input('post.');
        if (empty($input['old_pass']) && empty($input['new_pass']) || empty($input['re_new_pass'])) {
            $this->error('密码为空', url('Accounts/changePass'));
        }
        if ($input['old_pass'] != $arr[1]) {
            $this->error('旧密码错误', url('Accounts/changePass'));
        }
        if ($input['new_pass'] != $input['re_new_pass']) {
            $this->error('两次密码不一致', url('Accounts/changePass'));
        }
        if (strlen($input['new_pass']) < 6 || strlen($input['new_pass']) > 32 || strlen($input['re_new_pass']) < 6 || strlen($input['re_new_pass']) > 32) {
            $this->error('长度介于6到32之间', url('Accounts/changePass'));
        }
        $str = '';
        $str = $_COOKIE['admin'] . '&@#' . $input['new_pass'];
        file_put_contents('index.txt', $str);
        $this->success('修改成功', url('Accounts/changePass'));
    }

}
