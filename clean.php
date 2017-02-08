<?php
/*
Copyright (c) 2016 ZettaScript, Pascal Engélibert
This file is part of ATTCHAR.

	ATTCHAR is free software: you can redistribute it and/or modify
	it under the terms of the GNU Lesser General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	ATTCHAR is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU Lesser General Public License for more details.

	You should have received a copy of the GNU Lesser General Public License
	along with ATTCHAR.  If not, see <http://www.gnu.org/licenses/>.
*/

try {$bdd = new PDO('mysql:host=localhost;dbname=database;charset=utf8', 'user', 'password');}
catch(Exception $e) {die('Erreur : ' . $e->getMessage());}

// nettoyer la table
$req = $bdd->prepare('DELETE FROM attchar WHERE expire < ?');
$req->execute(array(time()));
?>
