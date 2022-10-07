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
 * Implementation of the users provider interface using certain API.
 *
 * @package   local_smssync
 * @copyright 2022 onwards Vitaly Potenko <potenkov@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smssync\local\dataprovider;

global $CFG;
require_once($CFG->libdir . '/filelib.php');

use curl;
use JsonException;

final class users_provider implements users_provider_interface {

    /**
     * @var configuration $config
     */
    private $config;

    public function __construct(configuration $config) {
        $this->config = $config;
    }

    /**
     * @inheritDoc
     * @throws JsonException
     */
    public function fetch_users(): array {
        // TODO: making a call, defining headers, etc. should be extracted to a service class and used as a dependency.

        $curl = new curl();

        foreach ($this->headers() as $header => $value) {
            $curl->setHeader(["$header: $value"]);
        }

        $result = json_decode($curl->get($this->config->url()), true, 512, JSON_THROW_ON_ERROR);

        $users = [];
        foreach ($result as $userasarray) {
            $usernameparts = explode(' ', $userasarray['name'], 2);
            $userasarray['firstname'] = $usernameparts[0];
            $userasarray['lastname'] = $usernameparts[1];

            $users[] = user::create_from_array($userasarray);
        }

        return $users;
    }

    private function headers(): array {
        return [
            'Authorization' => 'Bearer ' . $this->config->token(),
            'Accept' => 'application/json',
        ];
    }
}
