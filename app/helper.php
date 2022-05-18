<?php

function isActive($nav1, $nav2){
	return $nav1 == $nav2;
}

function isActiveNav($nav1, $nav2){
	if($nav1 == $nav2){
		return 'active';
	}
	return '';
}