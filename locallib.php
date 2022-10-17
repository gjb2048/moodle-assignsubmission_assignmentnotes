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
 * This file contains the definition for the library class for the notes submission plugin
 *
 * @package   assignsubmission_assignmentnotes
 * @copyright &copy; 2022-onwards G J Barnard.
 * @author    G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/mod/assign/submissionplugin.php');
require_once($CFG->dirroot.'/user/lib.php');

/**
 * Library class for notes submission plugin extending submission plugin base class
 *
 * @package assignsubmission_notes
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class assign_submission_assignmentnotes extends assign_submission_plugin {

    /**
     * Get the name of the assignment notes submission plugin
     * @return string
     */
    public function get_name() {
        return get_string('pluginname', 'assignsubmission_assignmentnotes');
    }

    /**
     * Display the note.
     *
     * @param stdClass $submission
     * @param bool $showviewlink
     * @return string
     */
    public function view_summary(stdClass $submission, &$showviewlink) {
        // Never show a link to view full submission.
        $showviewlink = false;

        if (empty($submission->userid)) {
            $templatecontext = new stdClass;
            $templatecontext->note = get_string('group_note', 'assignsubmission_assignmentnotes');
            $templatecontext->notedetails = get_string('group_notedetails', 'assignsubmission_assignmentnotes');

            return $this->assignment->get_renderer()->render_from_template(
                'assignsubmission_assignmentnotes/note', $templatecontext);
        }

        list ($course, $cm) = get_course_and_cm_from_instance($submission->assignment, 'assign');
        $theuser = \core_user::get_user($submission->userid);
        $userdetails = user_get_user_details($theuser, $course);

        $o = '';
        if (!empty($userdetails['customfields'])) {
            $searcharray = array();
            foreach ($userdetails['customfields'] as $cfield) {
                $searcharray[$cfield['shortname']] = $cfield;
            }

            if (array_key_exists('submission_assignmentnotes', $searcharray)) {
                $rendernote = true;
                $templatecontext = new stdClass;
                if (empty($searcharray['submission_assignmentnotes']['value'])) {
                    $templatecontext->note = false;
                    $rendernote = get_config('assignsubmission_assignmentnotes', 'indicatenonote');
                } else {
                    $templatecontext->note = $searcharray['submission_assignmentnotes']['name'];
                    if (!empty($searcharray['submission_assignmentnotes_details']['value'])) {
                        $templatecontext->notedetails = str_replace(array("\r", "\n"), '',
                            $searcharray['submission_assignmentnotes_details']['value']);
                        $notesummary = format_string($templatecontext->notedetails);
                        $templatecontext->notedetailssummary = mb_strimwidth($notesummary, 0, 200, "...", 'utf-8');
                    }
                }
                if ($rendernote) {
                    $o = $this->assignment->get_renderer()->render_from_template('assignsubmission_assignmentnotes/note', $templatecontext);
                }
            }
        } else {
            $o = '-';
        }

        return $o;
    }

    /**
     * Always return true because the submission notes are not part of the submission form.
     *
     * @param stdClass $submission
     * @return bool
     */
    public function is_empty(stdClass $submission) {
        return true;
    }

    /**
     * Return true if this plugin can upgrade an old Moodle 2.2 assignment of this type
     * and version.
     *
     * @param string $type old assignment subtype
     * @param int $version old assignment version
     * @return bool True if upgrade is possible
     */
    public function can_upgrade($type, $version) {
        if ($type == 'upload' && $version >= 2011112900) {
            return true;
        }
        return false;
    }


    /**
     * Upgrade the settings from the old assignment to the new plugin based one
     *
     * @param context $oldcontext - the context for the old assignment
     * @param stdClass $oldassignment - the data for the old assignment
     * @param string $log - can be appended to by the upgrade
     * @return bool was it a success? (false will trigger a rollback)
     */
    public function upgrade_settings(context $oldcontext, stdClass $oldassignment, & $log) {
        if ($oldassignment->assignmenttype == 'upload') {
            // Disable if allow notes was not enabled.
            if (!$oldassignment->var2) {
                $this->disable();
            }
        }
        return true;
    }

    /**
     * Upgrade the submission from the old assignment to the new one
     *
     * @param context $oldcontext The context for the old assignment
     * @param stdClass $oldassignment The data record for the old assignment
     * @param stdClass $oldsubmission The data record for the old submission
     * @param stdClass $submission The new submission record
     * @param string $log Record upgrade messages in the log
     * @return bool true or false - false will trigger a rollback
     */
    public function upgrade(
        context $oldcontext,
        stdClass $oldassignment,
        stdClass $oldsubmission,
        stdClass $submission,
        &$log) {
        return true;
    }

    /**
     * The submission notes plugin has no submission component so should not be counted
     * when determining whether to show the edit submission link.
     * @return boolean
     */
    public function allow_submissions() {
        return false;
    }

    /**
     * Automatically enable or disable this plugin based on "$CFG->gradereviewsenabled"
     *
     * @return bool
     */
    public function is_enabled() {
        return true;
    }

    /**
     * Automatically hide the setting for the submission plugin.
     *
     * @return bool
     */
    public function is_configurable() {
        return false;
    }
}
