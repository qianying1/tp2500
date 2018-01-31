<?php
namespace app\index\controller;
use app\index\utils\SocketInitializationUtils;
use think\Request;

class Accounts extends Base
{

    private $sorket;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->sorket = new SocketInitializationUtils();
    }

    //账号列表
    public function AccountsList()
    {
        $admin = $_COOKIE['admin'];
        return $this->fetch('index/accounts/table', ['admin' => $admin]);
    }

    //操作记录
    public function operateRecord()
    {
        return $this->fetch('index/operate/operate_record');
    }

    //在线列表
    public function aliveAccounts()
    {
        $data[] = 'testzouhao';
        $data[] = 'a';
        $this->sorket->code = 11;
        $this->sorket->write($data);
        return $this->fetch('index/accounts/alive_accounts');
    }

    //申请送分
    public function applySendScore()
    {
        $sure = input('sure', 0, 'intval');
        if ($sure == 1) {
            $data = input('post.');
            if (empty($data['account']) || empty($data['score'])) {
                $this->error('内容没填');
            } else {
                //进行逻辑操作

            }
        } else {
            return $this->fetch('index/accounts/apply_send_score');
        }
    }

    //已删账号列表
    public function alreadyDel()
    {
        return $this->fetch('index/accounts/already_del');
    }

    //更改密码
    public function changePass()
    {
        return $this->fetch('index/accounts/change_pass');
    }

    //编辑表格-功能设定
    public function gongnengsheding()
    {
        return $this->fetch('index/accounts/gongnengsheding');
    }

    //编辑表格-注册送设定
    public function zhucesongsheding()
    {
        return $this->fetch('index/accounts/zhucesongsheding');
    }

    //编辑表格-短信送设定
    public function duanxinsongsheding()
    {
        return $this->fetch('index/accounts/duanxinsongsheding');
    }

    //编辑表格-统计
    public function tongji()
    {
        return $this->fetch('index/accounts/tongji');
    }

    //编辑表格-查账
    public function chazhang()
    {
        $sure = input('sure', 0, 'intval');
        if ($sure == 1) {
            $data = input('post.');
            return $this->fetch('index/accounts/chazhang', ['sure' => $sure]);
        } else {
            return $this->fetch('index/accounts/chazhang', ['sure' => $sure]);
        }
    }

    //编辑表格-曲线
    public function quxian()
    {
        return $this->fetch('index/accounts/quxian');
    }

    //编辑表格-禁用
    public function jinyong()
    {
        return $this->fetch('index/accounts/jinyong');
    }

    //编辑表格-修改密码
    public function xiugaimima()
    {
        return $this->fetch('index/accounts/xiugaimima');
    }

    //
    public function tableedit()
    {
        return $this->fetch('index/accounts/tableedit');
    }

    //平台公告
    public function notice()
    {
        return $this->fetch('index/notice');
    }


}
