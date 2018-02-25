<?php
/**
 * Created by PhpStorm.
 * User: qianying
 * Date: 2018/2/25
 * Time: 23:34
 */

namespace app\index\common;


class WriteModel
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
     * @var 数据长度
     */
    private $dataLength;

    /**
     * @var 数据
     */
    private $data;

    function __construct()
    {
        $this->headerSign=pack("a", "@");
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
        $this->id = pack("n", $id);
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
     * @return 数据长度
     */
    public function getDataLength()
    {
        return $this->dataLength;
    }

    /**
     * @param 数据长度 $dataLength
     */
    public function setDataLength($dataLength)
    {
        $this->dataLength = pack("n", $dataLength);
    }

    /**
     * @return string 获取即将需要发送的最终数据
     */
    public function getWriteData(){
        return $this->headerSign.$this->getId().$this->getDataLength().$this->getData();
    }

}