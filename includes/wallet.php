<?php
/**
 * Este es un comentario de doc
 * php version 7.2.10
 
 * @category Components
 * @package  Slim
 * @author   your name <username@gmail.com>
 * @license  https://licence.com GNU/GPLv3
 * @version  GIT: @1.0.0@
 * @link     https://yoursite.com
 */
use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Key\Factory\HierarchicalKeyFactory;
use BitWasp\Bitcoin\Network\NetworkFactory;

require '../vendor/autoload.php';

/**
 * Create wallet with id and xpub HD-wallet.
 *
 * @param int    $idx      index.
 * @param string $xpub     HD-wallet.
 * @param string $currency ex: bitcoin.
 * @param string $network  mainnet or testnet.
 *
 * @return json
 */
function createWallet($idx, $xpub, $currency, $network)
{

    $network_setting = $network;
    $project = $currency;

    $network_method = ('testnet' === $network_setting)?($project.'Testnet'):$project;
    try {
        $factory = new NetworkFactory();
        $network = $factory::$network_method();
        Bitcoin::setNetwork($network);
        $path = "0/".$idx;
        $xpub_key = $xpub;
        $keychain = new HierarchicalKeyFactory();
        $master = $keychain->fromExtended($xpub_key, $network);
        $publicKey = $master->derivePath($path)->getPublicKey(); 
        $address = new PayToPubKeyHashAddress($publicKey->getPubKeyHash()); 
        $address = $address->getAddress();// . PHP_EOL ;
    
        if ($address) {
            $r = $address;
        } else {
            $r = null;
        }
        return $r;
    } catch (Exception $e) {
        echo "except";
        echo $e->getMessage();
        return null;
    }
}
