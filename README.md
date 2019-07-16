# HD Wallet Generator (HD-WG)

<!-- [![N|Solid](https://cldup.com/dTxpPi9lDf.thumb.png)](https://nodesource.com/products/nsolid) -->

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)


HD-WG is a API that allows to generate the addresses derive from an xpub, since a url.
each call increases a counter and generates a new address.

- register one user and save token
- register one xpub and label
- call url api 
- Magic
 


# Requests! [URL_API] = http://104.238.181.82/walletGenerator/  

### [`POST`] create_user/
```javascript
var path = "create_user/";
let obj = {
    username : 'username',
    password : 'password',
    email : 'email',
    hash : '7afa0103f11f88526c4a10f4049e2f89'
}
```
#### RETURN : 
```javascript
{
    "success":true,
    "data":{
	    "token":"yourtoken"
    }
}
``` 
- remember save your token 

### [`POST`] authenticate/
```javascript
var path = "authenticate/";
let obj = {
    username : 'username',
    password : 'password'
}
```
#### RETURN : 
```javascript
{
    "success":true,
    "data":{
	    "token":"yourtoken"
    }
}
``` 


### [`POST`] add_data/
```javascript
var path = "add_data/";
let obj = {
    label : 'label',
    network : 'main||testnet',
    currency : 'btc',
    x_ : 'xpub||tpub'
}
```
#### RETURN : 
```javascript
{
    "success":true,
    "message":"datos se registraron con exito"
}
``` 


### [`POST`] get_data/
```javascript
var path = "get_data/";
```
#### RETURN : 
```javascript
{
    "success":true,
    "data":{
	    "username":"bitcoindonation",
	    "email":"bitcoindonation@gmail.com",
	    "id_user":"2",
	    "token":"077d2f2d63d9678f821ff45b028b04a62fe99be433216dda73dfc83f01f29c3a5f0b46921b126829df6eb58652e96636caf5b5f0ce678c1230e095186adb5559",
	    "data":[
		    {
		        "id_xpub":"4",
		        "currency":"bitcoin",
		        "symbol":"btc",
		        "label":"bitcoindonation",
		        "network":"main",
		        "xpub":"xpub6CbdFFLiL2zcDVK7Ua2aahsLyJfypG3nSnRc6Gkt6szumHaDoAzbrS3gQBLwKWbp7XEpheBUdXjSwssWywezSPuksbgxomdTCpT1vsEAR3G",
		        "status":"1",
		        "idx":"0"
		    }
		]
	}
}
``` 
- the idx is the index that leads in the generated wallets

### TO GENERATE WALLET

- does not need authentication only the user's token , currency and label

### [`GET`] get_wallet/token/currency/label

#### Example 

http://104.238.181.82/walletGenerator/get_wallet/077d2f2d63d9678f821ff45b028b04a62fe99be433216dda73dfc83f01f29c3a5f0b46921b126829df6eb58652e96636caf5b5f0ce678c1230e095186adb5559/btc/bitcoindonation

#### RETURN : 
```javascript
{
    "success": true,
    "data": {
	    "address": "13gbpLjNJXvZkCMoKmiVxH2XCPoPjgrxum",
	    "idx": 0
    }
}
```

License
----
Activos digitales



