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
use local_smssync\local\dataprovider\users_provider_interface;

final class sync_service {

    private $usersprovider;

    private $coursesprovider;

    public function __construct(users_provider_interface $usersprovider, courses_provider_interface $coursesprovider) {
        $this->usersprovider = $usersprovider;
        $this->coursesprovider = $coursesprovider;
    }

    public function sync(): void {
        $users = $this->usersprovider->fetch_users();
        $courses = $this->coursesprovider->fetch_courses();


    }
}
