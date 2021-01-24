<?php


namespace MWI;

use PDO;
use PDOException;

/**
 * Class Dbconnect
 * @package MWI
 */
class Dbconnect
{
    public static function getConnection()
    {
        $dsn = "sqlsrv:Server=178.249.131.161,1433;Database=docdoc";
        try {
            $db = new PDO($dsn, 'logMWI', 'Lig219D5G24t');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print 'Something wrong: ' . "<b>{$e->getMessage()}</b>";
        }
        return $db;
    }
}

