$(function() {
  build("live");
  // Populate log
  function build(mode) {
    $('#log').load('php/log.php?mode='+mode);
    tally();
  }
  // Compute time spent
  function tally() {
    $('#tally').load('php/log.php?mode=tally');
  }
  // UI clear
  function clearUI() {
    $('#task').val("");
  }
  // Backgorund refresh
  setInterval(function() {
    var mode = $('#restore').data('mode');
    if (mode == "restore") build("live");
  }, 60000);
  // Add new task
  $('#form').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var task = $('#task').val();
    if (task !== "") {
      var data = form.serialize();
      $.ajax({
        url: 'php/log.php?mode=new',
        data: data,
        success: function() {
          build("live");
        }
      });
      clearUI();
    }
  });
  // Stop task timer
  $('#log').on('click', '.btn-stop', function() {
    var id = $(this).data('id');
    $.ajax({
      url: 'php/log.php?mode=stop&id='+id,
      success: function() {
        build("live");
      }
    });
  });
  // Remove task
  $('#log').on('click', '.btn-remove', function() {
    var id = $(this).data('id');
    $.ajax({
      url: 'php/log.php?mode=remove&id='+id,
      success: function() {
        build("live");
      }
    });
  });
  // Restore task
  $('#log').on('click', '.btn-restore', function (){
    var id = $(this).data('id');
    $.ajax({
      url: 'php/log.php?mode=refresh&id='+id,
      success: function() {
        build("restore");
      }
    });
  });
  // Remove task
  $('#log').on('click', '.btn-delete', function(){
    var id = $(this).data('id');
    $('#test').load('php/log.php?mode=delete&id='+id);
    $.ajax({
      url: 'php/log.php?mode=delete&id='+id,
      success: function() {
        build("restore");
      }
    });
  });
  // Enter restore mode
  $('#restore').on('click', function(e) {
    e.preventDefault();
    var mode = $(this).data('mode');
    if (mode == "restore") {
      build("restore");
      $(this).data('mode', 'live');
      $('#mode').html('live');
    } else {
      build("live");
      $(this).data('mode', 'restore');
      $('#mode').html('restore');
    }
  });
});
