<?php
  error_reporting(E_ERROR | E_PARSE);
  session_start();
  require_once 'vendor/autoload.php';
  include("include/header.php");
  if(!isset($_SESSION['userid']))
  { 
  	header("Location:login.php");
  }
  include("include/projectsidebar.php"); 
  $pid = $_SESSION['pid'];
  $userid = $_SESSION['userid'];

  $projectQuery = "Select * from projects where project_id = $pid";
  $projectResult = mysqli_query($cxn, $projectQuery);
  $projectRow = mysqli_fetch_assoc($projectResult);
  if ($projectRow != null)
  extract($projectRow);

  $rolequery = "Select distinct role as role from users,gp_relation,gu_relation where gp_relation.projectid = {$_SESSION['pid']} and gp_relation.groupid=gu_relation.groupid and gu_relation.userid=users.user_id and users.user_id = $userid";
  $roleresult = mysqli_query($cxn, $rolequery);
  $rolerow = mysqli_fetch_assoc($roleresult);
  if ($rolerow != null)
    extract($rolerow);

  $scheduleQuery = "Select * from schedules  where project_id = $pid and user_id = $userid";
  $scheduleResult = mysqli_query($cxn, $scheduleQuery);
  $scheduleRowNum = mysqli_num_rows($scheduleResult);
  $schedules = array();

  $garray = array();
  $uarray = array();

  $groupQuery = "Select * from groups, gp_relation where gp_relation.groupid = groups.id and gp_relation.projectid=$pid";
  $groupResult = mysqli_query($cxn,$groupQuery);
  $groupRowNum = mysqli_num_rows($groupResult);
  $groups = array();
  for($i = 0; $i < $groupRowNum; $i++)
  {
    $groupRow = mysqli_fetch_assoc($groupResult);
    $groups[$i] = $groupRow;
  }

  $userQuery = "Select * from users, gp_relation, gu_relation, accounts where gp_relation.groupid = gu_relation.groupid and gu_relation.userid = users.user_id and gp_relation.projectid = $pid and accounts.account_userid = users.user_id";
  $userResult = mysqli_query($cxn, $userQuery);
  $userRowNum = mysqli_num_rows($userResult);
  $users = array();
  for($j = 0; $j < $userRowNum; $j++)
  {
    $userRow = mysqli_fetch_assoc($userResult);
    $users[$j] = $userRow;
  }

  // $guarray = array();
  // for($i = 0; $i < count($groups);$i++){
  //   $gfquery = "Select * from gf_relation where groupid=".$groups[$i]['groupid'];
  //   $guarray[$i] = "";
  //   $gfresult = mysqli_query($cxn, $gfquery);
  //   while($gfrow = mysqli_fetch_assoc($gfresult)){
  //     $gfarr[$i] .= $gfrow['folderid'].",";
  //   }
  // }

  for($x = 0; $x < $scheduleRowNum; $x++)
  {
    $scheduleRow = mysqli_fetch_assoc($scheduleResult);
    $schedules[$x] = $scheduleRow;
  }
?>

<script type="text/javascript"> 
  //projectid = <?php echo $projectid;?>;
  var addSchedulIndex = 0;



  function compareWithOriginal() {
    var scheduleNumbers = <?php echo $scheduleRowNum; ?>;
    var schedulesJS = JSON.parse('<?php echo json_encode($schedules); ?>');
    for(var i = 0; i < scheduleNumbers; i++) { //initial values
      var index = schedulesJS[i]["schedule_id"];
      var rowwithindex = ".scheduleRow" + index;
      //if($(rowwithindex).)
      if(schedulesJS[i]["scheduled_date"] != $("#scheduledDate"+index).val())
      {
        console.log("here1" + index);
        $(rowwithindex).css('color', 'red');
        $(rowwithindex).find('*').css('color', 'red');
        continue;
      } 
      if(schedulesJS[i]["revised_date"] != $("#revisedDate"+index).val())
      {
        console.log("here2" + index);
        $(rowwithindex).css('color', 'red');
        $(rowwithindex).find('*').css('color', 'red');
        continue;
      } 
      if(schedulesJS[i]["difference"] != $("#difference"+index).val())
      {
        console.log("here3" + index);
        $(rowwithindex).css('color', 'red');
        $(rowwithindex).find('*').css('color', 'red');
        continue;
      } 
      if(schedulesJS[i]["event"] != $("#event"+index).val())
      {
        console.log("here4" + index);
        $(rowwithindex).css('color', 'red');
        $(rowwithindex).find('*').css('color', 'red');
        continue;
      }
      if(schedulesJS[i]["responsible_parties_groups"] != $("#schedule_group"+index).val())
      {
        console.log("here5" + index);
        $(rowwithindex).css('color', 'red');
        $(rowwithindex).find('*').css('color', 'red');
        continue;
      }
      if(schedulesJS[i]["responsible_parties_users"] != $("#schedule_user"+index).val())
      {
        console.log("here5user" + index);
        $(rowwithindex).css('color', 'red');
        $(rowwithindex).find('*').css('color', 'red');
        continue;
      }
      if(schedulesJS[i]["notes"] != $("#notes"+index).val())
      {
        console.log("here6" + index);
        $(rowwithindex).css('color', 'red');
        $(rowwithindex).find('*').css('color', 'red');
        continue;
      }
      if(schedulesJS[i]["status"] != $("#status"+index + " option:selected").text())
      {
        console.log(schedulesJS[i]["status"]);
        console.log($("#status"+index).val());
        console.log("here9" + index);
        $(rowwithindex).css('color', 'red');
        $(rowwithindex).find('*').css('color', 'red');
        continue;
      }
      if((schedulesJS[i]["reminders7check"] == 0 && $("#schedule7Check"+index).is(':checked')) || (schedulesJS[i]["reminders7check"] == 1 && $("#schedule7Check"+index).is(':checked') == false))
      {
        console.log("here7" + index);
        $(rowwithindex).css('color', 'red');
        $(rowwithindex).find('*').css('color', 'red');
        continue;
      }
      if((schedulesJS[i]["reminders30check"] == 0 && $("#schedule30Check"+index).is(':checked')) || (schedulesJS[i]["reminders30check"] == 1 && $("#schedule30Check"+index).is(':checked') == false))
      {
        console.log("here8" + index);
        $(rowwithindex).css('color', 'red');
        $(rowwithindex).find('*').css('color', 'red');
        continue;
      }
      $(rowwithindex).css('color', '#555');
      $(rowwithindex).find('*').css('color', '#555');
    }
  }

  function calculateDifference() {
    
    var scheduleNumbers = <?php echo $scheduleRowNum; ?>;
    var schedulesJS = JSON.parse('<?php echo json_encode($schedules); ?>');

    for(var i = 0; i < scheduleNumbers; i++) {
      var index = schedulesJS[i]["schedule_id"];
      var scheduledDate =  $('#scheduledDate' + index).val();
      var revisedDate =  $('#revisedDate' + index).val();
      
      if((scheduledDate != '')&&(revisedDate !=''))
      {
        var difference = Math.ceil((new Date(scheduledDate).getTime() - new Date(revisedDate).getTime()) / (1000 * 3600 * 24));
        $('#difference' + index).val(difference);
      }
    }

    for(var i = 0; i < addSchedulIndex; i++) {
      
      var scheduledDate =  $('#scheduledDateAdd' + i).val();
      var revisedDate =  $('#revisedDateAdd' + i).val();
      
      if((scheduledDate != '')&&(revisedDate !=''))
      {
        var difference = Math.ceil((new Date(scheduledDate).getTime() - new Date(revisedDate).getTime()) / (1000 * 3600 * 24));
        $('#differenceAdd' + i).val(difference);
      }
    }
  }

  function schedulesDelete() {

    var scheduleNumbers = <?php echo $scheduleRowNum; ?>;
    var schedulesJS = JSON.parse('<?php echo json_encode($schedules); ?>');

    for(var i = 0; i < scheduleNumbers; i++) {
      var index = schedulesJS[i]["schedule_id"];
      var checkwithindex = "#scheduleCheck" + index;
      var rowwithindex = ".scheduleRow" + index;
      if($(checkwithindex).is(':checked')) {
        $(rowwithindex).css('text-decoration', 'line-through');
        $(rowwithindex).find('*').css('text-decoration', 'line-through');
        $(rowwithindex).find('*').attr("disabled", "disabled").off('click');
        //$(rowwithindex).css('display', 'none');
      }
    }

    for(var i = 0; i < addSchedulIndex; i++) {
      var checkwithindex = "#scheduleCheckAdd" + i;
      var rowwithindex = ".scheduleRowAdd" + i;
      if($(checkwithindex).is(':checked')) {
        $(rowwithindex).css('display', 'none');
        //$(rowwithindex).find('*').css('text-decoration', 'line-through');
        //$(rowwithindex).css('display', 'none');
      }
    }
  }

  function scheduleAdd() {
    console.log("AddSchedule");
    var groupsJS = JSON.parse('<?php echo json_encode($groups); ?>');
    var usersJS = JSON.parse('<?php echo json_encode($users); ?>');
    var groupCount = <?php echo $groupRowNum; ?>;
    var userCount = <?php echo $userRowNum; ?>;

    var newScheduleNode = '<div class="col-md-12 scheduleRowAdd'+ addSchedulIndex +' paddingtop10" style="border-bottom: 1px solid #555"><div class="col-md-12" style="font-weight: 600">'
                + '<div class="col-md-1 scheduleCell" style="text-align: center">'
                + 'Select'
                + '</div>'

                + '<div class="col-md-2 scheduleCell">'
                + '  Scheduled Date'
                + '</div>'

                + '<div class="col-md-2 scheduleCell">'
                  + 'Revised Date'
                + '</div>'

                + '<div class="col-md-1 scheduleCell">'
                  + 'Difference'
                + '</div>'

                + '<div class="col-md-3 scheduleCell">'
                  + 'Responsible Parties'
                + '</div>'

                + '<div class="col-md-2 scheduleCell">'
                  + 'Status'
                + '</div>'

                + '<div class="col-md-1 scheduleCell" style="text-align: center">'
                  + 'Reminders'
                + '</div>'
              + '</div>'
        + '<div class="col-md-12" style="padding: 0">'
        + '<div class="col-md-1 scheduleCell" style="text-align:center">'
        + '<input type="checkbox" id="scheduleCheckAdd'+ addSchedulIndex +'">'
        + '</div>'

        + '<div class="col-md-2 scheduleCell">'
        + '<div class="input-group date " data-provide="datepicker" style="width:100%">'
        + '<input id="scheduledDateAdd'+ addSchedulIndex +'" name="scheduledDateAdd'+ addSchedulIndex +'" type="text" class="form-control scheduledDate scheduleCell" style="border-radius: 3px">'
        + '<div class="input-group-addon" style="display:none">'
        + '<span class="glyphicon glyphicon-th"></span>'
        + '</div>'
        + '</div>'
        + '</div>'

        + '<div class="col-md-2 scheduleCell">'
        + '<div class="input-group date" data-provide="datepicker" style="width:100%">'
        + '<input id="revisedDateAdd'+ addSchedulIndex +'" name="revisedDateAdd'+ addSchedulIndex +'" type="text" class="form-control revisedDate scheduleCell" style="border-radius: 3px">'
        + '<div class="input-group-addon" style="display:none">'
        + '<span class="glyphicon glyphicon-th"></span>'
        + '</div>'
        + '</div>'
        + '</div>'

        + '<div class="col-md-1 scheduleCell">'
        + '<input id="differenceAdd'+ addSchedulIndex +'" name="differenceAdd'+ addSchedulIndex +'" type="text" class="form-control calculated difference">'
        + '</div>'

        

        + '<div class="col-md-3 groupuserSelect scheduleCell">'
        + '<select class="selectpicker gupicker gupickerAdd'+ addSchedulIndex +'" name="fAccess" multiple data-selected-text-format="count>2" data-actions-box="true">'
        + '<optgroup label="Groups">';
        for(var i = 0; i < groupCount; i++)
        {
          newScheduleNode += '<option value="'+ groupsJS[i]["name"] +'"'
          + '>'+ groupsJS[i]["name"] +'</option>';
        }
        newScheduleNode += '<optgroup label="Users">';
        for(var j = 0; j < userCount; j++)
        {
          newScheduleNode += '<option value="'+ usersJS[j]["account_firstname"] +' '+ usersJS[j]["account_lastname"] +'"'
          + '>'+ usersJS[j]["account_firstname"] +' '+ usersJS[j]["account_lastname"] +'</option>';
        }
        newScheduleNode += '</select>'
        + '</div>'
        + '<input type="hidden" class="schedule_group" id="schedule_groupAdd'+ addSchedulIndex +'" name="schedule_groupAdd'+ addSchedulIndex +'">'

        + '<input type="hidden" class="schedule_user" id="schedule_userAdd'+ addSchedulIndex +'" name="schedule_userAdd'+ addSchedulIndex +'">'

        

        + '<div class="col-md-2 scheduleSelect scheduleCell">'
        + '<select class="scheduleSelect selectpicker status" id="statusAdd'+ addSchedulIndex +'" name="statusAdd'+ addSchedulIndex +'" type="text" >'
        + '<option value="Planned"'
        + '>Planned</option>'
        + '<option value="In Progress"'
        + '>In Progress</option>' 
        + '<option value="Completed"'
        + '>Completed</option>' 
        + '</select>'
        + '</div>'

        + '<div class="col-md-1 scheduleCell" style="text-align:center">'
        + '<input type="checkbox" class="schedule7Check" id="schedule7CheckAdd'+ addSchedulIndex +'"'
        + '><span>7Days</span>'
        
        + '</div>'
        + '</div>'
        + '<div class="col-md-12" style="font-weight: 600">'
        + '<div class="col-md-6 scheduleCell" style="text-align: center">'
        + 'Event'
        + '</div>'
        + '<div class="col-md-6 scheduleCell" style="text-align: center">'
        + 'Notes'
        + '</div>'
        + '</div>'
        + '<div class="col-md-12" style="padding: 0">'
        + '<div class="col-md-1 scheduleCell">'
        + '</div>'
        + '<div class="col-md-5 scheduleCell">'
        + '<input id="eventAdd'+ addSchedulIndex +'" name="eventAdd'+ addSchedulIndex +'" type="text" class="form-control event">'  
        + '</div>'
        + '<div class="col-md-5 scheduleCell">'
        + '<input id="notesAdd'+ addSchedulIndex +'" name="notesAdd'+ addSchedulIndex +'" type="text" class="form-control notes">' 
        + '</div>'

        + '<div class="col-md-1 scheduleCell" style="text-align:center">'
        + '<input type="checkbox" class="schedule30Check" id="schedule30CheckAdd'+ addSchedulIndex +'"'
        + ' style="margin-left:5px"><span>30Days</span>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<hr>';
    $(".scheduleTable").append(newScheduleNode);
    $('.gupickerAdd' + addSchedulIndex).selectpicker('render');
    $('#statusAdd' + addSchedulIndex).selectpicker('render');
    $(".date").datepicker({orientation: 'auto bottom'});
    $('.gupicker').selectpicker({
      dropupAuto: false
    });
    $('.scheduleSelect').selectpicker({
      dropupAuto: false
    });
    $(".scheduleRowAdd" + addSchedulIndex).css('color', 'green');
    $(".scheduleRowAdd" + addSchedulIndex).find('*').css('color', 'green');
    $(".gupickerAdd" + addSchedulIndex).change(function(){
      getGroupUserPicker();
      //compareWithOriginal();
    });
    $("#scheduledDateAdd" + addSchedulIndex).change(function(){
      setRevisedDateAdd(addSchedulIndex - 1);
    });

    $("#revisedDateAdd" + addSchedulIndex).change(function(){
      calculateDifference();
    });

    $("#differenceAdd" + addSchedulIndex).keyup(function(){
      calculateDifference();
    });
    addSchedulIndex++;
  }

  function setRevisedDateAdd(th) {
    $("#revisedDateAdd" + th).val($("#scheduledDateAdd" + th).val());
  }

  function getGroupUserPicker(){
    console.log("here");
    var scheduleNumbers = <?php echo $scheduleRowNum; ?>;
    var schedulesJS = JSON.parse('<?php echo json_encode($schedules); ?>');
    for(var i = 0; i < scheduleNumbers; i++)
    {
      var index = schedulesJS[i]["schedule_id"];
      $("#schedule_group" + index).val("");
      $("#schedule_user" + index).val("");
      $(".gupicker"+ index +" :selected").each(function(){
        if($(this).closest('optgroup').prop('label') == 'Groups'){
          $("#schedule_group" + index).val($("#schedule_group" + index).val()+$(this).val()+",");
        }
        if($(this).closest('optgroup').prop('label') == 'Users'){
          $("#schedule_user" + index).val($("#schedule_user" + index).val()+$(this).val()+",");
        }
      });
    }
    for(var i = 0; i < addSchedulIndex; i++)
    {
      $("#schedule_groupAdd" + i).val("");
      $("#schedule_userAdd" + i).val("");
      $(".gupickerAdd"+ i +" :selected").each(function(){
        if($(this).closest('optgroup').prop('label') == 'Groups'){
          $("#schedule_groupAdd" + i).val($("#schedule_groupAdd" + i).val()+$(this).val()+",");
        }
        if($(this).closest('optgroup').prop('label') == 'Users'){
          $("#schedule_userAdd" + i).val($("#schedule_userAdd" + i).val()+$(this).val()+",");
        }
      })
    }
    return true;
  }

  function schedulesSave(){
    $('#loading').show();
    var scheduleNumbers = <?php echo $scheduleRowNum; ?>;
    var schedulesJS = JSON.parse('<?php echo json_encode($schedules); ?>');
    var schedulesUpdateData = [];
    var schedulesAddData = [];
    var schedulesUpdateDataNumbers = new Array();
    var schedulesDataAddNumbers = new Array();
    var schedulesDataDeleteNumbers = new Array();
    for(var i = 0; i < scheduleNumbers; i++)
    {
      var index = schedulesJS[i]["schedule_id"];
      if($(".scheduleRow"+index).css("text-decoration") != "line-through" && $(".scheduleRow"+index).css("color") == "rgb(255, 0, 0)")
      {
        schedulesUpdateDataNumbers.push(index);
        tempUpdateData = [];
        tempUpdateData[0] = $("#scheduledDate"+index).val();
        tempUpdateData[1] = $("#revisedDate"+index).val();
        tempUpdateData[2] = $("#difference"+index).val();
        tempUpdateData[3] = $("#event"+index).val();
        tempUpdateData[4] = $("#schedule_group"+index).val();
        tempUpdateData[5] = $("#schedule_user"+index).val();
        tempUpdateData[6] = $("#notes"+index).val();
        tempUpdateData[7] = $("#status"+index).val();
        tempUpdateData[8] = $("#schedule7Check"+index).is(':checked')?1:0;
        tempUpdateData[9] = $("#schedule30Check"+index).is(':checked')?1:0; 
        schedulesUpdateData[index] = tempUpdateData;
      }

      if($(".scheduleRow"+index).css("text-decoration") == "line-through")
      {
        schedulesDataDeleteNumbers.push(index);
      }
    }

    for(var i = 0; i < addSchedulIndex; i++)
    {
      if($(".scheduleRowAdd"+i).css("display") != "none")
      {
        schedulesDataAddNumbers.push(i);
        // schedulesAddData[i] = [];
        // schedulesAddData[i]["scheduledDate"] = $("#scheduledDateAdd"+i).val();
        // schedulesAddData[i]["revisedDate"] = $("#revisedDateAdd"+i).val();
        // schedulesAddData[i]["difference"] = $("#differenceAdd"+i).val();
        // schedulesAddData[i]["event"] = $("#eventAdd"+i).val();
        // schedulesAddData[i]["schedule_groupuser"] = $("#schedule_groupuserAdd"+i).val();
        // schedulesAddData[i]["notes"] = $("#notesAdd"+i).val();
        // schedulesAddData[i]["schedule7Check"] = $("#schedule7CheckAdd"+i).val();
        // schedulesAddData[i]["schedule30Check"] = $("#schedule30CheckAdd"+i).val(); 
        // schedulesAddData[i]["status"] = $("#statusAdd"+i).val();
        tempAddData = [];
        tempAddData[0] = $("#scheduledDateAdd"+i).val();
        tempAddData[1] = $("#revisedDateAdd"+i).val();
        tempAddData[2] = $("#differenceAdd"+i).val();
        tempAddData[3] = $("#eventAdd"+i).val();
        tempAddData[4] = $("#schedule_groupAdd"+i).val();
        tempAddData[5] = $("#schedule_userAdd"+i).val();
        tempAddData[6] = $("#notesAdd"+i).val();
        tempAddData[7] = $("#statusAdd"+i).val();
        tempAddData[8] = $("#schedule7CheckAdd"+i).is(':checked')?1:0;
        tempAddData[9] = $("#schedule30CheckAdd"+i).is(':checked')?1:0; 
        schedulesAddData[i] = tempAddData;
      }
    }

    console.log("Delete = " + schedulesDataDeleteNumbers);
    console.log("Add = " + schedulesDataAddNumbers);
    console.log(schedulesAddData);
    console.log("Update = " + schedulesUpdateDataNumbers);
    console.log(schedulesUpdateData);
    $.ajax({
      type: "POST",
      url: "saveschedules.php",
      data: {'deleteIDs' : schedulesDataDeleteNumbers, 'updateIDs': schedulesUpdateDataNumbers, 'updateDatas': schedulesUpdateData, 'addIDs': schedulesDataAddNumbers, 'addDatas': schedulesAddData},
      success: function() {
        $('#loading').hide();
        location.reload();
      },
      error: function(){
        alert('error handing here');
      }
    });
  }

  function exportToPDF(){
    var scheduleNumbers = <?php echo $scheduleRowNum; ?>;
    var schedulesJS = JSON.parse('<?php echo json_encode($schedules); ?>');
    for(var i = 0; i < scheduleNumbers; i++)
    {
      var index = schedulesJS[i]["schedule_id"];
      if($(".scheduleRow"+index).css("text-decoration") == "line-through" || $(".scheduleRow"+index).css("color") == "rgb(255, 0, 0)")
      {
        alert("Please Save Schedule Before Export!");
        return;
      }
    }

    if(addSchedulIndex > 0)
    {
      alert("Please Save Schedule Before Export!");
      return;
    }
    var projectname = '<?php echo $project_name; ?>';
    buildHTMLToPrint();
    
    //var tempData = $("#scheduleContent").html();
    var doc = new jsPDF();
    $('#toprint').show();
    $('#loading').show();
    doc.addHTML($('#toprint').get(0),5,20,{},function() {  
      $('#toprint').hide();
      $('#loading').hide();
      doc.save(projectname +"_schedule.pdf");
      location.reload();
      // $("#scheduleContent").html("");
      // $("#scheduleContent").html(tempData);
      // $("#scheduleContent").find('.bootstrap-select').hide();
      // $("#scheduleContent").find('select').selectpicker();
      //$(".selectpicker").selectpicker('render');
      // $('.selectpicker').prop('disabled',true);
      // $('.selectpicker').selectpicker('refresh');
      // var pdf = btoa(doc.output());
      // console.log('here'); 
      // $.ajax({
      //     type: "POST",
      //     url: "/exportSchedule.php",
      //     data: {data: pdf, projectname: projectname},
      // }).done(function(response){
      //   $('#loading').hide();
      //   //location.reload();
      //   $("#scheduleContent").html("");
      //   $("#scheduleContent").html(tempData);
      // });

    });
  }

  function buildHTMLToPrint() {
    $(".scheduleTableToPrint").html("");
    $(".scheduleTable > div").each(function(){

      if($(this).css('display') != 'none') {
        var newScheduleNode = '<div class="col-md-12" style="padding: 0">'
        

                + '<div class="col-md-2 scheduleCell">'
                + '  Scheduled Date'
                + '</div>'

                + '<div class="col-md-2 scheduleCell">'
                  + 'Revised Date'
                + '</div>'

                + '<div class="col-md-1 scheduleCell">'
                  + 'Difference'
                + '</div>'

                + '<div class="col-md-4 scheduleCell">'
                  + 'Responsible Parties'
                + '</div>'

                + '<div class="col-md-2 scheduleCell">'
                  + 'Status'
                + '</div>'

                + '<div class="col-md-1 scheduleCell" style="text-align: center">'
                  + 'Reminders'
                + '</div>'
              + '</div>'
        + '<div class="col-md-12" style="padding: 0">'
        + '<div class="col-md-2 scheduleCell">'
        + '<p><b>' + $(this).find(".scheduledDate").val() + '</b></p>'
        + '</div>'

        + '<div class="col-md-2 scheduleCell">'
        + '<p><b>' + $(this).find(".revisedDate").val() + '</b></p>'
        + '</div>'

        + '<div class="col-md-1 scheduleCell">'
        + '<p><b>' + $(this).find(".difference").val() + ' days</b></p>'
        + '</div>'

       

        + '<div class="col-md-4 groupuserSelect scheduleCell">'
        + '<p><b>';
        if($(this).find(".schedule_group").val() != "")
        newScheduleNode += 'group: ' + $(this).find(".schedule_group").val().substr(0, $(this).find(".schedule_group").val().length - 1);
        if($(this).find(".schedule_user").val() != "")
        newScheduleNode += ' user: ' + $(this).find(".schedule_user").val().substr(0, $(this).find(".schedule_user").val().length - 1);
        newScheduleNode += '</b></p>'
        + '</div>'
        + '<div class="col-md-3 scheduleSelect scheduleCell">'
        + '<p><b>' + $(this).find(".scheduleSelect option:selected").text() + '</b></p>'
        + '</div>'
        
        + '</div>'
        + '<div class="col-md-12" style="padding: 0">'
        + '<div class="col-md-6 scheduleCell" style="text-align: center">'
        + 'Event'
        + '</div>'
        + '<div class="col-md-6 scheduleCell" style="text-align: center">'
        + 'Notes'
        + '</div>'
        + '</div>'
        + '<div class="col-md-12 " style="padding: 0;border-bottom: 1px solid #555;">'
        + '<div class="col-md-6 scheduleCell">'
        + '<p><b>' + $(this).find(".event").val() + '</b></p>'
        + '</div>'
        + '<div class="col-md-6 scheduleCell">'
        + '<p><b>' + $(this).find(".notes").val() + '</b></p>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<hr>';
        //console.log($(this).find(".status"));
        // + '<div class="col-md-1 scheduleCell">'
        // + '7d';
        // if ($(this).find(".schedule7Check").is(':checked') == false) {
        //   newScheduleNode += '<span class="glyphicon glyphicon-unchecked"></span>';
        // }
        // if ($(this).find(".schedule7Check").is(':checked') == true) {
        //   newScheduleNode += '<span class="glyphicon glyphicon-check"></span>';
        // }

        // newScheduleNode +='   30d';
        // if ($(this).find(".schedule30Check").is(':checked') == false) {
        //   newScheduleNode += '<span class="glyphicon glyphicon-unchecked"></span>';
        // }
        // if ($(this).find(".schedule30Check").is(':checked') == true) {
        //   newScheduleNode += '<span class="glyphicon glyphicon-check"></span>';
        // }
        // newScheduleNode+= '</div>'
        // + '</div>';
      }
      $(".scheduleTableToPrint").append(newScheduleNode);
    });
  }

  function setRevisedDate(idtext) {
    console.log($(idtext).val());
    $("#"+idtext.replace("scheduledDate", "revisedDate")).val($("#"+idtext).val());
  }
</script>

<div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 scheduleContent" id="scheduleContent">
<?php  
  include("include/alerts.php");   
?>  
  <div id="goodalert" class='row' style="display:none">
    <div class='alert alert-success alert-dismissable'>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      <strong>Success!</strong> You have saved the document.
    </div>
  </div>
          
  <div class="row paddingtop10 borderbottom paddingright10">            
    <span class='indexpage_header'>Schedule of Project "<?php echo $project_name; ?>"</span>
  </div>

  <div class="row paddingright10 pull-right paddingtop10">
    <button class='btn btn-default btn-primary' <?php if($role == 3) echo 'disabled' ?> onclick="scheduleAdd()">ADD</button>
    <button class='btn btn-success btn-warning' <?php if($role == 3) echo 'disabled' ?> onclick="schedulesDelete()">Delete</button>
    <button class='btn btn-default btn-large' <?php if($role == 3) echo 'disabled' ?> onclick="schedulesSave()">Save</button>
    <button class='btn btn-info' <?php if($role == 3) echo 'disabled' ?> onclick="exportToPDF()">Export</button>
  </div>

  <br>
  <br>
  <br>

  
  <div class="scheduleTable container" id="scheduleTable" style="width: 100% !important; padding: 0 !important">
    <?php
      if($scheduleRowNum > 0) {
        for($x = 0; $x < $scheduleRowNum; $x++)
        {
          $garray[$schedules[$x]["schedule_id"]] = $schedules[$x]["responsible_parties_groups"];
          $uarray[$schedules[$x]["schedule_id"]] = $schedules[$x]["responsible_parties_users"];
          echo '<div class="col-md-12 scheduleRow'.$schedules[$x]["schedule_id"] .' paddingtop10" id="scheduleRow'.$schedules[$x]["schedule_id"] .'" style="border-bottom: 1px solid #555">';
          echo '<div class="col-md-12" style="font-weight: 600">
                <div class="col-md-1 scheduleCell" style="text-align: center">
                  Select
                </div>

                <div class="col-md-2 scheduleCell">
                  Scheduled Date
                </div>

                <div class="col-md-2 scheduleCell">
                  Revised Date
                </div>

                <div class="col-md-1 scheduleCell">
                  Difference
                </div>

                <div class="col-md-3 scheduleCell">
                  Responsible Parties
                </div>

                <div class="col-md-2 scheduleCell">
                  Status
                </div>

                <div class="col-md-1 scheduleCell" style="text-align: center">
                  Reminders
                </div>
              </div>';
          echo '<div class="col-md-12" style="padding: 0">';
          echo '<div class="col-md-1 scheduleCell" style="text-align:center">';
          echo '<input type="checkbox" id="scheduleCheck'.$schedules[$x]["schedule_id"].'">';
          echo '</div>';

          echo '<div class="col-md-2 scheduleCell">';
          echo '<div class="input-group date" data-provide="datepicker" style="width:100%">';
          echo '<input id="scheduledDate'.$schedules[$x]["schedule_id"].'" name="scheduledDate'.$schedules[$x]["schedule_id"].'" type="text" class="form-control scheduledDate scheduleCell" value="'.$schedules[$x]["scheduled_date"].'" style="border-radius: 3px">';
          echo '<div class="input-group-addon" style="display:none">';
          echo '<span class="glyphicon glyphicon-th"></span>';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          echo '<div class="col-md-2 scheduleCell">';
          echo '<div class="input-group date" data-provide="datepicker" style="width:100%">';
          echo '<input id="revisedDate'.$schedules[$x]["schedule_id"].'" name="revisedDate'.$schedules[$x]["schedule_id"].'" type="text" class="form-control revisedDate scheduleCell" value="'.$schedules[$x]["revised_date"].'" style="border-radius: 3px">';
          echo '<div class="input-group-addon" style="display:none">';
          echo '<span class="glyphicon glyphicon-th"></span>';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          echo '<div class="col-md-1 scheduleCell">';
          echo '<input id="difference'.$schedules[$x]["schedule_id"].'" name="difference'.$schedules[$x]["schedule_id"].'" type="text" class="form-control calculated difference" value="'.$schedules[$x]["difference"].'">';
          echo '</div>';

          echo '<div class="col-md-3 groupuserSelect scheduleCell">';
          echo '<select class="selectpicker gupicker gupicker'.$schedules[$x]["schedule_id"].'" name="fAccess" multiple data-selected-text-format="count>2" data-actions-box="true">';
          echo '<optgroup label="Groups">';
          for($i = 0; $i < $groupRowNum; $i++)
          {
            echo '<option value="'.$groups[$i]["name"].'"';
            echo '>'.$groups[$i]["name"].'</option>';
          }
          echo '<optgroup label="Users">';
          for($j = 0; $j < $userRowNum; $j++)
          {
            echo '<option value="'.$users[$j]["account_firstname"].' '.$users[$j]["account_lastname"].'"';
            echo '>'.$users[$j]["account_firstname"].' '.$users[$j]["account_lastname"].'</option>';
          }
          echo '</select>';
          echo '</div>';
          echo '<input type="hidden" class="schedule_group" id="schedule_group'.$schedules[$x]["schedule_id"].'" name="schedule_group'.$schedules[$x]["schedule_id"].'" value="'.$schedules[$x]["responsible_parties_groups"].'">';

          echo '<input type="hidden" class="schedule_user" id="schedule_user'.$schedules[$x]["schedule_id"].'" name="schedule_group'.$schedules[$x]["schedule_id"].'" value="'.$schedules[$x]["responsible_parties_users"].'">';

          

          echo '<div class="col-md-2 scheduleSelect scheduleCell">';
          echo '<select class="scheduleSelect selectpicker status" id="status'.$schedules[$x]["schedule_id"].'" name="status'.$schedules[$x]["schedule_id"].'" type="text">';
          echo '<option value="Planned"';
          if($schedules[$x]["status"] == "Planned") echo 'selected';
          echo '>Planned</option>';
          echo '<option value="In Progress"';
          if($schedules[$x]["status"] == "In Progress") echo 'selected';
          echo '>In Progress</option>'; 
          echo '<option value="Completed"';
          if($schedules[$x]["status"] == "Completed") echo 'selected';
          echo '>Completed</option>'; 
          echo '</select>';
          echo '</div>';

          echo '<div class="col-md-1 scheduleCell" style="text-align: center">';
          echo '<input type="checkbox" class="schedule7Check" id="schedule7Check'.$schedules[$x]["schedule_id"].'"';
          if($schedules[$x]["reminders7check"] == 1) echo 'checked';
          echo '><span>7Days</span>';
          echo '</div>';
          echo '</div><div class="col-md-12" style="font-weight: 600">
                  <div class="col-md-6 scheduleCell" style="text-align: center">
                    Event
                  </div>
                  <div class="col-md-6 scheduleCell" style="text-align: center">
                    Notes
                  </div>
                </div>';
          echo '<div class="col-md-12" style="padding: 0">';

          echo '<div class="col-md-1 scheduleCell">';
          echo '</div>';

          echo '<div class="col-md-5 scheduleCell">';
          echo '<input id="event'.$schedules[$x]["schedule_id"].'" name="event'.$schedules[$x]["schedule_id"].'" type="text" class="form-control event" value="'.$schedules[$x]["event"].'">';  
          echo '</div>';

          echo '<div class="col-md-5 scheduleCell">';
          echo '<input id="notes'.$schedules[$x]["schedule_id"].'" name="notes'.$schedules[$x]["schedule_id"].'" type="text" class="form-control notes" value="'.$schedules[$x]["notes"].'">'; 
          echo '</div>';

          echo '<div class="col-md-1 scheduleCell" style="text-align: center">';
          echo '<input type="checkbox" class="schedule30Check" id="schedule30Check'.$schedules[$x]["schedule_id"].'"';
          if($schedules[$x]["reminders30check"] == 1) echo 'checked';
          echo ' style="margin-left:5px"><span>30Days</span>';
          echo '</div>';

          echo '</div>';
          echo '</div>';
          echo '<hr>';
        }
      }
      if($scheduleRowNum == 0)
      {
    ?>
        <script type="text/javascript">
          scheduleAdd();
        </script>
    <?php
      }
    ?>
  </div>
  <div class="printbody container toprint" id="toprint" style="background-color: white; width: 100% !important; padding: 0 !important; display:none; margin-top: 1000px !important">
    
    <div class="scheduleTableToPrint">
    </div>
    <!--div id="toprint" class='printbody' style="background-color: white; display: none" >

    <center>
        <h4><u>PARTIAL PAYMENT ESTIMATE</u></h4> 
      </center>
    </div-->
  </div>
</div>  

<script type="text/javascript">
  document.getElementById("schedule").className = "active"; 
  $(document).ready(function(){ 
    $(".date").datepicker({orientation: 'auto bottom'});
    $(".gupicker").selectpicker({orientation: 'auto bottom'});
    $('.gupicker').selectpicker({
      dropupAuto: false
    });
    $('.scheduleSelect').selectpicker({
      dropupAuto: false
    });
    var scheduleNumbers = <?php echo $scheduleRowNum; ?>;
    var schedulesJS = JSON.parse('<?php echo json_encode($schedules); ?>');
    //console.log(schedulesJS[0]["schedule_id"]);
    var garray = JSON.parse('<?php echo json_encode($garray); ?>');
    var uarray = JSON.parse('<?php echo json_encode($uarray); ?>');
    //console.log(guarray);
    addSchedulIndex = 0;
    if(scheduleNumbers == 0) addSchedulIndex = 1;
    for(var i = 0; i < scheduleNumbers; i++) {
      var gupickerindex = schedulesJS[i]["schedule_id"];
      var gupickerwithindexandoption = ".gupicker" + gupickerindex + " option";
      var gupickerwithindex = ".gupicker" + gupickerindex;
      var pickers = new Array();
      $(gupickerwithindexandoption).each(function(){
        if((garray[gupickerindex].indexOf($(this).val()+",") >= 0)&&($(this).closest('optgroup').prop('label') == 'Groups')){
          //console.log(guarray[gupickerindex]);
          pickers.push($(this).val());
        }
        if((uarray[gupickerindex].indexOf($(this).val()+",") >= 0)&&($(this).closest('optgroup').prop('label') == 'Users')){
          //console.log(guarray[gupickerindex]);
          pickers.push($(this).val());
        }
      });
      //console.log($(gupickerwithindex).selectpicker('val'));
      //$(gupickerwithindex).selectpicker('val', pickers);
      $(gupickerwithindex).val(pickers);
      $(gupickerwithindex).selectpicker("refresh");
    }   

    // for(var i = 0; i < scheduleNumbers; i++) { //initial values
    //   var index = schedulesJS[i]["schedule_id"];
      // schedulesInitialValues[index]["scheduledDate"] = $("#scheduledDate"+index).val();
      // schedulesInitialValues[index]["revisedDate"] = $("#revisedDate"+index).val();
      // schedulesInitialValues[index]["difference"] = $("#difference"+index).val();
      // schedulesInitialValues[index]["event"] = $("#event"+index).val();
      // schedulesInitialValues[index]["schedule_groupuser"] = $("#schedule_groupuser"+index).val();
      // schedulesInitialValues[index]["notes"] = $("#notes"+index).val();
      // schedulesInitialValues[index]["schedule7Check"] = $("#schedule7Check"+index).val();
      // schedulesInitialValues[index]["schedule30Check"] = $("#schedule30Check"+index).val(); 
      // schedulesInitialValues[index]["status"] = $("#status"+index).val();
    $(".scheduledDate").change(function(){
      setRevisedDate($(this).attr("id"));
      compareWithOriginal();
    });

    $(".revisedDate").change(function(){
      compareWithOriginal();
      calculateDifference();
    });

    $(".difference").keyup(function(){
      compareWithOriginal();
      calculateDifference();
    });

    $(".event").keyup(function(){
      compareWithOriginal();
    });

    $(".gupicker").change(function(){
      getGroupUserPicker();
      compareWithOriginal();
    });

    $(".notes").keyup(function(){
      compareWithOriginal();
    });

    $(".schedule7Check").change(function(){
      compareWithOriginal();
    });

    $(".schedule30Check").change(function(){
      compareWithOriginal();
    });

    $(".status").change(function(){
      compareWithOriginal();
    });
    //}
    
  });
</script>

<?php
  include("include/footer.php");
?>




