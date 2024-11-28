<?php

class TaskTag {

    private int $task_id;
    private int $tag_id;

    public function __construct($task_id, $tag_id) {
        $this->task_id = $task_id;
        $this->tag_id = $tag_id;
    }

    // Getters and Setters
    public function set_task_id($val) {
        $this->task_id = $val;
    }

    public function get_task_id() {
        return $this->task_id;
    }

    public function set_tag_id($val) {
        $this->tag_id = $val;
    }

    public function get_tag_id() {
        return $this->tag_id;
    }
}

?>
