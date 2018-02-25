<?php
/**
 * Created by PhpStorm.
 * User: qianying
 * Date: 2018/2/25
 * Time: 23:35
 */

namespace app\index\common;


class ReadModel
{
    /**
     * @var 标识头
     */
    private $headerSign;

    /**
     * @var 标识id
     */
    private $id;

    /**
     * @var 数据
     */
    private $data;

    function __construct()
    {
        $this->headerSign="@";
    }

    /**
     * @return 标识id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param 标识id $id
     */
    public function setId($id)
    {
        $this->id = unpack("n", $id);
    }

    /**
     * @return 数据
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param 数据 $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string 获取返回的最终数据
     */
    public function getReadData(){
        return $this->headerSign.$this->getId().$this->getData();
    }
}