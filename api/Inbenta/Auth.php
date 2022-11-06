<?php
require_once __DIR__.'/../Curl.php';

class Auth {
	const URL = 'https://api.inbenta.io/v1/auth';
	const KEY = 'nyUl7wzXoKtgoHnd2fB0uRrAv0dDyLC+b4Y6xngpJDY=';
  const SECRET = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJwcm9qZWN0IjoieW9kYV9jaGF0Ym90X2VuIn0.anf_eerFhoNq6J8b36_qbD4VqngX79-yyBKWih_eA1-HyaMe2skiJXkRNpyWxpjmpySYWzPGncwvlwz5ZRE7eg';

  public static function getAuthToken() {
		$result = Curl::post(
  		self::URL,
  		array(
				'x-inbenta-key: '.self::KEY,
				'Content-Type: application/json'
  		),
  		array(
  			'secret' => self::SECRET
  		)
  	);

  	$res = json_decode($result);

  	return array(
      'accessToken' => $res->accessToken,
      'expiration' => $res->expiration
  	);
  }
}

?>
