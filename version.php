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
 * This file contains the version information for the notes submission plugin
 *
 * @package   assignsubmission_assignmentnotes
 * @copyright &copy; 2022-onwards G J Barnard.
 * @author    G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2022050803;
$plugin->supported = array(29, 400);
$plugin->requires  = 2014111000;
$plugin->component = 'assignsubmission_assignmentnotes';
$plugin->maturity = MATURITY_STABLE;
$plugin->release = '0.0.4 (Build: 2022050803)';
