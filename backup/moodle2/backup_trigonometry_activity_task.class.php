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
 * Backup task for mod_trigonometry.
 *
 * @package   mod_trigonometry
 * @category  backup
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/trigonometry/backup/moodle2/backup_trigonometry_stepslib.php');

/**
 * Provides the steps to back up a Trigonometry activity.
 */
class backup_trigonometry_activity_task extends backup_activity_task {
    /**
     * No activity-specific backup settings are required.
     */
    protected function define_my_settings() {
    }

    /**
     * Defines the structure step.
     */
    protected function define_my_steps() {
        $this->add_step(
            new backup_trigonometry_activity_structure_step('trigonometry_structure', 'trigonometry.xml')
        );
    }

    /**
     * Encodes links to Trigonometry activity pages.
     *
     * @param string $content Content that may contain activity URLs.
     * @return string
     */
    public static function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot, '/');

        $search = '/(' . $base . '\/mod\/trigonometry\/index.php\?id\=)([0-9]+)/';
        $content = preg_replace($search, '$@TRIGONOMETRYINDEX*$2@$', $content);

        $search = '/(' . $base . '\/mod\/trigonometry\/view.php\?id\=)([0-9]+)/';
        $content = preg_replace($search, '$@TRIGONOMETRYVIEWBYID*$2@$', $content);

        return $content;
    }
}
