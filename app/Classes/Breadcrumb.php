<?php

namespace App\Classes;

class Breadcrumb {

    public $link;
    public $description;


    public static function create($value, $link = "") {
        $instance = new self();
        $instance->link = $link;
        $instance->description = $value;
        return $instance;
    }

    public function hasLink()
    {
        return strlen($this->link) > 0;
    }
}