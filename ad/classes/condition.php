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

/**
 * Condition main class.
 *
 * @package availability_ad
 * @copyright 2014 Monopoli Giulio
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace availability_ad;

defined('MOODLE_INTERNAL') || die();



/**
 * Condition main class.
 *
 * @package availability_ad
 * @copyright 2014 Monopoli Giulio
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class condition extends \core_availability\condition {

    /** @var string ID of language that this condition requires, or '' = any language */
    protected $languageid;
    protected $isNOTAvailable = false;

    /**
     * Constructor.
     *
     * @param \stdClass $structure Data structure from JSON decode
     * @throws \coding_exception If invalid data structure.
     */
    public function __construct($structure) {
    	
        // Get language id.
        if (!property_exists($structure, 'id')) {
            $this->languageid = '';
        } else if (is_string($structure->id)) {
            $this->languageid = $structure->id;
        } else {
            throw new \coding_exception('Invalid ->id for language condition');
        }
    }

    public function save() {
        $result = (object)array('type' => 'language');
        if ($this->languageid) {
            $result->id = $this->languageid;
        }
        return $result;
    }

    /**
     * Determines whether a particular item is currently available
     * according to this availability condition.
     *
     * @param bool $not Set true if we are inverting the condition
     * @param info $info Item we're checking
     * @param bool $grabthelot Performance hint: if true, caches information
     *   required for all course-modules, to make the front page and similar
     *   pages work more quickly (works only for current user)
     * @param int $userid User ID to check availability for
     * @return bool True if available
     */
    public function is_available($not, \core_availability\info $info, $grabthelot, $userid) {
        // This function needs to check whether the condition is true
        // or not for the user specified in $userid. If the condition
        // is true, $information should be set to an empty string. If
        // false, it should be set to a message.
		
		global $DB;
		
		//recupero le variabili di cui avro' subito bisogno!
		$courseID = $info->get_course()->id;
		$resourceID = $info->get_course_module()->id;
		
		//echo '</br> Sono entrato nella funzione is_available per la risorsa: '.$resourceID; //debug
		
		//variabili che devo trovare!
		$quizAttemptsId;
		$quizId;
		$relatedQuestionId;
		
		//recupero quizAttemptsId e quizId
		$sql = 'SELECT 
		qua.id AS quizAttemptsID,		
		qu.id AS quizID,			
		qua.userid,
		qu.course,
		qu.name,
		qua.timemodified
		FROM {quiz} qu
			JOIN {quiz_attempts} qua ON qu.id = qua.quiz
		WHERE qu.course = ? AND qua.userid = ?
		ORDER BY qua.timemodified DESC';

		$rs= $DB->get_recordset_sql($sql, array($courseID, $userid), $limitfrom=0, $limitnum=1);	//$limitnum = 1 perche' voglio solo la prima riga!!
		//var_dump($rs); 	//DEBUG
		//echo '</br> ho eseguito la prima query'; //debug
		
		//controllo che non sia vuota la tabella risultante, in questo caso esce dall'applicazione!
        if(!$rs->valid()){
            
            //echo '</br> purtroppo la tabella e vuota!!'; //debug
            $rs->close();
            $avail=true;
            $information = 'Nessun Record Trovato!! Dovrai studiare questa risorsa!';
            return $avail;
        }
        	
		//echo '</br>la tabella NON e vuota, quindi continuo!!'; //debug

		foreach ($rs as $res){
			
			$quizAttemptsId =	$res->quizattemptsid;            
			$quizId = $res->quizid;								  
		}
        
		$rs->close(); // Don't forget to close the recordset!
		
		//recupero relatedQuestionId
		$sql2= 'SELECT tg.idquest
				FROM {tagquestions} tg
				JOIN {quiz_slots} qs ON tg.idquest = qs.questionid
				WHERE qs.quizid = ? AND tg.idres= ?';
		
		$rs2= $DB ->get_recordset_sql($sql2, array($quizId, $resourceID), $limitfrom=0, $limitnum=0);   //limitnum=0 perchè ci possono essere più domande nello stesso quiz riferite alla risorsa attualmente considerata!!
		//var_dump($rs2); DEBUG
		
		//controllo che non sia vuota la tabella risultante, in questo caso esce dall'applicazione!
        if(!$rs2->valid()){

		//echo '</br> purtroppo anche questa tabella e vuota!!'; //debug
            
            $rs->close();
            $avail=true;
            $information = 'Nessun Record Trovato!! Dovrai studiare questa risorsa!';
            return $avail;
        }
		
		//ciclo sulle varie domande dell'ultimo quiz svolto per questo corso, che si riferiscono alla resource considerata!! (quindi che hanno un record nella tabella "tagquestion")
		foreach ($rs2 as $res2){

			//echo '</br> la seconda tabella NON era vuota e quindi inizio il ciclo!!'; //debug
			$relatedQuestionId = $res2->idquest;
			
			$sql3= 'SELECT
    				quiza.userid,
    				quiza.quiz,
    				quiza.id AS quizattemptid,
    				quiza.sumgrades,
    				qa.questionid,
    				qa.maxmark,
    				qa.minfraction,
    				qas.sequencenumber,
    				FROM_UNIXTIME(qas.timecreated) AS Date,
    				qas.userid,
    				qasd.VALUE,
    				qa.questionsummary,
    				qa.rightanswer,
    				qa.responsesummary
 
					FROM {quiz_attempts} quiza
						JOIN {question_usages} qu ON qu.id = quiza.uniqueid
						JOIN {question_attempts} qa ON qa.questionusageid = qu.id
						JOIN {question_attempt_steps} qas ON qas.questionattemptid = qa.id
						LEFT JOIN {question_attempt_step_data} qasd ON qasd.attemptstepid = qas.id
 
					WHERE qasd.name = ? AND quiza.id = ? AND qa.questionid = ?
					ORDER BY Date DESC';
			
			$rs3= $DB ->get_recordset_sql($sql3, array('-finish', $quizAttemptsId, $relatedQuestionId), $limitfrom=0, $limitnum=1);
			//var_dump($rs3); DEBUG			
			
			//controllo che non sia vuota la tabella risultante, in questo caso esce dall'applicazione!
            if(!$rs3->valid()){
            
                $rs->close();
                $avail=true;
                $information = 'Nessun Record Trovato!! Dovrai studiare questa risorsa!';
                return $avail;
            }
			
			//e' una sola riga!
			foreach($rs3 as $res3){
				
				$rightAnswer = $res3->rightanswer;
				$userAnswer = $res3->responsesummary;
				
				//strcasecmp() restituisce 0 SOLO se le due stringhe passate come parametro sono uguali (CASE INSENSITIVE!!)
				if(strcasecmp($rightAnswer, $userAnswer) == 0){
					//se le due stringhe sono uguali vuol dire che ha risposto CORRETTAMENTE e quindi NON gli serve studiare questa risorsa 
					//quindi NON deve 	essere accessibile!!
					
					$avail=false;
					$this -> isNOTAvailable=true;
					
					//echo 'NON devi studiarla!'; //debug
					
				}else{
					//ha risposto in maniera ERRATA e quindi DEVE essere ACCESSIBILE!!
					$avail=true;
					$this -> isNOTAvailable=false;
					//echo 'devi studiarla!'; //debug
				}
			}
			
			if($avail) break;	//BLOCCO il ciclo WHILE di $rs2 perche' tanto avendone sbagliata anche solo 1, si deve studiare quella risorsa!! 
		}
		
		//creo il messaggio se necessario
		/*if ($avail) {
			//echo '</br>avail e true!';
            $information = '';
        } else {
			//echo '</br>avail e false';
			//$not = false;
            $information = "Questa risorsa non e' disponibile in quanto lei conosce gia' tutto quello che e' spiegato al suo interno!";
        }
        */
		return $avail;
    }

    /**
     * Obtains a string describing this restriction (whether or not
     * it actually applies). Used to obtain information that is displayed to
     * students if the activity is not available to them, and for staff to see
     * what conditions are.
     *
     * @param bool $full Set true if this is the 'full information' view
     * @param bool $not Set true if we are inverting the condition
     * @param info $info Item we're checking
     * @return string Information string (for admin) about all restrictions on
     *   this item
     */
    public function get_description($full, $not, \core_availability\info $info) {
    	
       if($this -> isNOTAvailable){
       		$stringToShow = "Questa risorsa non e' disponibile in quanto lei conosce gia' tutto quello che e' spiegato al suo interno!";
       		return $stringToShow;
       }
       $adSI = "Da Studiare!";
       return $adSI;
    }

    /**
     * Obtains a representation of the options of this condition as a string,
     * for debugging.
     *
     * @return string Text representation of parameters
     */
    protected function get_debug_string() {
        return $this->languageid ? '' . $this->languageid : 'any';
    }
}

