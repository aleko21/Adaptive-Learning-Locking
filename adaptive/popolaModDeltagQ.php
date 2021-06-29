<?php

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');

	global $DB;
	echo '<select name="resourcesDelSelTQ[]" id="resourcesDelSelTQ" size="5" MULTIPLE >';
	
	$sql="SELECT cm.id, c.shortname, m.name, cm.instance
		FROM {tagquestions} t
		JOIN {course_modules} cm ON t.idres = cm.id
		JOIN {course} c ON cm.course = c.id
		JOIN {modules} m ON cm.module = m.id
		WHERE t.idquest = ?
		ORDER BY c.shortname";
		
	$rs= $DB->get_recordset_sql($sql, array($_GET["id_cat"]), $limitfrom=0, $limitnum=0);
	
	foreach ($rs as $res){
							
		$id=$res->id;
		$cours=$res->shortname;
		$tabl=$res->name;
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
	echo '</select><br/>
                    <br />
                	<input name="deleteButtonTQ" type="submit" value="DELETE" />
                </p>                
            </fieldset>
        </form>
    </div>';
?>