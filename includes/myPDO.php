<?php
/**
 * Created by PhpStorm.
 * user.class: Spike_Only
 * Date: 06/08/2018
 * Time: 22:27
 */

class myPDO
{

    /**
     * Instance de la classe myPDO.class
     *
     * @var class
     * @access private
     * @static
     */
    private static $instance = null;

    /**
     * Constante: nom d'utilisateur de la bdd
     *
     * @var string
     */
    const DEFAULT_SQL_USER = 'root';

    /**
     * Constante: hôte de la bdd
     *
     * @var string
     */
    const DEFAULT_SQL_HOST = 'localhost';

    /**
     * Constante: hôte de la bdd
     *
     * @var string
     */
    const DEFAULT_SQL_PASS = '';

    /**
     * Constante: nom de la bdd
     *
     * @var string
     */
    const DEFAULT_SQL_DTB = 'trustiful';


    private function __construct()
    {
    }

    /**
     * Crée et retourne l'objet myPDO
     *
     * @access public
     * @static
     * @return PDO $instance
     */
    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new PDO('mysql:dbname='.self::DEFAULT_SQL_DTB.';host='.self::DEFAULT_SQL_HOST,self::DEFAULT_SQL_USER ,self::DEFAULT_SQL_PASS);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }
}