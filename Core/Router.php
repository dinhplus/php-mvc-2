<?php



class Router{
    /**
     * $routerList = ["url"=>$callback,"url"=> $callback]
     * - $callback = ["callback"=> Controller@action, "method"=>"GET"]
     * - $callback = ["callback"=> Controller@action, "method"=>"POST"]
     */
    static $routerList = [];

    public static function GET($url_define,$callback){
        self::$routerList = array_merge(self::$routerList,array($url_define=>array("callback"=>$callback,"method"=>"GET")));

    }
    public static function POST($url_define,$callback, array $params = []){
        self::$routerList = array_merge(self::$routerList, array($url_define => array("callback" => $callback, "method" => "POST")));
    }
    public static function PUT($url_define,$callback, array $params = []){
        self::$routerList = array_merge(self::$routerList, array($url_define => array("callback" => $callback, "method" => "PUT")));
    }
    public static function DELETE($url_define,$callback, array $params = [])
    {

        self::$routerList = array_merge(self::$routerList, array($url_define => array("callback" => $callback, "method" => "DELETE")));
    }
    public static function PATCH($url_define,$callback, array $params = []){
        //
        self::$routerList = array_merge(self::$routerList, array($url_define => array("callback" => $callback, "method" => "PATCH")));
    }

     /**
     * $routerList = ["url"=>$callback,"url"=> $callback]
     * - $callback = ["callback"=> Controller@action, "method"=>"GET"]
     * - $callback = ["callback"=> Controller@action, "method"=>"POST"]
     */
    protected static function loadController($callback,array $params=[]){
        // var_dump($callback);
        if($callback["method"]===$_SERVER["REQUEST_METHOD"]){
            if (is_string($callback["callback"])) {
                $stack = explode('@', $callback["callback"]);
                if ($stack[1] != NULL) {
                    $callback["callback"] = array("controller" => $stack[0], "action" => $stack[1]);
                    $Ctrl = $callback["callback"]["controller"];
                    $file = ROOT . "Controllers/" . $Ctrl . ".php";
                    require_once($file);
                    $controller = new $Ctrl;
                    call_user_func_array([$controller, $callback["callback"]["action"]], $params);
                } else echo "callback string has form Controller@action";
            } else if (is_callable($callback["callback"])) {
                return call_user_func($callback["callback"]);
            }
        }else echo("<h1> method request is invalid! <h1>");

    }
    public static function loadPublicFile($file){

    }
    public static function parse( &$request)
    {
        $url_extract = explode('?', trim($request->url));
        $request->url = $url_extract[0]??'';
        $query_string = $url_extract[1] ?? '';

        if ($request->method == "POST") {
            $explode_url = explode('/', $request->url);
            $request->params = array_merge(array_slice($explode_url, 3), $_POST);

        } else {
            $explode_url = explode('/', $request->url);
            $request->params =array_slice($explode_url, 3);

        }
    }
    public static function route()
    {
        $request = new Request;
        static::parse($request);
        foreach (self::$routerList as $url=>$callback) {
            // if (strpos($request->url, "/public") === 0) {
            //     echo "hehehe";
            //     static::loadPublicFile($request->url);
            // } else
            if (!in_array($request->url,array_keys(self::$routerList))){
                static::loadController(array("callback"=>"ErrorController@notFound","method"=>"GET"));
            }
            else if($request->url===$url){

                static::loadController($callback,$request->params);
            }

        }
    }


}


require_once(ROOT."Routers/api.php");
require_once(ROOT."Routers/web.php");
Router::route();