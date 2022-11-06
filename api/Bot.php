<?php
include "Inbenta/Auth.php";
include "Inbenta/Conv.php";
include "Swapi/StarWars.php";
session_start();

class Bot {
	function sendMsg($msg) {
		//FORCE
		if (stripos($msg, "force") !== false) {
			$films = StarWars::getFilms();
			$filmsList = 'The <b>force</b> is in this movies:<br> <ul>';
		  	foreach ($films as $value) {
    			$filmsList .= '<li>'.$value.'</li>';
  			}
  			$filmsList .= '</ul>';
			return $filmsList;
		}

		//valid access token?
		if (!isset($_SESSION['access_token'], $_SESSION['access_token_expiration']) 
			|| time() > $_SESSION['access_token_expiration']) {
			$result = Auth::getAuthToken();
			$_SESSION['access_token'] = $result['accessToken'];
			$_SESSION['access_token_expiration'] = $result['expiration'];
		}

		//Conv token?
		if (!isset($_SESSION['session_token'])) {
			$_SESSION['session_token'] = Conv::getConversationToken($_SESSION['access_token']);
		}

		$res = Conv::sendMsg($_SESSION['access_token'], $_SESSION['session_token'], $msg);

		// NOT FOUND
		if (Conv::getTwoUnanswered($_SESSION['access_token'], $_SESSION['session_token']) > 1) {
			$people = StarWars::getPeople();
			$aleatorio = array_rand($people, 10);
			$peopleList = 'I haven\'t found any results, but here is a list of some Star Wars characters: <br/><ul>';
			foreach ($aleatorio as $value) {
    			$peopleList .= '<li>'.$people[$value].'</li>';
  			}

  			$peopleList .= '</ul>';
			return $peopleList;
		}
		
		return $res['message'];
	}
}		
?>
