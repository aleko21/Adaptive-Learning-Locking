<?php

require_once(dirname(__FILE__) . '/../../config.php');
 require_once($CFG->libdir . '/adminlib.php');

	global $DB;
	$idTaken = $_GET["id_cat"];
	
	$sql="SELECT t.idtag, t.name
	FROM {tags} t
	WHERE t.idtag NOT IN ( SELECT a.idtag
							FROM {assets} a
							WHERE a.idres = ? )";
	
	
	$rs3= $DB->get_recordset_sql($sql, array($idTaken), $limitfrom=0, $limitnum=0);

	echo '<select name="tagsAddAs[]" id="tagsSel" size="5" MULTIPLE>';
	foreach ($rs3 as $res){
			$id3 =	$res->idtag;             
			$name3 = $res->name;	
			echo "<option value='".$id3."'> ".$name3." </option>";							  
		}
	echo '</select> <br />
                	<input type="submit" name="addButtonAs" value="ADD"/>
                </p>
            </fieldset>
        </form>
    </div>'; 	
?>