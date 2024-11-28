<?php

class Task {

    private ?int $task_id;
    private string $task_name;
    private string $task_description;
    private $course_id;
    private int $task_order;
    private bool $status; 

    public function __construct($task_id, $task_name, $task_description, $course_id, $task_order, $status=false) {
        $this->task_id = $task_id;
        $this->task_name = $task_name;
        $this->task_description = $task_description;
        $this->course_id = $course_id;
        $this->task_order = $task_order;
        $this->status = $status; 
    }

    public function set_task_id($val) {
        $this->task_id = $val;
    }

    public function get_task_id() {
        return $this->task_id;
    }

    public function set_task_name($val) {
        $this->task_name = $val;
    }

    public function get_task_name() {
        return $this->task_name;
    }

    public function set_task_description($val) {
        $this->task_description = $val;
    }

    public function get_task_description() {
        return $this->task_description;
    }

    public function set_course_id($val) {
        $this->course_id = $val;
    }

    public function get_course_id() {
        return $this->course_id;
    }

    public function set_task_order($val) {
        $this->task_order = $val;
    }

    public function get_task_order() {
        return $this->task_order;
    }

    public function set_status($val) {
        $this->status = $val;
    }

    public function get_status() {
        return $this->status;
    }
}

?>
