<?php
/**
 * Created by PhpStorm.
 * User: qianying
 * Date: 2018/1/31
 * Time: 21:38
 */

namespace app\index\utils;


class SocketInitializationUtils
{
    private $socket;
    private $port = 56200;
    private $host = '39.108.219.90';
    private $byte;
    private $code;
    const CODE_LENGTH = 2;
    const FLAG_LENGTH = 4;

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __construct($host = '39.108.219.90', $port = 56200)
    {
        $this->host = $host;
        $this->port = $port;
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$this->socket) {
            exit('创建socket失败');
        }
        $result = socket_connect($this->socket, $this->host, $this->port);
        if (!$result) {
            exit('连接不上目标主机' . $this->host);
        }
        $this->byte = new ByteModel();
    }

    public function write($data)
    {
        if (is_string($data) || is_int($data) || is_float($data)) {
            $data[] = $data;
        }
        if (is_array($data)) {
            foreach ($data as $vo) {
                $this->byte->writeShortInt(strlen($vo));
                $this->byte->writeChar($vo);
            }
        }
        $this->setPrev();
        $this->send();
    }

    /*
     *设置表头部分
     *表头=length+code+flag
     *length是总长度(4字节)  code操作标志(2字节)  flag暂时无用(4字节)
     */
    private function getHeader()
    {
        $length = $this->byte->getLength();
        $length = intval($length) + self::CODE_LENGTH + self::FLAG_LENGTH;
        return pack('L', $length);
    }

    private function getCode()
    {
        return pack('v', $this->code);
    }

    private function getFlag()
    {
        return pack('L', 24);
    }

    private function setPrev()
    {
        $this->byte->setBytePrev($this->getHeader() . $this->getCode() . $this->getFlag());
    }

    private function send()
    {
        $result = socket_write($this->socket, $this->byte->getByte());
        if (!$result) {
            exit('发送信息失败');
        }
    }

    public function __desctruct()
    {
        socket_close($this->socket);
    }
}