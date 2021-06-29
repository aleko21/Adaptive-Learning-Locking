<?php

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');

	global $DB;
	echo '<select name="tagsDeleteAs[]" id="tagsSel" size="5" MULTIPLE>';
	
	$sql="SELECT t.idtag, t.name
	FROM {assets} a
	JOIN {tags} t ON a.idtag=t.idtag
	WHERE a.idres = ?";
	
	$rs= $DB->get_recordset_sql($sql, array($_GET["id_cat"]), $limitfrom=0, $limitnum=0);
	
	foreach ($rs as $res){
			$id =	$res->idtag;             
			$name = $res->name;	
			echo "<option value='".$id."'> ".$name." </option>";							  
		}
	echo '</select><br/>
                    <br />
                	<input name="deleteButtonAs" type="submit" value="DELETE" />
                </p>
            </fieldset>
        </form>
    </div>'; 
?>