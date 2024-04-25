<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomAssert;
class TaskRequest
{
    /**
     * @Assert\NotBlank
     * @Assert\DateTime(format="Y-m-d")
     */
    public $date;

    /**
     * @Assert\NotBlank
     * @CustomAssert\ValidTimezone
     */
    public $timezone;
}