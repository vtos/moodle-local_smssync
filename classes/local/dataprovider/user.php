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
 * A value object to strictly define the data returned by the users data provider.
 *
 * @package   local_smssync
 * @copyright 2022 onwards Vitaly Potenko <potenkov@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smssync\local\dataprovider;

use InvalidArgumentException;

final class user {

    /**
     * @var string $firstname
     */
    private $firstname;

    /**
     * @var string $lastname
     */
    private $lastname;

    /**
     * @var string $email
     */
    private $email;

    /**
     * @var string $id
     */
    private $id;

    public function __construct(string $firstname, string $lastname, string $email, string $id) {
        if (empty(trim($firstname))) {
            throw new InvalidArgumentException('user first name cannot be empty');
        }
        if (empty(trim($lastname))) {
            throw new InvalidArgumentException('user last name cannot be empty');
        }
        if (!validate_email($email)) {
            throw new InvalidArgumentException('user email is invalid');
        }
        if (empty(trim($id))) {
            throw new InvalidArgumentException('user external id cannot be empty');
        }

        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->id = $id;
    }

    public function firstname(): string
    {
        return $this->firstname;
    }

    public function lastname(): string
    {
        return $this->lastname;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function id(): string
    {
        return $this->id;
    }

    public static function create_from_array(array $userdata): self {
        return new user(
            $userdata['firstname'] ?? '',
            $userdata['lastname'] ?? '',
            $userdata['email'] ?? '',
            $userdata['id'] ?? ''
        );
    }
}
