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
 * A value object to strictly define the data returned by the courses data provider per each course.
 *
 * @package   local_smssync
 * @copyright 2022 onwards Vitaly Potenko <potenkov@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smssync\local\dataprovider;

use InvalidArgumentException;

final class course {

    /**
     * @var string $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    public function __construct(string $id, string $name) {
        if (empty(trim($id))) {
            throw new InvalidArgumentException('course external id cannot be empty');
        }
        if (empty(trim($name))) {
            throw new InvalidArgumentException('course name cannot be empty');
        }

        $this->id = $id;
        $this->name = $name;
    }

    public function id(): string {
        return $this->id;
    }

    public function name(): string {
        return $this->name;
    }

    public static function create_from_array(array $coursedata): self {
        return new course(
            $coursedata['id'] ?? '',
            $coursedata['name'] ?? '',
        );
    }
}
