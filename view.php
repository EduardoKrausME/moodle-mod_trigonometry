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
 * view.php
 *
 * @package   mod_trigonometry
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__ . "/../../config.php");

$id = required_param("id", PARAM_INT);
$cm = get_coursemodule_from_id("trigonometry", $id, 0, false, MUST_EXIST);
$course = get_course($cm->course);
$trigonometry = $DB->get_record("trigonometry", ["id" => $cm->instance], "*", MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);
require_capability("mod/trigonometry:view", $context);

$event = \mod_trigonometry\event\course_module_viewed::create([
    "objectid" => $trigonometry->id,
    "context" => $context,
]);
$event->add_record_snapshot("course", $course);
$event->add_record_snapshot("trigonometry", $trigonometry);
$event->trigger();

$PAGE->set_url("/mod/trigonometry/view.php", ["id" => $cm->id]);
$PAGE->set_title(format_string($trigonometry->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);

$completion = new completion_info($course);
$completion->set_module_viewed($cm);

$PAGE->requires->js_call_amd("mod_trigonometry/calculator", "init", ["trigonometry-calculator-{$cm->id}"]);

$data = [
    "id" => "trigonometry-calculator-{$cm->id}",
    "anglecalculator" => get_string("anglecalculator", "mod_trigonometry"),
    "angle" => get_string("angle", "mod_trigonometry"),
    "degrees" => get_string("degrees", "mod_trigonometry"),
    "radians" => get_string("radians", "mod_trigonometry"),
    "sine" => get_string("sine", "mod_trigonometry"),
    "cosine" => get_string("cosine", "mod_trigonometry"),
    "tangent" => get_string("tangent", "mod_trigonometry"),
    "coordinates" => get_string("coordinates", "mod_trigonometry"),
    "normalizedangle" => get_string("normalizedangle", "mod_trigonometry"),
    "inversecalculator" => get_string("inversecalculator", "mod_trigonometry"),
    "value" => get_string("value", "mod_trigonometry"),
    "arcsine" => get_string("arcsine", "mod_trigonometry"),
    "arccosine" => get_string("arccosine", "mod_trigonometry"),
    "arctangent" => get_string("arctangent", "mod_trigonometry"),
    "unitcircle" => get_string("unitcircle", "mod_trigonometry"),
    "circlehint" => get_string("circlehint", "mod_trigonometry"),
    "formulas" => get_string("formulas", "mod_trigonometry"),
    "undefined" => get_string("undefined", "mod_trigonometry"),
    "outofdomain" => get_string("outofdomain", "mod_trigonometry"),
    "clear" => get_string("clear", "mod_trigonometry"),
];

echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($trigonometry->name));

if (trim($trigonometry->intro) !== "") {
    echo $OUTPUT->box(format_module_intro("trigonometry", $trigonometry, $cm->id), "generalbox mod_introbox", "trigonometryintro");
}

echo $OUTPUT->render_from_template("mod_trigonometry/calculator", $data);
echo $OUTPUT->footer();
