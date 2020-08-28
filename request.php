<?php
class Request
{
    public $url;
    public $method;
    public $query;

    public function __construct()
    {
        $this->url = $_SERVER["REQUEST_URI"];
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->query = [];
    }
}
