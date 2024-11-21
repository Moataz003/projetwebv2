<?php
class config{
    private static $pdo = NULL;

    public static function getConnexion(){
        if (!isset(self::$pdo)){
            try{
                self::$pdo = new PDO('mysql:host=localhost;dbname=motaz', 'root', '',
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]);
                    echo 'Connecte avec succes';
            }
            catch(PDOException $e){
                die('La connexion a echoue : '. $e->getMessage());
            }
        }
        return self::$pdo;
        }
}

?>