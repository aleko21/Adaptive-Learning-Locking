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
 * Assets Page
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
echo '<h1> '.get_string('assetsTitle', 'local_adaptive').' </h1>
      <br>
      <div class="container">
        <form action="accessDB.php" method="post" name="addAssetForm">
            <fieldset>
                <legend>'.get_string('addAssetTitle', 'local_adaptive').'</legend>
                <p>
					Resources:<br>
                	<select name="resourcesAddAs" id="resourcesSel" onChange="javascript:popolaElemento(\'availableTags\', \'popolaAddAssets.php\', \'get\', \'id_cat=\'+this.value);">';
                        
						$sql="SELECT coumd.id,
	  						c.shortname AS name,
	  						m.name AS tab,
							coumd.instance
	  						FROM {course_modules} coumd
	  						JOIN {modules} m ON coumd.module = m.id
	  						JOIN {course} c ON coumd.course = c.id
	  						ORDER BY name";
						
						$rs= $DB->get_recordset_sql($sql, null, $limitfrom=0, $limitnum=0);
						foreach ($rs as $res){
							
							$id=$res->id;
							$cours=$res->name;
							$tabl=$res->tab;
							$instance=$res->instance;
							
							$sql2="SELECT name AS na 
							FROM {".$tabl."}
							WHERE id = ?";
							
							//sarà solo uno!!
							$rs2= $DB->get_recordset_sql($sql2, array($instance), $limitfrom=0, $limitnum=1);
							foreach ($rs2 as $res2){
								$na = $res2->na;
								echo'<option value="'.$id.'">'.$cours.' - '.$na.'</option>';
							}
							
						}

            		echo '</select>
                    <br>
                    '.get_string('availableTags', 'local_adaptive').':<br>
			<span id="availableTags">
                	<select name="tagsAddAs[]" id="tagsSel" size="5" MULTIPLE>
            		</select><br/>
                    <br />
                	<input type="submit" name="addButtonAs" value="'.get_string('addButton', 'local_adaptive').'"/>
                </p>
            </fieldset>
        </form>
    </div>';
 
echo '<div class="container">
        <form action="accessDB.php" method="post" name="deleteAssetForm">
            <fieldset>
                <legend>'.get_string('existingAssets', 'local_adaptive').'</legend>
                <p>
					Resources:<br>
                	<select name="resourcesDelAs" id="resourcesSel" onChange="javascript:popolaElemento(\'availableTags2\', \'popolaModDelAssets.php\', \'get\', \'id_cat=\'+this.value);">';
					
                    	$sql="SELECT coumd.id,
	  						c.shortname AS name,
	  						m.name AS tab,
							coumd.instance
	  						FROM {course_modules} coumd
	  						JOIN {modules} m ON coumd.module = m.id
	  						JOIN {course} c ON coumd.course = c.id
	  						ORDER BY name";
						
						$rs= $DB->get_recordset_sql($sql, null, $limitfrom=0, $limitnum=0);
						foreach ($rs as $res){
							
							$id=$res->id;
							$cours=$res->name;
							$tabl=$res->tab;
							$instance=$res->instance;
							
							$sql2="SELECT name AS na 
							FROM {".$tabl."}
							WHERE id = ?";
							
							//sarà solo uno!!
							$rs2= $DB->get_recordset_sql($sql2, array($instance), $limitfrom=0, $limitnum=1);
							foreach ($rs2 as $res2){
								$na = $res2->na;
								echo'<option value="'.$id.'">'.$cours.' - '.$na.'</option>';
							}
							
						}
						
            		echo '</select>
                    <br>
                    '.get_string('relatedTags', 'local_adaptive').':<br>
			<span id="availableTags2">
                	<select name="tagsDeleteAs[]" id="tagsSel" size="5" MULTIPLE>
            		</select><br/>
                    <br />
                	<input name="deleteButtonAs" type="submit" value="'.get_string('deleteButton', 'local_adaptive').'" />
                </p>
            </fieldset>
        </form>
    </div>';

echo '<br/><br/><input type="button" value="'.get_string('homeButton', 'local_adaptive').'" onclick="location.href=\'index.php\'"/>';

  //ends the page
 echo $OUTPUT->footer();
?>