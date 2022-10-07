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
 * The configuration object containing necessary data for making an API call, like url, etc.
 *
 * @package   local_smssync
 * @copyright 2022 onwards Vitaly Potenko <potenkov@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smssync\local\dataprovider;

use InvalidArgumentException;

final class configuration {

    /**
     * @var string $url
     */
    private $url;

    /**
     * @var string $token
     */
    private $token;

    public function __construct(string $url, string $token) {
        if (empty(trim($url))) {
            throw new InvalidArgumentException('url cannot be empty');
        }
        if (empty(trim($token))) {
            throw new InvalidArgumentException('token cannot be empty');
        }

        $this->url = $url;
        $this->token = $token;
    }

    public function url(): string {
        return $this->url;
    }

    public function token(): string {
        return $this->token;
    }

    /**
     * A named constructor to make instantiating a bit less verbose.
     */
    public static function create_from_strings(string $url, string $token): self {
        return new self($url, $token);
    }
}
