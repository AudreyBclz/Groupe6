<?php


namespace Core;


 class Log implements LogInterface
{
    private $file;
    public function __construct($filename=PATH_LOG)
    {
        $this->file=fopen($filename,'a+');

    }

    public function write($msg)
    {
        fwrite($this->file,'['.date('d-m-Y à H:i:s').']  '.$msg." \n");
        fclose($this->file);
    }
}