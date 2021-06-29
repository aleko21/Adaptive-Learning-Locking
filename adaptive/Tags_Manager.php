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
 * Tags Manager Page
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
 
global $DB;

echo '<h1>'.get_string('tagsManagerTitle', 'local_adaptive').'</h1>
      <br/>
      <div class="container">
        <form name="addTagForm" action="accessDB.php" method="post">
            <fieldset>
                <legend>'.get_string('addTagTitle', 'local_adaptive').'</legend>
                <p>
                    <label for="nameInputTag"> '.get_string('name', 'local_adaptive').': </label> <input name="nameInputTag" type="text"><br>
                	<label for="descriptionInputTag"> '.get_string('description', 'local_adaptive').': </label> <input name="descriptionInputTag" type="text"><br>
                	<br />
                	<input type="submit" name="addButtonTag" value="'.get_string('addButton', 'local_adaptive').'"/>
               </p> 
            </fieldset>
        </form>
        
    </div>';
 
echo '<div class="container">
    
    	<form name="ModifyOrDeleteTagForm" action="accessDB.php" method="post">
        	
            <fieldset>
            
            	<legend>'.get_string('modifyordeleteTitle', 'local_adaptive').'</legend>
                <p>
                	<select name="tagsSel" size="10">';
                    
                	$sql="SELECT * FROM {tags}";
 			$rs= $DB->get_recordset_sql($sql, null, $limitfrom=0, $limitnum=0);

  					foreach ($rs as $res){
						$id = $res->idtag;             
						$name = $res->name;	
						echo '<option value="'.$id.'">'.$name.'</option>';								  
					}
                        
            echo	'</select><br />
                    <br />
                    '.get_string('newNameLabel', 'local_adaptive').':<br />
                    <input name="newNameInputTag" type="text"/><br />
                    <br />
                    '.get_string('newDescriptionLabel', 'local_adaptive').':<br />
                    <input name="newDescriptionInputTag" type="text"/><br>
                    <br />
                    <input name="modifyButtonTag" type="submit" value="'.get_string('modifyButton', 'local_adaptive').'" /> 
                    <input name="deleteButtonTag" type="submit" value="'.get_string('deleteButton', 'local_adaptive').'" />
                </p>	
            </fieldset>
        </form>
        
    </div>';

echo '<br/><br/><input type="button" value="'.get_string('homeButton', 'local_adaptive').'" onclick="location.href=\'index.php\'"/>';

 //ends the page
 echo $OUTPUT->footer();
?>