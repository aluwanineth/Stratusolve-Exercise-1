<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('Task.class.php');
// Assignment: Implement this script
if(!isset($_POST['action'])) {
	print json_encode(0);
	return;
}

switch($_POST['action']) {
	
	case 'delete':
        $taskData = json_decode($_POST['taskData']);
        $task = new Task($taskData->id);
        $task->TaskId = $taskData->id;
	    $task->Delete();		
    break;
    
    case 'get_task':
        $taskData = json_decode($_POST['taskData']);
        $task = new Task($taskData->id);
        $task->TaskId = $taskData->id;
	    $task->GetTaskItem();		
	break;
	
	case 'save':
        $taskData = json_decode($_POST['taskData']);
        $task = new Task($taskData->id);
        if($taskData->id != -1){
           $task->TaskId = $taskData->id;
        }
        $task->TaskName = $taskData->taskName;
        $task->TaskDescription = $taskData->taskDescription;
	    $task->Save();				
	break;
}

exit();
?>