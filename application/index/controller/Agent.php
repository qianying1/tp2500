<?php
namespace app\index\controller;

class Agent extends Base
{
    public function add_agent()
    {
        return $this->fetch('index/agent/add_agent');
    }

    public function add_tuiguanhao()
    {
        return $this->fetch('index/agent/add_tuiguanhao');
    }

    public function all_accounts()
    {
        $sure = input('sure', 0, 'intval');
        if ($sure == 1) {
            $data = input('post.');
            return $this->fetch('index/agent/all_accounts', ['sure' => $sure]);
        } else {
            return $this->fetch('index/agent/all_accounts', ['sure' => $sure]);
        }
    }

    public function up_down_accounts()
    {
        $sure = input('sure', 0, 'intval');
        if ($sure == 1) {
            $data = input('post.');
            return $this->fetch('index/agent/up_down_accounts', ['sure' => $sure]);
        } else {
            return $this->fetch('index/agent/up_down_accounts', ['sure' => $sure]);
        }
    }

}
