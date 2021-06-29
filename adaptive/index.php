<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/*
 * Adaptive Local Plugin.
 *
 * Descrizione in Inglese del Plugin
 *
 * @package local_adaptive
 * @copyright 2014 Monopoli Giulio
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
 require_once(dirname(__FILE__) . '/../../config.php');
 
 //Se voglio importare una libreria personale ad esempio chiamata "locallib.php", devo creare il file "locallib.php" nella directory 
 //principale del plugin da me creato e inserire QUI questa stringa:
 //	require_once(dirname(__FILE__) . '/locallib.php');
 
 require_once($CFG->libdir . '/adminlib.php');
 
 /*
  * OPZIONALE:
  *
  * require_login();
  * $context = context_system::instance();
  * require_capability('report/customsql:view', $context);
 */
 
 admin_externalpage_setup('local_adaptive');

 //inserisco l'intestazione della pagina - DA LASCIARE COSI'
 echo $OUTPUT->header();
 
 global $DB;

 //creo il database se non esiste ancora:
 $sql1="CREATE TABLE IF NOT EXISTS mdl_tags
(
    idtag INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(25) NOT NULL,
    description VARCHAR(50),
    PRIMARY KEY (idtag)
)";
 $DB->execute($sql1,null);
 
 $sql2="CREATE TABLE IF NOT EXISTS mdl_assets
(
    idres INT NOT NULL,
    idtag INT NOT NULL,
    PRIMARY KEY (idres, idtag)
)";
 $DB->execute($sql2,null);
 
 $sql3="CREATE TABLE IF NOT EXISTS mdl_tagquestions
(
    idquest INT NOT NULL,
    idres INT NOT NULL,
    PRIMARY KEY (idquest, idres)
)";
 $DB->execute($sql3,null);
 
 // start the Homepage

echo '<h1> '.get_string('home', 'local_adaptive').' </h1>
	  <br/>
	  <br/>
	  <input class="pulsante" type="button" value="'.get_string('tagsButton', 'local_adaptive').'" name="bottone1" onclick="location.href=\'Tags_Manager.php\'"/>
	  <br/>
	  <input class="pulsante" type="button" value="'.get_string('assetsButton', 'local_adaptive').'" name="bottone2" onclick="location.href=\'Assets.php\'"/>
	  <br/>
	  <input class="pulsante" type="button" value="'.get_string('tagQuestion', 'local_adaptive').'" name="bottone3" onclick="location.href=\'Tag_Questions.php\'"/>
	  <br/>';
 

 //ends the page
 echo $OUTPUT->footer();
?>