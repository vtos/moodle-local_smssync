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
 * The service does the job on fetching the data from external API using providers and populating the data into Moodle.
 *
 * @package   local_smssync
 * @copyright 2022 onwards Vitaly Potenko <potenkov@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smssync\local;

use local_smssync\local\dataprovider\courses_provider_interface;
use local_smssync\local\dataprovider\user;
use local_smssync\local\dataprovider\users_provider_interface;

final class sync_service {

    /**
     * @var users_provider_interface $usersprovider
     */
    private $usersprovider;

    /**
     * @var courses_provider_interface $coursesprovider
     */
    private $coursesprovider;

    public function __construct(users_provider_interface $usersprovider, courses_provider_interface $coursesprovider) {
        $this->usersprovider = $usersprovider;
        $this->coursesprovider = $coursesprovider;
    }

    public function perform_synchronisation(): void {
        $externalusers = $this->usersprovider->fetch_users();

        $externalusersidnumberarray = [];
        foreach ($externalusers as $externaluser) {
            $externalusersidnumberarray[] = $externaluser->id();
        }
        $existingusersidnumberarray = $this->get_id_number_of_existing_users($externalusersidnumberarray);

        // TODO: implement the users sync logic.

        $externalcourses = $this->coursesprovider->fetch_courses();
        // TODO: implement the courses and enrolments sync logic.
    }

    /**
     * The method tries to fetch all existing users provided array of their id number field. The returned array is to used to
     * identify external users who already exist in the Moodle database.
     * We use the id number field specifically as usually it's used to identify a user in the external systems.
     *
     * @param int[] $usersidarray An array of id numbers of users to synchronise.
     * @return int[] An array of id numbers of users who already exist in Moodle.
     */
    private function get_id_number_of_existing_users(array $usersidarray): array {

    }
}
