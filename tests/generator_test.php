<?php
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Certificate module data generator.
 *
 * @package    mod_smartcertificate
 * @category   test
 * @author     Russell England <russell.england@catalyst-eu.net>
 * @copyright  Vidya Mantra EduSystems Pvt. Ltd.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 */

defined('MOODLE_INTERNAL') || die();

class mod_smartcertificate_generator_testcase extends advanced_testcase {
    public function test_generator() {
        global $DB;

        $this->resetAfterTest(true);

        $this->assertEquals(0, $DB->count_records('smartcertificate'));

        $course = $this->getDataGenerator()->create_course();

        /** @var mod_smartcertificate_generator $generator */
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_smartcertificate');
        $this->assertInstanceOf('mod_smartcertificate_generator', $generator);
        $this->assertEquals('smartcertificate', $generator->get_modulename());

        $generator->create_instance(array('course' => $course->id));
        $generator->create_instance(array('course' => $course->id));
        $smartcertificate = $generator->create_instance(array('course' => $course->id));
        $this->assertEquals(3, $DB->count_records('smartcertificate'));

        $cm = get_coursemodule_from_instance('smartcertificate', $smartcertificate->id);
        $this->assertEquals($smartcertificate->id, $cm->instance);
        $this->assertEquals('smartcertificate', $cm->modname);
        $this->assertEquals($course->id, $cm->course);

        $context = context_module::instance($cm->id);
        $this->assertEquals($smartcertificate->cmid, $context->instanceid);
    }
}
