# xpubWalletGenerator

url : http://104.238.181.82/walletGenerator/

API that allows to generate wallets from an xpub

allows adding users and xpub with a label for their subsequent request

at this time it only accepts btc main and testnet

--the process is the following

--must register a user

/*create_user*/


http://104.238.181.82/walletGenerator/create_user/


method : POST 

{

	username : 'username',
	password : 'password',
	email : 'email',
	hash : '7afa0103f11f88526c4a10f4049e2f89'

}


return : 

{

	"success":true,
	"data":{
		"token":"yourtoken"
	}

}

/*authenticate*/

http://104.238.181.82/walletGenerator/authenticate/

method : POST

{

	username : 'username',
	password : 'password'

}

return : 

{

	"success":true,
	"data":{
		"token":"yourtoken"
	}

}


--the api has 3 functions

http://104.238.181.82/walletGenerator/add_data/

add_data -> add the information * must be authenticated *

method : POST 

{

	label : 'label',
	network : 'main||testnet',
	currency : 'btc',
	x_ : 'xpub||tpub'

}

return : 

{

	"success":true,
	"message":"datos se registraron con exito"

}

http://104.238.181.82/walletGenerator/get_data/

get_data -> get the user information * must be authenticated *

method : POST

return : 

{

	"success":true,
	"data":{
		"username":"bitcoindonation",
		"email":"bitcoindonation@gmail.com",
		"id_user":"2",
		"token":"077d2f2d63d9678f821ff45b028b04a62fe99be433216dda73dfc83f01f29c3a5f0b46921b126829df6eb58652e96636caf5b5f0ce678c1230e095186adb5559",
		"data":[
			{"id_xpub":"4",
			"currency":"bitcoin",
			"symbol":"btc",
			"label":"bitcoindonation",
			"network":"main",
			"xpub":"xpub6CbdFFLiL2zcDVK7Ua2aahsLyJfypG3nSnRc6Gkt6szumHaDoAzbrS3gQBLwKWbp7XEpheBUdXjSwssWywezSPuksbgxomdTCpT1vsEAR3G",
			"status":"1",
			"idx":"0"}
			]
		}

}

-- the idx is the index that leads in the generated wallets



#TO GENERATE A WALLET


-- does not need authentication only the user's token , currency and label

METHOD : GET

http://104.238.181.82/walletGenerator/get_wallet/token/currency/label

http://104.238.181.82/walletGenerator/get_wallet/077d2f2d63d9678f821ff45b028b04a62fe99be433216dda73dfc83f01f29c3a5f0b46921b126829df6eb58652e96636caf5b5f0ce678c1230e095186adb5559/btc/bitcoindonation

{
	
	success: true,
	data: {
		address: "13gbpLjNJXvZkCMoKmiVxH2XCPoPjgrxum",
		idx: "0"
	}

}


-- at this time only btc (bitcoin) is allowed as currency


donation generate wallet in 

http://104.238.181.82/walletGenerator/get_wallet/077d2f2d63d9678f821ff45b028b04a62fe99be433216dda73dfc83f01f29c3a5f0b46921b126829df6eb58652e96636caf5b5f0ce678c1230e095186adb5559/btc/bitcoindonation
