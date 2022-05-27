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
 * This file contains the moodle hooks for the submission notes plugin
 *
 * @package   assignsubmission_assignmentnotes
 * @copyright &copy; 2022-onwards G J Barnard.
 * @author    G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// TODO: Not sure if this file is needed!

/**
 *
 * Callback method for data validation---- required method for AJAXmoodle based gradereview API
 *
 * @param stdClass $options
 * @return bool
 */
function assignsubmission_assignmentnotes_comment_validate(stdClass $options) {
    global $CFG, $DB;

    if (!$submission = $DB->get_record('assign_submission', array('id' => $options->itemid))) {
        throw new comment_exception('invalidgradereviewitemid');
    }

    require_once($CFG->dirroot . '/mod/assign/locallib.php');
    $context = $options->context;
    $assignment = new assign($context, null, null);

    if ($assignment->get_instance()->id != $submission->assignment) {
        throw new comment_exception('invalidcontext');
    }
    $canview = false;
    if ($submission->userid) {
        $canview = $assignment->can_view_submission($submission->userid);
    } else {
        $canview = $assignment->can_view_group_submission($submission->groupid);
    }
    if (!$canview) {
        throw new comment_exception('nopermissiontogradereview');
    }

    return true;
}

/**
 * Permission control method for submission plugin ---- required method for AJAXmoodle based gradereview API
 *
 * @param stdClass $options
 * @return array
 */
function assignsubmission_assignmentnotes_comment_permissions(stdClass $options) {
    global $CFG, $DB;

    if (!$submission = $DB->get_record('assign_submission', array('id' => $options->itemid))) {
        throw new comment_exception('invalidgradereviewitemid');
    }

    require_once($CFG->dirroot . '/mod/assign/locallib.php');
    $context = $options->context;
    $assignment = new assign($context, null, null);

    if ($assignment->get_instance()->id != $submission->assignment) {
        throw new comment_exception('invalidcontext');
    }

    if ($assignment->get_instance()->teamsubmission &&
        !$assignment->can_view_group_submission($submission->groupid)) {
        return array('post' => false, 'view' => false);
    }

    if (!$assignment->get_instance()->teamsubmission &&
        !$assignment->can_view_submission($submission->userid)) {
        return array('post' => false, 'view' => false);
    }

    return array('post' => false, 'view' => true);
}
