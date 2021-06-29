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
 * Capability definitions for the adaptive plugin.
 *
 * @package local_adaptive
 * @copyright 2014 Monopoli Giulio
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
 $capabilities = array(
 
	//persone che possono gestire (creare, modificare, cancellare) i tag associati ad una resource
	'local/adaptive:managetagresource' => array(
		'riskbitmask' => RISK_PERSONAL | RISK_DATALOSS | RISK_CONFIG,
		'captype' => 'write',
		'contextlevel' => CONTEXT_SYSTEM,
		'legacy' => array(
            )
        ),
		
	
	
	//persone che possono gestire (creare, modificare, cancellare) le resources associate ad una domanda
	'local/adaptive:manageresourcequestions' => array(
		'riskbitmask' => RISK_PERSONAL | RISK_DATALOSS | RISK_CONFIG,
		'captype' => 'write',
		'contextlevel' => CONTEXT_SYSTEM,
		'legacy' => array(
            )
        ),
		
		
		
	//persone che possono gestire (creare, modificare, cancellare) le condizioni di accesso basate sui tag
	'local/adaptive:managetagaccessconditions' => array(
		'riskbitmask' => RISK_PERSONAL | RISK_DATALOSS | RISK_CONFIG,
		'captype' => 'write',
		'contextlevel' => CONTEXT_SYSTEM,
		'legacy' => array(
            )
        )
	
 );
 
 ?>
 