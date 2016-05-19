<?php
  // Quick function to add fontawesome icons
  function icon($code) {
    $icon = "<span class=\"fa fa-".$code."\"></span>";
    return $icon;
  }
  // Timestamp formating
  function displayDate($date) {
    return date('j M Y H:i', $date);
  }
  // Calculation of the difference between two timestamps
  function timeFormat($seconds) {
    $hours = floor(($seconds/60)/60);
    $minutes = round(($seconds/60) - ($hours*60));
    return $hours." hrs : ".$minutes." mins";
  }
  // Save new tasks
  function save($data) {
    $json = json_encode($data);
    $file = fopen("../data/data.json", "w");
    fwrite($file, $json);
  }
?>
