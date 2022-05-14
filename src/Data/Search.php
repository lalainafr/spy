<?php

namespace App\Data;

class Search
{
    /**
     * @var string
     */

    public $page = 1;

    /**
     * @var string
     */

    public $q = '';

    /**
     * @var type[]
     */
    public $type = [];

    /**
     * @var country[]
     */
    public $country = [];
}
