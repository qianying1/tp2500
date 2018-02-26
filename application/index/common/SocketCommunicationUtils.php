<?php
/**
 * Created by PhpStorm.
 * User: qianying
 * Date: 2018/1/31
 * Time: 21:38
 */

namespace app\index\common;


use think\Exception;

class SocketCommunicationUtils
{
    private $socket;
    private $port = 56200;
    private $host = '39.108.219.90';
    private $writeModel;

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
        $this->setSocket(socket_create(AF_INET, SOCK_STREAM, getprotobyname("tcp")));
        if (!$this->socket) {
            exit("创建连接失败");
        }
        $result = socket_connect($this->socket, $this->host, $this->port);
        if (!$result) {
            exit("连接服务器失败");
        }
        $this->writeModel = new WriteModel();
    }

    public function write($id, $length, $data)
    {
        $this->writeModel->setId($id);
        $this->writeModel->setDataLength($length);
        $this->writeModel->setData($data);
        return $this->send();
    }

    /**
     * @return int 发送数据
     */
    private function send()
    {
        $tcpData = bin2hex($this->writeModel->getWriteData());
        $tcpDatas = str_split(str_replace(' ', '', $tcpData), 2);// 将16进制数据转换成两个一组的数组
        for ($j = 0; $j < count($tcpDatas); $j++) {
            echo 'tcpData' . $j . ' ' . $tcpDatas[$j] . '<br/>';
            socket_write($this->socket, chr(hexdec($tcpDatas[$j])));  // 逐组数据发送
        }
        return true;
//        $result = socket_write($this->socket, $this->writeModel->getWriteData());
//        return $result;
    }

    /**
     * @param $socket
     * @return int|string 接收远程数据
     */
    public function read($socket)
    {
        return @socket_read($socket, 1024, PHP_BINARY_READ);
    }

    /**
     * @return resource
     */
    public function getSocket()
    {
        return $this->socket;
    }

    /**
     * @param resource $socket
     */
    public function setSocket($socket)
    {
        $this->socket = $socket;
    }

    public function __desctruct()
    {
        socket_close($this->socket);
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }
}