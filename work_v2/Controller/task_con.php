<?php

require_once __DIR__ . '/../config.php';

class TaskController
{

    private $tab_name;

    public function __construct($tab_name)
    {
        $this->tab_name = $tab_name;
    }

    public function getTask($id)
    {
        $sql = "SELECT * FROM $this->tab_name WHERE task_id = :id";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            $task = $query->fetch();
            return $task;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function listTasks()
    {
        $sql = "SELECT * FROM $this->tab_name ORDER BY task_order";

        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function getTasksByForeignKey0($foreign_key_id, $foreign_key_type)
    {
        if ($foreign_key_type !== 'course') {
            throw new InvalidArgumentException('Invalid foreign key type. Must be "course" or "quiz".');
        }

        $column = $foreign_key_type . '_id'; # course_id
        $sql = "SELECT * FROM $this->tab_name WHERE $column = :id ORDER BY task_order";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $foreign_key_id]);
            $tasks = $query->fetchAll();
            return $tasks;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function getTasksByForeignKey($foreign_key_id, $foreign_key_type) {
        if ($foreign_key_type !== 'course') {
            throw new InvalidArgumentException('Invalid foreign key type. Must be "course".');
        }

        $sql = "SELECT task.*, 
                GROUP_CONCAT(CONCAT(tag.tag_id, '|', tag.tag_name) SEPARATOR ',') AS tags
                FROM task 
                LEFT JOIN task_tag ON task.task_id = task_tag.task_id 
                LEFT JOIN tag ON task_tag.tag_id = tag.tag_id 
                WHERE task.course_id = :foreign_key_id 
                GROUP BY task.task_id
                ORDER BY task.task_order ASC";
        
        $db = config::getConnexion();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':foreign_key_id', $foreign_key_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    function addTask($task)
    {
        $sql = "INSERT INTO $this->tab_name (task_name, task_description, course_id, task_order, status) VALUES (:task_name, :task_description, :course_id, :task_order, :status)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(
                [
                    'task_name' => $task->get_task_name(),
                    'task_description' => $task->get_task_description(),
                    'course_id' => $task->get_course_id(),
                    'task_order' => $task->get_task_order(),
                    'status' => $task->get_status() ? 1 : 0 // Convert boolean to integer
                ]
            );
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function updateTask($task, $id)
    {
        try {
            $db = config::getConnexion();
            $query = $db->prepare("UPDATE $this->tab_name SET task_name = :task_name, task_description = :task_description, course_id = :course_id, task_order = :task_order, status = :status WHERE task_id = :id");
            $query->execute(
                [
                    'id' => $id,
                    'task_name' => $task->get_task_name(),
                    'task_description' => $task->get_task_description(),
                    'course_id' => $task->get_course_id(),
                    'task_order' => $task->get_task_order(),
                    'status' => $task->get_status() ? 1 : 0 // Convert boolean to integer
                ]
            );
            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            $e->getMessage();
            echo ($e);
        }
    }

    function deleteTask($id)
    {
        $sql = "DELETE FROM $this->tab_name WHERE task_id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function updateTaskStatus($status, $id)
    {
        try {
            $db = config::getConnexion();
            $query = $db->prepare("UPDATE $this->tab_name SET status = :status WHERE task_id = :id");
            $query->execute(
                [
                    'id' => $id,
                    'status' => $status ? 1 : 0 // Convert boolean to integer
                ]
            );
            return $query->rowCount() > 0;
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }

    // check if a course has a task
    function doesCourseHaveTask($course_id)
    {
        $sql = "SELECT * FROM $this->tab_name WHERE course_id = :course_id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['course_id' => $course_id]);
            $task = $query->fetch();
            return $task !== false;
        } catch (Exception $e) {
            echo ('Error: ' . $e->getMessage());
            return false;
        }
    }

    // count the number of tasks in a course
    function countTasksInCourse($course_id)
    {
        $sql = "SELECT COUNT(*) FROM $this->tab_name WHERE course_id = :course_id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['course_id' => $course_id]);
            $count = $query->fetchColumn();
            return $count;
        } catch (Exception $e) {
            echo ('Error: ' . $e->getMessage());
            return 0;
        }
    }

    function moveTaskOrderUp($task_id, $course_id)
    {
        try {
            $db = config::getConnexion();

            // Step 1: Get the task that we need to move and its current order
            $sql = "SELECT task_id, task_order FROM $this->tab_name WHERE task_id = :task_id AND course_id = :course_id";
            $query = $db->prepare($sql);
            $query->execute(['task_id' => $task_id, 'course_id' => $course_id]);
            $taskToMove = $query->fetch();

            if (!$taskToMove) {
                throw new Exception("Task not found for the specified course.");
            }

            $currentTaskOrder = $taskToMove['task_order'];

            // Step 2: Find the task with the previous order (current order - 1)
            $sql = "SELECT task_id, task_order FROM $this->tab_name WHERE course_id = :course_id AND task_order = :task_order";
            $query = $db->prepare($sql);
            $query->execute(['course_id' => $course_id, 'task_order' => $currentTaskOrder - 1]);
            $taskWithPreviousOrder = $query->fetch();

            if ($taskWithPreviousOrder) {
                // Step 3: Swap the task orders
                $db->beginTransaction(); // Start a transaction to ensure atomicity

                // Update the task with the previous order to the current task's order
                $sqlUpdate = "UPDATE $this->tab_name SET task_order = :new_order WHERE task_id = :task_id";
                $queryUpdate = $db->prepare($sqlUpdate);
                $queryUpdate->execute([
                    'new_order' => $currentTaskOrder,
                    'task_id' => $taskWithPreviousOrder['task_id']
                ]);

                // Update the task to move to the previous task's order
                $queryUpdate->execute([
                    'new_order' => $currentTaskOrder - 1,
                    'task_id' => $task_id
                ]);

                $db->commit(); // Commit the transaction

                echo "Task order swapped successfully.";
            } else {
                throw new Exception("No task exists with the previous order.");
            }
        } catch (Exception $e) {
            // If any error occurs, rollback the transaction and display the error
            $db->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }

    function moveTaskOrderDown($task_id, $course_id)
    {
        try {
            $db = config::getConnexion();

            // Step 1: Get the task that we need to move and its current order
            $sql = "SELECT task_id, task_order FROM $this->tab_name WHERE task_id = :task_id AND course_id = :course_id";
            $query = $db->prepare($sql);
            $query->execute(['task_id' => $task_id, 'course_id' => $course_id]);
            $taskToMove = $query->fetch();

            if (!$taskToMove) {
                throw new Exception("Task not found for the specified course.");
            }

            $currentTaskOrder = $taskToMove['task_order'];

            // Step 2: Find the task with the next order (current order + 1)
            $sql = "SELECT task_id, task_order FROM $this->tab_name WHERE course_id = :course_id AND task_order = :task_order";
            $query = $db->prepare($sql);
            $query->execute(['course_id' => $course_id, 'task_order' => $currentTaskOrder + 1]);
            $taskWithNextOrder = $query->fetch();

            if ($taskWithNextOrder) {
                // Step 3: Swap the task orders
                $db->beginTransaction(); // Start a transaction to ensure atomicity

                // Update the task with the next order to the current task's order
                $sqlUpdate = "UPDATE $this->tab_name SET task_order = :new_order WHERE task_id = :task_id";
                $queryUpdate = $db->prepare($sqlUpdate);
                $queryUpdate->execute([
                    'new_order' => $currentTaskOrder,
                    'task_id' => $taskWithNextOrder['task_id']
                ]);

                // Update the task to move to the next task's order
                $queryUpdate->execute([
                    'new_order' => $currentTaskOrder + 1,
                    'task_id' => $task_id
                ]);

                $db->commit(); // Commit the transaction

                echo "Task order moved down successfully.";
            } else {
                throw new Exception("No task exists with the next order.");
            }
        } catch (Exception $e) {
            // If any error occurs, rollback the transaction and display the error
            $db->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }


}

?>