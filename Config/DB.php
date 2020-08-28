<?php
class DB
{   public static $dbname = "mvc_php";
    private static $conn = null;
    public function __construct()
    {
        $testDB = static::getConnection()->prepare("use ".self::$dbname);
        if(!$testDB->execute()){
            echo "connect failed!";
        }else{
            echo(`
                <script> console.log("connect completed");
                </script>
            `);
        }
    }
    public static function getConnection()
    {
        if (is_null(self::$conn)) {
            self::$conn = new PDO("mysql:host=localhost;dbname=mvc_php", 'root', '');
        }
        return self::$conn;
    }
}
