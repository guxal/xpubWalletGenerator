<?php
/**
 * Modulo Wallet
 * php version 7.0.33
 
 * @category Components
 * @package  Slim
 * @author   guxal <jonathanacp93@gmail.com>
 * @license  https://licence.com GNU/GPLv3
 * @version  GIT: @1.0.0@
 * @link     https://github.com
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
 * @return string address or null.
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
    
        return $address;
    } catch (Exception $e) {
        //  echo $e->getMessage();
        return null;
    }
}
