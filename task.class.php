<?php
/**
 * This class handles the modification of a task object
 */
class Task {
    public $TaskId;
    public $TaskName;
    public $TaskDescription;
    protected $TaskDataSource;
    public function __construct($Id = null) {
        $this->TaskDataSource = file_get_contents('Task_Data.txt');
        if (strlen($this->TaskDataSource) > 0)
            $this->TaskDataSource = json_decode($this->TaskDataSource); // Should decode to an array of Task objects
        else
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array

        if (!$this->TaskDataSource)
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array
        if (!$this->LoadFromId($Id))
            $this->Create();
    }
    protected function Create() {
        // This function needs to generate a new unique ID for the task
        // Assignment: Generate unique id for the new task
        $this->TaskId = $this->getUniqueId();
         $this->TaskName = 'New Task';
         $this->TaskDescription = 'New Description';
        $input = array(
            'TaskId' => $this->TaskId,
			'TaskName' => $this->TaskName,
			'TaskDescription' => $this->TaskDescription
        );
        
		$this->TaskDataSource[] = $input;
		$this->TaskDataSource = json_encode($this->TaskDataSource);
        file_put_contents('Task_Data.txt', $this->TaskDataSource);
       // echo $this->TaskId;  

    }
    protected function getUniqueId() {
        // Assignment: Code to get new unique ID
        $id = uniqid();
        return $id; // Placeholder return for now
    }

    protected function LoadFromId($Id = null) {
        if ($Id) {
            // Assignment: Code to load details here...
            $data = file_get_contents('Task_Data.txt');
            $json_arr = json_decode($data, true);

            $arr_index = array();
            foreach ($json_arr as $key => $value) {
                if ($value['TaskId'] == $Id) {
                    $arr_index[] = $value;
                }
            }
            return $arr_index;
        } else
            return null;
    }

    public function Save() {
        $data = file_get_contents('Task_Data.txt');
        $json_arr = json_decode($data, true);
        
        foreach ($json_arr as $key => $value) {
            if ($value['TaskId'] == $this->TaskId) {
                $json_arr[$key]['TaskName'] = $this->TaskName;
                $json_arr[$key]['TaskDescription'] = $this->TaskDescription;
            }
        }
        file_put_contents('Task_Data.txt', json_encode($json_arr));
        echo "saved";
    }

    public function Delete() {
        $index = $this->TaskId;
        $data = file_get_contents('Task_Data.txt');
        $json_arr = json_decode($data, true);

        $arr_index = array();
        foreach ($json_arr as $key => $value) {
            if ($value['TaskId'] ==  $index) {
                $arr_index[] = $key;
            }
        }

        foreach ($arr_index as $i) {
            unset($json_arr[$i]);
        }

        $json_arr = array_values($json_arr);

        file_put_contents('Task_Data.txt', json_encode($json_arr));
        echo "deleted";
    }

    public function GetTaskItem() {
        $index = $this->TaskId;
        $data = file_get_contents('Task_Data.txt');
        $json_arr = json_decode($data, true);

        $arr_index = array();
        foreach ($json_arr as $key => $value) {
            if ($value['TaskId'] ==  $index) {
                $arr_index[] = $value;
            }
        }
       return  $arr_index;
       echo "GetTask";
    }
}
?>