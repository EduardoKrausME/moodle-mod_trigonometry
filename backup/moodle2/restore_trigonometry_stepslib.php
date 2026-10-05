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
 * Restore structure for mod_trigonometry.
 *
 * @package   mod_trigonometry
 * @category  backup
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * Restores one Trigonometry activity.
 */
class restore_trigonometry_activity_structure_step extends restore_activity_structure_step {
    /**
     * Defines the paths restored from trigonometry.xml.
     *
     * @return restore_path_element[]
     */
    protected function define_structure() {
        return $this->prepare_activity_structure([
            new restore_path_element('trigonometry', '/activity/trigonometry'),
        ]);
    }

    /**
     * Restores the Trigonometry activity record.
     *
     * @param array $data Restored activity data.
     * @return void
     */
    /**
     * Restores the Trigonometry activity record.
     *
     * @param array $data Activity data from the backup.
     */
    protected function process_trigonometry($data) {
        global $DB;

        $data = (object) $data;
        $data->course = $this->get_courseid();

        $newitemid = $DB->insert_record('trigonometry', $data);
        $this->apply_activity_instance($newitemid);
    }

    /**
     * Restores files associated with the activity.
     *
     * @return void
     */
    /**
     * Restores files related to the activity.
     */
    protected function after_execute() {
        $this->add_related_files('mod_trigonometry', 'intro', null);
    }
}
