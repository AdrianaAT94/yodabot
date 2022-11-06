<?php
require_once __DIR__ . '/../Curl.php';

class StarWars {
	const URL = 'https://inbenta-graphql-swapi-prod.herokuapp.com/api/';

  public static function getFilms() {
		$result = Curl::getC(
  		self::URL,
      array('Content-Type: application/json'),
      array("query"=> '{allFilms{films{title}}}')
  	);

  	$res = json_decode($result, true);
    $res = $res['data']['allFilms']['films'];
  	return array_column($res, 'title');
  }

  public static function getPeople() {
		$result = Curl::getC(
  		self::URL,
  		array('Content-Type: application/json'),
  		array("query"=> '{allPeople{people{name}}}')
  	);

  	$res = json_decode($result, true);
    $res = $res['data']['allPeople']['people'];
  	return array_column($res, 'name');
  }
}

?>
