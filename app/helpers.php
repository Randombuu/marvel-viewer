<?php
function getCharacterURL($character){
	
	$urls = [];
	if(!empty($character['urls'])){
		foreach($character['urls'] as $curl){
			$urls[$curl['type']] = $curl['url'];
		}
	}

	return (!empty($urls['wiki'])) ? $urls['wiki'] : '#';
}