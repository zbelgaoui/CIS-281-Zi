<?php
//get tasklist array from POST
$task_list = filter_input(INPUT_POST, 'tasklist', 
        FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
if ($task_list === NULL) {
    $task_list = [];
    
//    add some hard-coded starting values to make testing easier
$task_list[] = 'Write chapter';
$task_list[] = 'Edit chapter';
$task_list[] = 'Proofread chapter';
}

//get action variable from POST
$action = filter_input(INPUT_POST, 'action');

//initialize error messages array
$errors = [];

//process
switch( $action ) {
    case 'Add Task':
        $new_task = filter_input(INPUT_POST, 'newtask');
        if (empty($new_task)) {
            $errors[] = 'The new task cannot be empty.';
        } else {
            array_push($task_list, $new_task);
        }
        break;
    case 'Delete Task':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) {
            $errors[] = 'The task cannot be deleted.';
        } else {
            unset($task_list[$task_index]);
            $task_list = array_values($task_list);
        }
        break;

    // case 'Modify Task':
    case 'Modify Task':
    $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
    if ($task_index === NULL || $task_index === FALSE) {
        $errors[] = 'The task cannot be modified.';
    } else {
        $task_to_modify = $task_list[$task_index];
    }
    break;
    
    //case 'Save Changes':
    case 'Save Changes':
        $modified_task_index = filter_input(INPUT_POST, 'modifiedtaskid', FILTER_VALIDATE_INT);
        $modified_task = filter_input(INPUT_POST, 'modifiedtask');
        if (empty($modified_task)) {
            $errors[] = 'The modified task cannot be empty.';
            $task_to_modify = $task_list[$modified_task_index];
            $task_index = $modified_task_index;
        } else {
            $task_list[$modified_task_index] = $modified_task;
            $task_to_modify = '';
        }
        break;
    //case 'Cancel Changes':
    case 'Cancel Changes':
        $task_to_modify = '';
        break;
    
    //case 'Promote Task':
    case 'Promote Task':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE || $task_index == 0) {
            // You can't promote the first task
            $errors[] = 'The first task cannot be promoted.';
        } else {
            // Swap the selected task with the one above it
            $temp = $task_list[$task_index - 1];
            $task_list[$task_index - 1] = $task_list[$task_index];
            $task_list[$task_index] = $temp;
        }
        break;
        
    //case 'Sort Tasks':
    case 'Sort Tasks':
        sort($task_list);
        break;
    

}

include('task_list.php');
?>
