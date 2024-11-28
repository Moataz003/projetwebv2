<?php

class Tag {

    private ?int $tag_id;
    private string $tag_name;

    public function __construct($tag_id, $tag_name) {
        $this->tag_id = $tag_id;
        $this->tag_name = $tag_name;
    }

    // Getters and Setters
    public function set_tag_id($val) {
        $this->tag_id = $val;
    }

    public function get_tag_id() {
        return $this->tag_id;
    }

    public function set_tag_name($val) {
        $this->tag_name = $val;
    }

    public function get_tag_name() {
        return $this->tag_name;
    }
}

?>
