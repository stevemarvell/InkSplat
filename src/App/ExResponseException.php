<?php

/**
  * Exception with additional url data
  *
  */

namespace App;

class ExResponseException extends \Exception {

    /**
     * url
     *
     * @var string
     */
    protected $url;

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }
}

