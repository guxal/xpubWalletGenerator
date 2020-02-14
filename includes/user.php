<?php
/**
 * Class User
 * php version 7.0.33
 *    
 * @category MyClass
 * @package  MyPackage
 * @author   guxal <jonathanacp93@gmail.com>
 * @license  https://licence.com gnu/gplv3
 * @link     https://github.com
 */
require './conex.php';
/**
 * User Class
 *    
 * @category Class
 * @package  MyClass
 * @author   guxal <jonathanacp93@gmail.com>
 * @license  https://licence.com gnu/gplv3
 * @version  Release: 1.0.0
 * @link     https://github.com
 */
class User
{
        
    private $_username;
    private $_password;
    private $_hash;
    
    /**
     * Constructor
     *
     * @param string $username username
     * @param string $password password
     *
     * @return void
     */
    public function __construct($username, $password)
    {
        $this->_username = $username;
        $this->_password = $password;
    }
    /**
     * Login auth
     *
     * @return Token or Null
     */
    public function login()
    {
        global $pdo;
             
        $query = "SELECT * FROM user WHERE
                      username=:username AND password=:password;";
        $sentencia = $pdo->prepare($query);
        $password = md5($this->_password);
        $sentencia->bindParam(':username', $this->_username, PDO::PARAM_STR);
        $sentencia->bindParam(':password', $password, PDO::PARAM_STR);
        $sentencia->execute();

        if ($sentencia->rowCount() > 0) {  
            $d = $sentencia->fetch(PDO::FETCH_ASSOC);
            $d = $d['token'];
        } else {
            $d = null;
        }
        return $d;
    }
    /**
     * Register user
     *
     * @param string $email email user
     * @param hash   $hash  token auth register
     *
     * @return boolean
     */
    public function register($email, $hash)
    {
        global $pdo;
            
        $token = bin2hex(random_bytes(64)); //rand();//bin2hex(random_bytes(64)); 
        $password = md5($this->_password);
        $query = 'INSERT INTO user VALUES (0,:username,:email,:password,:token)';

        $sentencia = $pdo->prepare($query);

        $sentencia->bindParam(':username', $this->_username, PDO::PARAM_STR);
        $sentencia->bindParam(':email', $email, PDO::PARAM_STR);
        $sentencia->bindParam(':password', $password, PDO::PARAM_STR);
        $sentencia->bindParam(':token', $token, PDO::PARAM_STR);
                
        return $sentencia->execute();
    }

}
