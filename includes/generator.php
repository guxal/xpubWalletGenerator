<?php
/**
 * Class Generator
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
 * @version  Release: 1.0.;0
 * @link     https://github.com
 */
class Generator2
{

    private $_label;
    private $_network;
    private $_currency;
    private $_xpub;

    /**
     * Constructor
     *
     * @param string $label    username
     * @param string $network  password
     * @param string $currency coin name
     * @param string $xpub     HD wallet
     *
     * @return void
     */
    public function __construct($label, $network, $currency, $xpub)
    {
        include_once './wallet.php';
        if (!createWallet(1, $xpub, $currency, $network)) {
             throw new Exception('Wrong data, not create wallet.');
        } else {
            $this->_label = $label;
            $this->_network = $network;
            $this->_currency = $currency;
            $this->_xpub = $xpub;
        }
    }
    /**
     * Display user xpub saved data.
     *
     * @param string $token token user identify
     *
     * @return Token or Null
     */
    public static function index($token)
    {
        global $pdo;
        $query = "SELECT x.id as xpub_id, x.currency, x.label, x.network, x.xpub,
                  (SELECT COUNT(*) FROM wallets w WHERE x.id = w.xpub_id) as idx
                  FROM xpub x
                  WHERE x.user_id = (SELECT id FROM user WHERE token =:token)";

        $sentencia = $pdo->prepare($query);
        $sentencia->bindParam(':token', $token, PDO::PARAM_INT);
        $sentencia->execute();

        $xpub_data = $sentencia->fetchAll(PDO::FETCH_OBJ);

        return ($xpub_data);
    }
    /**
     * Save xpub generator in the db
     *
     * @param string $token token user identify
     *
     * @return Token or Null
     */
    public function store($token)
    {
        global $pdo;

        $label = $this->_label;
        $network = $this->_network;
        $currency = $this->_currency;
        $xpub = $this->_xpub;

        $query = "INSERT INTO xpub
                  VALUES (0, (SELECT id FROM user WHERE token = :token),
                         :label, :network, :currency, :xpub)";
        $sentencia = $pdo->prepare($query);

        $sentencia->bindParam(':label', $label, PDO::PARAM_STR);
        $sentencia->bindParam(':network', $network, PDO::PARAM_STR);
        $sentencia->bindParam(':currency', $currency, PDO::PARAM_STR);
        $sentencia->bindParam(':token', $token, PDO::PARAM_STR);
        $sentencia->bindParam(':xpub', $xpub, PDO::PARAM_STR);

        return $sentencia->execute();
    }

    /**
     * Save wallet in the db
     * 
     * @param int    $xpub_id identify xpub associate
     * @param string $wallet  save wallet
     *
     * @return True or False.
     * */
    private function _save($xpub_id, $wallet)
    {
        global $pdo;
        $query = "INSERT INTO wallets VALUES(0,:wallet,'0',:xpub_id)";
        $sentencia = $pdo->prepare($query);
        $sentencia->bindParam(':wallet', $wallet, PDO::PARAM_STR);
        $sentencia->bindParam(':xpub_id', $xpub_id, PDO::PARAM_INT);
        $r = $sentencia->execute();

        return $r;
    }

    /**
     * Generate new wallet
     * 
     * @param string $label    identify xpub select.
     * @param string $currency currency generate wallet.
     * @param string $token    token user identify.
     *
     * @return address and idx.
     * */
    public static function wallet($label, $currency, $token)
    {
        include_once './wallet.php';
        global $pdo;

        $sentencia = $pdo->prepare(
            'SELECT x.id, x.network, x.xpub, x.label, x.currency,
             (SELECT COUNT(*) FROM wallets w WHERE x.id = w.xpub_id) as idx
             FROM user u
             INNER JOIN xpub x on(x.user_id = u.id)
             WHERE u.token = :token
             AND x.label = :label AND
             x.currency = :currency'
        );

        $sentencia->bindParam(':token', $token, PDO::PARAM_STR);
        $sentencia->bindParam(':label', $label, PDO::PARAM_STR);
        $sentencia->bindParam(':currency', $currency, PDO::PARAM_STR);

        $r = $sentencia->execute();
        if ($sentencia->rowCount() == 0) {
            throw new Exception('Invalid label or token');
        }

        $d = $sentencia->fetch(PDO::FETCH_ASSOC);
        $d = (object) $d;

        $address = createWallet($d->idx, $d->xpub, $d->currency, $d->network);

        if (!$address) {
            throw new Exception('Error creating wallet.');
        }
        
        if (!self::_save($d->id, $address)) {
            throw new Exception('Error saving wallet.');
        }
        
        $result = new stdClass();
        $result->wallet = $address;
        $result->idx = $d->idx;

        return ($result);
    }
}
