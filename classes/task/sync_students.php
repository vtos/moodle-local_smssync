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
 * The task synchronises users, courses and enrolments from external API to Moodle.
 *
 * @package   local_smssync
 * @copyright 2022 onwards Vitaly Potenko <potenkov@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smssync\task;

use core\task\scheduled_task;
use Exception;
use local_smssync\local\dataprovider\configuration;
use local_smssync\local\dataprovider\courses_provider;
use local_smssync\local\dataprovider\users_provider;
use local_smssync\local\sync_service;

class sync_students extends scheduled_task {

    // TODO: move these constants out of here (for example, into the plugin's settings).
    private const BASE_URL = '';

    private const USERS_ENDPOINT = '';

    private const COURSES_ENDPOINT = '';

    private const TOKEN = '';

    /**
     * @inheritDoc
     */
    public function get_name() {
        return get_string('syncronisetaskname', 'local_smssync');
    }

    /**
     * @inheritDoc
     */
    public function execute() {
        $sync = new sync_service(
            new users_provider(configuration::create_from_strings(self::BASE_URL . self::USERS_ENDPOINT, self::TOKEN)),
            new courses_provider(configuration::create_from_strings(self::BASE_URL . self::COURSES_ENDPOINT, self::TOKEN))
        );

        try {
            $sync->perform_synchronisation();
        } catch (Exception $e) {
            mtrace("An error occurred: " . $e->getMessage());
        }
    }
}
