Introduction
============
Assignment notes.

Adds the ability to add user specific assign submission notes for markers via the custom user profile fields
'submission_note'(Checkbox type) and 'submission_note_details'(Text area type), that must be created by the Administrator.

About
=====
Copyright  &copy; 2022-onwards G J Barnard.
Author     G J Barnard - http://about.me/gjbarnard and http://moodle.org/user/profile.php?id=442195
License    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.

Developed and maintained by
===========================
G J Barnard MSc. BSc(Hons)(Sndw). MBCS. CEng. CITP. PGCE.
Moodle profile | http://moodle.org/user/profile.php?id=442195
Web profile | http://about.me/gjbarnard

Free Software
=============
Assignment notes is 'free' software under the terms of the GNU GPLv3 License, please see 'LICENSE'.

It can be obtained for free from:
https://github.com/gjb2048/moodle-assignsubmission_notes/releases

You have all the rights granted to you by the GPLv3 license.  If you are unsure about anything, then the
FAQ - www.gnu.org/licenses/gpl-faq.html - is a good place to look.

Support
=======
The plugin is licensed under the GNU GPLv3 License and comes with NO support.

Required version of Moodle
==========================
This version works with Moodle 2.9 to Moodle 3.11 version 2021051700.00 (Build: 20210517) and above within the 3.11 branch.

Please ensure that your hardware and software complies with 'Requirements' in 'Installing Moodle' such as
'docs.moodle.org/311/en/Installing_Moodle'.

Installation
============
 1. Ensure you have the version of Moodle as stated above in 'Required version of Moodle'.  This is essential as the
    filter relies on underlying core code that is out of my control.
 2. Login as an administrator and put Moodle in 'Maintenance Mode' so that there are no users using it bar you as the administrator.
 3. Copy the extracted 'notes' folder to the '/mod/assign/submission/' folder.
 4. Go to 'Site administration' -> 'Notifications' and follow standard the 'plugin' update notification.
 5. Put Moodle out of Maintenance Mode.
 6. Create the custom user profile fields 'submission_note'(Checkbox type) and 'submission_note_details'(Text area type).
 7. Populate / set the custom user profile fields on a per user basis as required.
 8. It is recommended that notes are ordered immediately above "File Submissions" in the assignment submission plugins
    (Site administration -> Plugins -> Activity modules -> Assignment -> Submission plugins -> Manage assignment submission plugins).
    This will place the notes next to the file where marking will be accessed.

Upgrading
=========
 1. Ensure you have the version of Moodle as stated above in 'Required version of Moodle'.  This is essential as the
    filter relies on underlying core code that is out of my control.
 2. Login as an administrator and put Moodle in 'Maintenance Mode' so that there are no users using it bar you as the administrator.
 3. Make a backup of your old 'notes' folder in '/mod/assign/submission/' and then delete the folder.
 4. Copy the replacement extracted 'notes' folder to the '/mod/assign/submission/' folder.
 5. Go to 'Site administration' -> 'Notifications' and follow standard the 'plugin' update notification.
 6. If automatic 'Purge all caches' appears not to work by lack of display etc. then perform a manual 'Purge all caches'
    under 'Home -> Site administration -> Development -> Purge all caches'.
 7. Put Moodle out of Maintenance Mode.

Uninstallation
==============
 1. Put Moodle in 'Maintenance Mode' so that there are no users using it bar you as the administrator.
 2. Go to Site administration -> Plugins -> Activity modules -> Assignment -> Submission plugins -> Manage assignment submission plugins.
 3. Click on 'Uninstall' and follow the on screen instructions.
 4. Put Moodle out of Maintenance Mode.

Reporting Issues
================
Before reporting an issue, please ensure that you are running the current version for your release of Moodle.  It is essential
that you are operating the required version of Moodle as stated at the top - this is because the plugin relies on core
functionality that is out of its control.

It is essential that you provide as much information as possible, the critical information being the contents of the plugin's
version.php file.  Other version information such as specific Moodle version, theme name and version also helps.  A screen shot
can be really useful in visualising the issue along with any files you consider to be relevant.

Report issues on: https://github.com/gjb2048/moodle-assignsubmission_notes/issues

Version Information
===================
See Changes.md

Me
==
G J Barnard MSc. BSc(Hons)(Sndw). MBCS. CEng. CITP. PGCE.
Moodle profile: http://moodle.org/user/profile.php?id=442195
Web profile   : http://about.me/gjbarnard