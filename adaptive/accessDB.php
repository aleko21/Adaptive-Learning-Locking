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
 * Database Access Page
 *
 * @package local_adaptive
 * @copyright 2014 Monopoli Giulio
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
 require_once(dirname(__FILE__) . '/../../config.php');
 require_once($CFG->libdir . '/adminlib.php');

 // Start the page.
 admin_externalpage_setup('local_adaptive');
 echo $OUTPUT->header();
 
global $DB;     //set global database variable
	$msg;
	$pag;
    
    // the ADD button was pressed in the tags manager page
	if(isset($_POST['addButtonTag'])) {
	  	
		//user data (così posso fare controlli!)
		$insNameTg = $_POST["nameInputTag"];
		$insDescriptionTg = $_POST["descriptionInputTag"];
		
		//create SQL string
		$sql1="INSERT INTO {tags} (name, description) VALUES (?,?)";
		$DB->execute($sql1, array($insNameTg, $insDescriptionTg));
		
		//set the message
		$msg = get_string('tagaddSuccess', 'local_adaptive');
		$pag = 'Tags_Manager.php';
	}
	
	
	//the MODIFY button was pressed in the tags manager page
	if(isset($_POST['modifyButtonTag'])) {
		
		//user data
		$newNameTg = $_POST["newNameInputTag"];
		$newDescriptionTg = $_POST["newDescriptionInputTag"];
		$selTagTg = $_POST["tagsSel"];
		
		//create SQL string
		$sql2="UPDATE {tags} SET  name = ? , description = ? WHERE idtag = ?";
		$DB->execute($sql2, array($newNameTg, $newDescriptionTg, $selTagTg));
		
		//set the message
		$msg = get_string('tagmodifySuccess', 'local_adaptive');
		$pag = 'Tags_Manager.php';
	}
	
	
	//the DELETE button was pressed in the tags manager page
	if(isset($_POST['deleteButtonTag'])) {
		
		//user's selected tag
		$selectedTagTg = $_POST["tagsSel"];
		
		//create SQL string
		$sql3="DELETE FROM {tags} WHERE idtag = ?";
		$DB->execute($sql3, array($selectedTagTg));

		//set the message
		$msg = get_string('tagdeletedSuccess', 'local_adaptive');
		$pag = 'Tags_Manager.php';
	}
	
	
	//the ADD button was pressed in the Assets page
	if(isset($_POST['addButtonAs'])) {
		
		//retrieve selected resource's Id
		$selectedResAs = $_POST["resourcesAddAs"];
		
		//create SQL string
		$sql4="INSERT INTO {assets} (idres, idtag) VALUES ('".$selectedResAs."', ?)";
		
		foreach ($_POST["tagsAddAs"] as $select){
			$DB->execute($sql4, array($select));
		}
		
		//set the message
		$msg = get_string('assetaddSuccess', 'local_adaptive');
		$pag = 'Assets.php';
	}
	
	
	//the DELETE button was pressed in the Assets page
	if(isset($_POST['deleteButtonAs'])) {
		
		//retrieve selected resource's Id
		$selectedResAsD = $_POST["resourcesDelAs"];
		
		//create SQL string
		$sql5="DELETE FROM {assets} WHERE idres = '".$selectedResAsD."' AND idtag = ?";
		
		foreach($_POST["tagsDeleteAs"] as $selectD){
			$DB->execute($sql5, array($selectD));
		}
		
		//set the message
		$msg = get_string('assetdeletedSuccess', 'local_adaptive');
		$pag = 'Assets.php';
	}
	
	
	//the ADD button was pressed in the tagQuestions page
	if(isset($_POST['addButtonTQ'])) {
	   
	   	//retrieve selected question's Id
		$selectedQuest = $_POST["questionsAddSelTQ"];
		
		//create SQL string
		$sql6="INSERT INTO {tagquestions} (idquest, idres) VALUES ('".$selectedQuest."', ?)";
		
		foreach ($_POST["resourcesAddSelTQ"] as $select){
			$DB->execute($sql6, array($select));
		}
		
		//set the message
		$msg = get_string('tagquestionaddSuccess', 'local_adaptive');
		$pag = 'Tag_Questions.php';
	}
	
	
	//caso in cui sia stato premuto il pulsante DELETE nella pagina per la gestione delle tagQuestions
	if(isset($_POST['deleteButtonTQ'])) {
		
		//retrieve selected question's Id
		$selectedQuest = $_POST["questionsDelSelTQ"];
		$sql7="DELETE FROM {tagquestions} WHERE idquest= '".$selectedQuest."' AND idres = ?";
		
		foreach($_POST["resourcesDelSelTQ"] as $selectD){
			$DB->execute($sql7, array($selectD));
		}
		
		//set the message
		$msg = get_string('tagquestiondeleteSuccess', 'local_adaptive');
		$pag = 'Tag_Questions.php';
	}
 
//print the message 
echo $msg;
echo '<br/><br/><input type="button" value="Back" onclick="location.href=\''.$pag.'\'"/>';

 //ends the page
 echo $OUTPUT->footer();
?>