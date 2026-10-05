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
 * Restore task for mod_trigonometry.
 *
 * @package   mod_trigonometry
 * @category  backup
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/trigonometry/backup/moodle2/restore_trigonometry_stepslib.php');

/**
 * Provides the steps to restore a Trigonometry activity.
 */
class restore_trigonometry_activity_task extends restore_activity_task {
    protected function define_my_settings() {
    }

    protected function define_my_steps() {
        $this->add_step(
            new restore_trigonometry_activity_structure_step('trigonometry_structure', 'trigonometry.xml')
        );
    }

    public static function define_decode_contents() {
        return [
            new restore_decode_content('trigonometry', ['intro'], 'trigonometry'),
        ];
    }

    public static function define_decode_rules() {
        return [
            new restore_decode_rule(
                'TRIGONOMETRYVIEWBYID',
                '/mod/trigonometry/view.php?id=$1',
                'course_module'
            ),
            new restore_decode_rule(
                'TRIGONOMETRYINDEX',
                '/mod/trigonometry/index.php?id=$1',
                'course'
            ),
        ];
    }

    public static function define_restore_log_rules() {
        return [
            new restore_log_rule(
                'trigonometry',
                'view',
                'view.php?id={course_module}',
                '{trigonometry}'
            ),
        ];
    }

    public static function define_restore_log_rules_for_course() {
        return [
            new restore_log_rule(
                'trigonometry',
                'view all',
                'index.php?id={course}',
                null
            ),
        ];
    }
}
