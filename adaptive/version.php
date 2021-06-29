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
 * version.php file for the adaptive plugin
 *
 * @package local_adaptive
 * @copyright 2014 Monopoli Giulio
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
 defined('MOODLE_INTERNAL') || die();
 
 //version of the plugin (08 January 2015 - 06)
 $plugin->version  = 2014102106;
 
 //requires this moodle version
 $plugin->requires = 2012120300;	//moodle 2.4 - 3 December 2012
 
 $plugin->cron = 300;

 //full name of the plugin
 $plugin->component = 'local_adaptive';
 
 $plugin->maturity = MATURITY_BETA;	//in date 08/01/2015
 
 $plugin->release = 'v2.4-r1';			//revision 1 for Moodle 2.4+
?>