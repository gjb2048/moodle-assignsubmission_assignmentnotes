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
 * @package   assignsubmission_notes
 * @copyright &copy; 2022-onwards G J Barnard.
 * @author    G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

/**
 *
 * Callback method for data validation---- required method for AJAXmoodle based gradereview API
 *
 * @param stdClass $options
 * @return bool
 */
function assignsubmission_notes_comment_validate(stdClass $options) {
    global $CFG, $DB;

    if ($options->commentarea != 'submission_notes' &&
        $options->commentarea != 'submission_notes_upgrade') {
        throw new comment_exception('invalidcommentarea');
    }
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
function assignsubmission_notes_comment_permissions(stdClass $options) {
    global $CFG, $DB;

    if ($options->commentarea != 'submission_notes' &&
        $options->commentarea != 'submission_notes_upgrade') {
        throw new comment_exception('invalidcommentarea');
    }
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

/**
 * Callback called by gradereview::get_gradereviews() and gradereview::add().  Gives an opportunity to enforce blind-marking.
 *
 * @param array $gradereviews
 * @param stdClass $options
 * @return array
 * @throws comment_exception
 */
function assignsubmission_notes_comment_display($gradereviews, $options) {
    global $CFG, $DB;

    if ($options->commentarea != 'submission_notes' &&
        $options->commentarea != 'submission_notes_upgrade') {
        throw new comment_exception('invalidcommentarea');
    }
    if (!$submission = $DB->get_record('assign_submission', array('id' => $options->itemid))) {
        throw new comment_exception('invalidgradereviewitemid');
    }
    $context = $options->context;
    $cm = $options->cm;
    $course = $options->courseid;

    require_once($CFG->dirroot . '/mod/assign/locallib.php');
    $assignment = new assign($context, $cm, $course);

    if ($assignment->get_instance()->id != $submission->assignment) {
        throw new comment_exception('invalidcontext');
    }
   
    $gradereviews = array();
    $testreview = new stdClass();
    $testreview->id = 1;
    $testreview->content = '<div class="no-overflow"><div class="text_to_html">Testing is go</div></div>';
    $gradereviews[] = $testreview;

    error_log(print_r($gradereviews, true));


    return $gradereviews;
}

/**
 * Callback to force the userid for all gradereviews to be the userid of the submission and NOT the global $USER->id. This
 * is required by the upgrade code.  Note the gradereview area is used to identify upgrades.
 *
 * @param stdClass $gradereview
 * @param stdClass $param
 */
function assignsubmission_notes_comment_add(stdClass $gradereview, stdClass $param) {

    global $DB;
    if ($gradereview->commentarea == 'submission_notes_upgrade') {
        $submissionid = $gradereview->itemid;
        $submission = $DB->get_record('assign_submission', array('id' => $submissionid));

        $gradereview->userid = $submission->userid;
        $gradereview->commentarea = 'submission_notes';
    }
}

