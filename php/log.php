<?php
  include("tracker.php");
  $json = file_get_contents("../data/data.json");
  $data = json_decode($json, 1);
  if (is_array($data)) krsort($data);
  // Switch
  switch ($_GET['mode']) {
    // Writing log
    case "live":
      if (is_array($data)) {
        foreach($data as $task) {
          if ($task['status'] == 1) {
            ?>
            <tr>
              <td><?=$task['name']?></td>
              <td><?=displayDate($task['start'])?></td>
              <td>
                <?
                if (($task['end']) != "") echo displayDate($task['end']);
                else echo "-";
                ?>
              </td>
              <td>
                <?
                if ($task['end'] == "") echo timeFormat(time() - $task['start']);
                else echo timeFormat($task['end'] - $task['start']);
                ?>
              </td>
              <td>
                <button data-id="<?=$task['id']?>" class="btn btn-primary btn-stop" <?=($task['end'] != "")?"disabled":""?>><?=icon("stop")?></button>
                <button data-id="<?=$task['id']?>" class="btn btn-danger btn-remove"><?=icon("close")?></button>
              </td>
            </tr>
            <?
          }
        }
      }
    break;
    // Keeping track of time
    case "tally":
      if (is_array($data)) {
        $count = 0;
        foreach($data as $task) {
          if ($task['status'] == 1) {
            if ($task['end'] != "") $count += $task['end'] - $task['start'];
            else $count += time() - $task['start'];
          }
        }
        echo timeFormat($count);
      } else echo "<em>naught</em>";
    break;
    // Task creation
    case "new":
      $time = time();
      $data[$time]['id'] = $time;
      $data[$time]['name'] = $_GET['task'];
      $data[$time]['start'] = $time;
      $data[$time]['end'] = "";
      $data[$time]['status'] = 1;
      save($data);
    break;
    case "stop":
      $id = $_GET['id'];
      $data[$id]['end'] = time();
      save($data);
    break;
    case "remove":
      $id = $_GET['id'];
      $data[$id]['end'] = time();
      $data[$id]['status'] = 0;
      save($data);
    break;
    case "restore":
      if (is_array($data)) {
        foreach($data as $task) {
          if ($task['status'] == 0) {
            ?>
            <tr>
              <td><?=$task['name']?></td>
              <td><?=displayDate($task['start'])?></td>
              <td>
                <?
                if (($task['end']) != "") echo displayDate($task['end']);
                else echo "-";
                ?>
              </td>
              <td>
                <?
                if ($task['end'] == "") echo timeFormat(time() - $task['start']);
                else echo timeFormat($task['end'] - $task['start']);
                ?>
              </td>
              <td>
                <button data-id="<?=$task['id']?>" class="btn btn-primary btn-restore"><?=icon("refresh")?></button>
                <button data-id="<?=$task['id']?>" class="btn btn-danger btn-delete"><?=icon("trash")?></button>
              </td>
            </tr>
            <?
          }
        }
      }
    break;
    case "refresh":
      $id = $_GET['id'];
      echo $id;
      $data[$id]['status'] = 1;
      save($data);
    break;
    case "delete":
      $id = $_GET['id'];
      unset($data[$id]);
      save($data);
    break;
  }
?>
