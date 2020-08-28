<?php



class Router{
    public static function GET($url_define,$callback,array $params=[]){
        $request = new Request;
        static::parse($request);
        // var_dump($request->query);
        if($request->url==$url_define&&$request->method=="GET"){
            static::loadController($callback,$request->params);
        }
    }
    public static function POST($url_define,$callback, array $params = []){

    }
    public static function PUT($url_define,$callback, array $params = []){

    }
    public static function DELETE($url_define,$callback, array $params = [])
    {
        # code...
    }
    public static function PATCH($url_define,$callback, array $params = []){
        //code
    }
    protected static function loadController($callback,array $params=[]){
        if(is_string($callback)){
            $stack=explode('@',$callback);
            if($stack[1]!=NULL){
                $callback=array("controller"=> $stack[0],"action"=> $stack[1]);
                $Ctrl = $callback["controller"];
                $file = ROOT."Controllers/".$Ctrl.".php";
                require_once($file);
                $controller =new $Ctrl;
                call_user_func_array([$controller,$callback["action"]],$params);
            }else echo "callback string has form Controller@action";
        }
        else if(is_callable($callback)){
            return call_user_func($callback);
        }
    }
    static public function parse( &$request)
    {
        $url_extract = explode('?', trim($request->url));
        $request->url = $url_extract[0]??'';
        $query_string = $url_extract[1] ?? '';
        $request->query = $query_string == '' ? [] : static::queryHandle($query_string);
        if ($request->method == "POST") {
            $explode_url = explode('/', $request->url);
            $request->params = array_merge(array_slice($explode_url, 3), $_POST);
        } else {
            $explode_url = explode('/', $request->url);
            $request->params = array_merge(array_slice($explode_url, 3),$request->query);

        }
    }
    /**
     * - $query_string has form "query=value&q=val"
     * - $query has form ["question"=>value,"q"=>val,"search"=>"abc xyz"]
     */
    static public function queryHandle($query_string)
    {
        $query_arr = explode("&", $query_string);
        $result = [];
        foreach ($query_arr as $key => $value) {
            $qr = explode("=", $value);
            $temp = array($qr[0] => $qr[1]);
            $result = array_merge($result, $temp);
        }
        return $result;
    }

}


require_once("Routers/api.php");
require_once("Routers/web.php");