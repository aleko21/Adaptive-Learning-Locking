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
 * TagQuestion Page
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
 
echo '<script src="functionsFile.js" ></script>';
global $DB;
echo '<h1> '.get_string('tagsQuestionTitle', 'local_adaptive').' </h1>
      <div class="container">
        <form action="accessDB.php" method="post" name="addtagQuestionForm">
            <fieldset>
                <legend>ADD tagQUESTION</legend>
                <p>
					'.get_string('question', 'local_adaptive').': <br>
                	<select name="questionsAddSelTQ" id="questionsAddSelTQ" onChange="javascript:popolaElemento(\'availableRes\', \'popolaAddtagQ.php\', \'get\', \'id_cat=\'+this.value);">';
					
					$sql="SELECT id, name
							FROM {question}";
							
					$rs= $DB->get_recordset_sql($sql, null, $limitfrom=0, $limitnum=0);
					
					foreach ($rs as $res){
						$id =	$res->id;             
						$name = $res->name;	
						echo "<option value='".$id."'> ".$name." </option>";							  
					}
					
            		echo '</select>
                    <br/>
                    '.get_string('availableResources', 'local_adaptive').':<br>
			<span id="availableRes">
                	<select name="resourcesAddSelTQ[]" id="resourcesAddSelTQ" size="5" MULTIPLE >
            		</select><br/>
                    <br />
                	<input type="submit" name="addButtonTQ" value="'.get_string('addButton', 'local_adaptive').'"/>
                </p>
                
            </fieldset>
        </form>
    </div>';

echo '<div class="container">
        <form action="accessDB.php" method="post" name="deletetagQuestionForm">        	
            <fieldset>            
                <legend>'.get_string('existingtagQuestion', 'local_adaptive').'</legend>               
                <p>
					'.get_string('questions', 'local_adaptive').':<br>
                	<select name="questionsDelSelTQ" id="questionsDelSelTQ" onChange="javascript:popolaElemento(\'availableRes2\', \'popolaModDeltagQ.php\', \'get\', \'id_cat=\'+this.value);">';                    	
                        $sql2="SELECT id, name
							FROM {question}";
							
					$rs2= $DB->get_recordset_sql($sql2, null, $limitfrom=0, $limitnum=0);
					
					foreach ($rs2 as $res2){
						$id2 =	$res2->id;             
						$name2 = $res2->name;	
						echo "<option value='".$id2."'> ".$name2." </option>";							  
					}                      
            		echo '</select>
                    <br/>
                    '.get_string('availableResources', 'local_adaptive').':<br>
			<span id="availableRes2">
                	<select name="resourcesDelSelTQ[]" id="resourcesDelSelTQ" size="5" MULTIPLE >                                            
            		</select><br/>
                    <br />
                	<input name="deleteButtonTQ" type="submit" value="'.get_string('deleteButton', 'local_adaptive').'" />
                </p>                
            </fieldset>
        </form>
    </div>';

echo '<br/><br/><input type="button" value="'.get_string('homeButton', 'local_adaptive').'" onclick="location.href=\'index.php\'"/>';
 
 //ends the page
 echo $OUTPUT->footer();
?>