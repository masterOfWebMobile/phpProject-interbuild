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

  $budgetTotalQuery = "Select * from budgets where project_id = $pid and user_id = $userid and budget_type = 2";
  $budgetTotalResult = mysqli_query($cxn, $budgetTotalQuery);
  $budgetTotalRow = mysqli_fetch_assoc($budgetTotalResult);
  if($budgetTotalRow != null)
  {  
    extract($budgetTotalRow);
    $budgetTotal = $budget_amount;
  }
  else {
    $budgetTotal = 0;
  }

  $budgetSourceQuery = "Select * from budgets where project_id = $pid and user_id = $userid and budget_type = 0";
  $budgetSourceResult = mysqli_query($cxn, $budgetSourceQuery);
  $budgetSourceRowNum = mysqli_num_rows($budgetSourceResult);
  $budgetSources = array();

  for($x = 0; $x < $budgetSourceRowNum; $x++)
  {
    $budgetSourceRow = mysqli_fetch_assoc($budgetSourceResult);
    $budgetSources[$x] = $budgetSourceRow;
  }

  $budgetUseQuery = "Select * from budgets where project_id = $pid and user_id = $userid and budget_type = 1";
  $budgetUseResult = mysqli_query($cxn, $budgetUseQuery);
  $budgetUseRowNum = mysqli_num_rows($budgetUseResult);
  $budgetUses = array();

  for($x = 0; $x < $budgetUseRowNum; $x++)
  {
    $budgetUseRow = mysqli_fetch_assoc($budgetUseResult);
    $budgetUses[$x] = $budgetUseRow;
  }
?>

<div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 budgetContent" id="budgetContent">
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
    <span class='indexpage_header'>Budget of Project "<?php echo $project_name; ?>"</span>
  </div>
  <br>
  <div class="col-sm-12">
    <button class="pull-right btn btn-info" style="margin-left: 10px" onclick="exportToPDF()">Export</button>
    <button class="pull-right btn btn-primary" onclick="budgetSave()">Save</button>
  </div>
  <br>
  <div class="col-sm-12">
    <div class="text-right col-sm-5 form-group">
      <label class="form-label">Total Project Budget</label> : 
    </div>
    <div class="text-center col-sm-4">
      <input type="text" class="form-control currency text-right budgetTotal" value="<?php echo $budgetTotal; ?>">
    </div>
  </div>
  <br>
  <div class="col-sm-12">
    <div class="col-sm-6 table-content container" style="border:1px solid #555 !important;">
      <div style = "border-bottom: 1px solid #555;" class="col-sm-12 container">
        <div class="col-sm-4">
          <label class="form-label"><h4>Funding Sources</h4></label>
        </div>
        <div class="col-sm-8">
          <button class="pull-right btn btn-danger" style="padding-left: 10px; margin-left: 10px" onclick="budgetSourceDelete()" >Remove</button>
          <button class="pull-right btn btn-primary" onclick="budgetSourceAdd()">Add</button>
        </div>
      </div>
      <div class="budget-Source-table container col-sm-12">
        <?php
        if($budgetSourceRowNum > 0) {
          for($x = 0; $x < $budgetSourceRowNum; $x++)
          {
            echo '<div class="col-md-12 budgetSourceRow paddingtop10" id="budgetSourceRow'.$budgetSources[$x]["budget_id"] .'">';
            echo '<div class="col-md-1 budgetSourceCell" style="text-align:center">';
            echo '<input type="checkbox" id="budgetSourceCheck'.$budgetSources[$x]["budget_id"].'">';
            echo '</div>';
            echo '<div class="col-md-5 budgetSourceCell">';
            echo '<input id="budgetSourceName'.$budgetSources[$x]["budget_id"].'" type="text" class="form-control budgetSourceName" value="'.$budgetSources[$x]["budget_name"].'">';
            echo '</div>';
            echo '<div class="col-md-3 budgetSourceCell">';
            echo '<input id="budgetSourceValue'.$budgetSources[$x]["budget_id"].'" type="text" class="form-control budgetSourceValue currency" value="'.$budgetSources[$x]["budget_amount"].'" >';
            echo '</div>';
            echo '<div class="col-md-3 budgetSourceCell">';
            echo '<input id="budgetSourcePercent'.$budgetSources[$x]["budget_id"].'" type="text" class="form-control budgetSourcePercent" disabled>';
            echo '</div>';
            echo '</div>';
          }
        }
        ?>
      </div>
      <div class="budget-Source-table-bottom paddingtop10 container col-md-12" style="border-top: 1px solid #555; padding-left: 30px; padding-right: 30px; margin-top: 20px">
        <div class="col-md-6">
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control budgetSourceValueSum currency" disabled>
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control budgetSourcePercentSum" disabled>
        </div>
      </div>
    </div>

    <div class="col-sm-6 table-content" style="border:1px solid #555 !important;">
      <div style = "border-bottom: 1px solid #555;" class="col-sm-12 container">
        <div class="col-sm-4">
          <label class="form-label"><h4>Funding Uses</h4></label>
        </div>
        <div class="col-sm-8">
          <button class="pull-right btn btn-danger" style="padding-left: 10px; margin-left: 10px" onclick="budgetUseDelete()" >Remove</button>
          <button class="pull-right btn btn-primary" onclick="budgetUseAdd()">Add</button>
        </div>
      </div>
      <div class="budget-use-table container col-md-12">
        <?php
        if($budgetUseRowNum > 0) {
          for($x = 0; $x < $budgetUseRowNum; $x++)
          {
            echo '<div class="col-md-12 budgetUseRow paddingtop10" id="budgetUseRow'.$budgetUses[$x]["budget_id"] .'">';
            echo '<div class="col-md-1 budgetUseCell" style="text-align:center">';
            echo '<input type="checkbox" id="budgetUseCheck'.$budgetUses[$x]["budget_id"].'">';
            echo '</div>';
            echo '<div class="col-md-5 budgetUseCell">';
            echo '<input id="budgetUseName'.$budgetUses[$x]["budget_id"].'" type="text" class="form-control budgetUseName" value="'.$budgetUses[$x]["budget_name"].'">';
            echo '</div>';
            echo '<div class="col-md-3 budgetUseCell">';
            echo '<input id="budgetUseValue'.$budgetUses[$x]["budget_id"].'" type="text" class="form-control budgetUseValue currency" value="'.$budgetUses[$x]["budget_amount"].'" >';
            echo '</div>';
            echo '<div class="col-md-3 budgetUseCell">';
            echo '<input id="budgetUsePercent'.$budgetUses[$x]["budget_id"].'" type="text" class="form-control budgetUsePercent" disabled>';
            echo '</div>';
            echo '</div>';
          }
        }
        ?>
      </div>
      <div class="budget-use-table-bottom paddingtop10 container col-md-12" style="border-top: 1px solid #555; padding-left: 30px; padding-right: 30px; margin-top: 20px">
        <div class="col-md-6">
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control budgetUseValueSum currency" disabled>
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control budgetUsePercentSum" disabled>
        </div>
      </div>
    </div>
  </div>

  <div class="printbody container toprint" id="toprint" style="background-color: white; width: 100% !important; padding: 0 !important;  display:none; margin-top: 1000px !important ">
    <div class="row paddingtop10 borderbottom paddingright10" style="padding-left: 30px">            
      <span class='indexpage_header'>Budget of Project "<?php echo $project_name; ?>"</span>
    </div>
    <div class="col-sm-12 totalBudgetToPrint" style="text-align: center">

    </div>
    <div class="col-sm-6 table-content container" style="border:1px solid #555 !important;">
      <div class="budget-source-tableToPrint container col-md-12">
      </div>
      <div class="budget-source-table-bottomToPrint paddingtop10 container col-md-12" style="border-top: 1px solid #555; padding-left: 30px; padding-right: 30px; margin-top: 20px">
      </div>
    </div>
    <div class="col-sm-6 table-content container" style="border:1px solid #555 !important;">
      <div class="budget-use-tableToPrint container col-md-12">
      </div>
      <div class="budget-use-table-bottomToPrint paddingtop10 container col-md-12" style="border-top: 1px solid #555; padding-left: 30px; padding-right: 30px; margin-top: 20px">
      </div>
    </div>
  </div>
</div>
<script>
var addBudgetSourceIndex = 0;
var addBudgetUseIndex = 0;

function RemoveRougeChar(convertString){
    if(convertString.substring(0,1) == ","){
        return convertString.substring(1, convertString.length)     
    }
    return convertString;    
}

function getNumber(str){
  var num = parseInt(str.replace(/,/gi, ""));
  return num;
}

$(document).ready(function() { 
  addBudgetSourceIndex = 0;
  addBudgetUseIndex = 0;
  calculateBudgetSourceBottom();
  calculateBudgetUseBottom();
  $(".budgetSourceValue").keyup(function(){
      calculateBudgetSourceBottom();
  });

  $(".budgetUseValue").keyup(function(){
      calculateBudgetUseBottom();
  });

  $(".currency").keyup(function(event){
      // skip for arrow keys
      if(event.which >= 37 && event.which <= 40){
          event.preventDefault();
      }
      var $this = $(this);
      var num = $this.val().replace(/,/gi, "").split("").reverse().join("");
      var num2 = RemoveRougeChar(num.replace(/(.{3})/g,"$1,").split("").reverse().join(""));      
      // the following line has been simplified. Revision history contains original.
      $this.val(num2);
  });

  $(".currency").each(function(){
    changeNumber(this);
  });

});

function changeNumber(ele) {
  var $this = $(ele);
  var num = $this.val().replace(/,/gi, "").split("").reverse().join("");
  var num2 = RemoveRougeChar(num.replace(/(.{3})/g,"$1,").split("").reverse().join(""));      
  // the following line has been simplified. Revision history contains original.
  $this.val(num2);
}

function budgetSourceAdd() {
  newBudgetSourceRow = '<div class="col-md-12 budgetSourceRow paddingtop10" id="budgetSourceRowAdd'+addBudgetSourceIndex +'">'
            + '<div class="col-md-1 budgetSourceCell" style="text-align:center">'
            + '<input type="checkbox" id="budgetSourceCheckAdd'+ addBudgetSourceIndex +'">'
            + '</div>'
            + '<div class="col-md-5 budgetSourceCell">'
            + '<input id="budgetSourceNameAdd'+ addBudgetSourceIndex +'" type="text" class="form-control budgetSourceName">'
            + '</div>'
            + '<div class="col-md-3 budgetSourceCell">'
            + '<input id="budgetSourceValueAdd'+ addBudgetSourceIndex +'" type="text" class="form-control budgetSourceValue currency" >'
            + '</div>'
            + '<div class="col-md-3 budgetSourceCell">'
            + '<input id="budgetSourcePercentAdd'+ addBudgetSourceIndex +'" type="text" class="form-control budgetSourcePercent" disabled>'
            + '</div>'
            + '</div>';
  $(".budget-Source-table").append(newBudgetSourceRow);
  $(".currency").keyup(function(event){
      // skip for arrow keys
      if(event.which >= 37 && event.which <= 40){
          event.preventDefault();
      }
      var $this = $(this);
      var num = $this.val().replace(/,/gi, "").split("").reverse().join("");
      var num2 = RemoveRougeChar(num.replace(/(.{3})/g,"$1,").split("").reverse().join(""));      
      // the following line has been simplified. Revision history contains original.
      $this.val(num2);
  });
  $("#budgetSourceRowAdd" + addBudgetSourceIndex).css('color', 'green');
  $("#budgetSourceRowAdd" + addBudgetSourceIndex).find('*').css('color', 'green');
  $(".budgetSourceValue").keyup(function(){
      calculateBudgetSourceBottom();
  });
  addBudgetSourceIndex++;
  calculateBudgetSourceBottom();
}

function budgetUseAdd() {
  newBudgetUseRow = '<div class="col-md-12 budgetUseRow paddingtop10" id="budgetUseRowAdd'+addBudgetUseIndex +'">'
            + '<div class="col-md-1 budgetUseCell" style="text-align:center">'
            + '<input type="checkbox" id="budgetUseCheckAdd'+ addBudgetUseIndex +'">'
            + '</div>'
            + '<div class="col-md-5 budgetUseCell">'
            + '<input id="budgetUseNameAdd'+ addBudgetUseIndex +'" type="text" class="form-control budgetUseName">'
            + '</div>'
            + '<div class="col-md-3 budgetUseCell">'
            + '<input id="budgetUseValueAdd'+ addBudgetUseIndex +'" type="text" class="form-control budgetUseValue currency" >'
            + '</div>'
            + '<div class="col-md-3 budgetUseCell">'
            + '<input id="budgetUsePercentAdd'+ addBudgetUseIndex +'" type="text" class="form-control budgetUsePercent" disabled>'
            + '</div>'
            + '</div>';
  $(".budget-use-table").append(newBudgetUseRow);
  $(".currency").keyup(function(event){
      // skip for arrow keys
      if(event.which >= 37 && event.which <= 40){
          event.preventDefault();
      }
      var $this = $(this);
      var num = $this.val().replace(/,/gi, "").split("").reverse().join("");
      var num2 = RemoveRougeChar(num.replace(/(.{3})/g,"$1,").split("").reverse().join(""));      
      // the following line has been simplified. Revision history contains original.
      $this.val(num2);
  });
  $("#budgetUseRowAdd" + addBudgetUseIndex).css('color', 'green');
  $("#budgetUseRowAdd" + addBudgetUseIndex).find('*').css('color', 'green');
  $(".budgetUseValue").keyup(function(){
      calculateBudgetUseBottom();
  });
  addBudgetUseIndex++;
  calculateBudgetUseBottom();
}

function budgetSourceDelete() {
  var budgetSourcesNumbers = <?php echo $budgetSourceRowNum; ?>;
  var budgetSourcesJS = JSON.parse('<?php echo json_encode($budgetSources); ?>');

  for(var i = 0; i < budgetSourcesNumbers; i++) {
    var index = budgetSourcesJS[i]["budget_id"];
    var checkwithindex = "#budgetSourceCheck" + index;
    var rowwithindex = "#budgetSourceRow" + index;
    if($(checkwithindex).is(':checked')) {
      $(rowwithindex).css('text-decoration', 'line-through');
      $(rowwithindex).find('*').css('text-decoration', 'line-through');
      $(rowwithindex).find('*').attr("disabled", "disabled").off('click');
      //$(rowwithindex).css('display', 'none');
    }
  }

  for(var i = 0; i < addBudgetSourceIndex; i++) {
    var checkwithindex = "#budgetSourceCheckAdd" + i;
    var rowwithindex = "#budgetSourceRowAdd" + i;
    if($(checkwithindex).is(':checked')) {
      $(rowwithindex).css('display', 'none');
      //$(rowwithindex).find('*').css('text-decoration', 'line-through');
      //$(rowwithindex).css('display', 'none');
    }
  }
  calculateBudgetSourceBottom();
}

function budgetUseDelete() {
  var budgetUsesNumbers = <?php echo $budgetUseRowNum; ?>;
  var budgetUsesJS = JSON.parse('<?php echo json_encode($budgetUses); ?>');

  for(var i = 0; i < budgetUsesNumbers; i++) {
    var index = budgetUsesJS[i]["budget_id"];
    var checkwithindex = "#budgetUseCheck" + index;
    var rowwithindex = "#budgetUseRow" + index;
    if($(checkwithindex).is(':checked')) {
      $(rowwithindex).css('text-decoration', 'line-through');
      $(rowwithindex).find('*').css('text-decoration', 'line-through');
      $(rowwithindex).find('*').attr("disabled", "disabled").off('click');
      //$(rowwithindex).css('display', 'none');
    }
  }

  for(var i = 0; i < addBudgetUseIndex; i++) {
    var checkwithindex = "#budgetUseCheckAdd" + i;
    var rowwithindex = "#budgetUseRowAdd" + i;
    if($(checkwithindex).is(':checked')) {
      $(rowwithindex).css('display', 'none');
      //$(rowwithindex).find('*').css('text-decoration', 'line-through');
      //$(rowwithindex).css('display', 'none');
    }
  }
  calculateBudgetUseBottom();
}

function calculateBudgetSourceBottom() {
  var budgetSourceValueSum = 0;
  var budgetSourcePercentSum = 0;
  var budgetSourcesNumbers = <?php echo $budgetSourceRowNum; ?>;
  var budgetSourcesJS = JSON.parse('<?php echo json_encode($budgetSources); ?>');
  for(var i = 0; i < budgetSourcesNumbers; i++) {
    var index = budgetSourcesJS[i]["budget_id"];
    if($("#budgetSourceValue" + index).val() != '' && $("#budgetSourceRow" + index).css("text-decoration") != "line-through")
      budgetSourceValueSum += parseFloat(getNumber($("#budgetSourceValue" + index).val()));
  }

  for(var i = 0; i < addBudgetSourceIndex; i++) {
    if ($("#budgetSourceRowAdd" + i).css("display") != "none") {
      if($("#budgetSourceValueAdd" + i).val() != '')
        budgetSourceValueSum += parseFloat(getNumber($("#budgetSourceValueAdd" + i).val()));
    }
  }
  
  $(".budgetSourceValueSum").val(budgetSourceValueSum);
  changeNumber(".budgetSourceValueSum");
  for(var i = 0; i < budgetSourcesNumbers; i++) {
    var index = budgetSourcesJS[i]["budget_id"];
    if (budgetSourceValueSum != 0){
      if($("#budgetSourceValue" + index).val() != '')
        $("#budgetSourcePercent" + index).val((parseFloat(getNumber($("#budgetSourceValue" + index).val())) / budgetSourceValueSum * 100).toFixed(2));
      else
        $("#budgetSourcePercent" + index).val("");
    }
    else {
      $("#budgetSourcePercent" + index).val(0);
    }
  }

  for(var i = 0; i < addBudgetSourceIndex; i++) {
    if (budgetSourceValueSum != 0) {
      if($("#budgetSourceValueAdd" + i).val() != '')
        $("#budgetSourcePercentAdd" + i).val((parseFloat(getNumber($("#budgetSourceValueAdd" + i).val())) / budgetSourceValueSum * 100).toFixed(2));
      else 
        $("#budgetSourcePercentAdd" + i).val("");
    }
    else {
      $("#budgetSourcePercentAdd" + i).val(0);
    }
  }

  $(".budgetSourcePercentSum").val(100);
  
}

function calculateBudgetUseBottom() {
  var budgetUseValueSum = 0;
  var budgetUsePercentSum = 0;
  var budgetUsesNumbers = <?php echo $budgetUseRowNum; ?>;
  var budgetUsesJS = JSON.parse('<?php echo json_encode($budgetUses); ?>');
  for(var i = 0; i < budgetUsesNumbers; i++) {
    var index = budgetUsesJS[i]["budget_id"];
    if($("#budgetUseValue" + index).val() != '' && $("#budgetUseRow" + index).css("text-decoration") != "line-through")
      budgetUseValueSum += parseFloat(getNumber($("#budgetUseValue" + index).val()));
  }

  for(var i = 0; i < addBudgetUseIndex; i++) {
    if ($("#budgetUseRowAdd" + i).css("display") != "none") {
      if($("#budgetUseValueAdd" + i).val() != '')
        budgetUseValueSum += parseFloat(getNumber($("#budgetUseValueAdd" + i).val()));
    }
  }
  
  $(".budgetUseValueSum").val(budgetUseValueSum);
  changeNumber(".budgetUseValueSum");
  for(var i = 0; i < budgetUsesNumbers; i++) {
    var index = budgetUsesJS[i]["budget_id"];
    if (budgetUseValueSum != 0){
      if($("#budgetUseValue" + index).val() != '')
        $("#budgetUsePercent" + index).val((parseFloat(getNumber($("#budgetUseValue" + index).val())) / budgetUseValueSum * 100).toFixed(2));
      else
        $("#budgetUsePercent" + index).val("");
    }
    else {
      $("#budgetUsePercent" + index).val(0);
    }
  }

  for(var i = 0; i < addBudgetUseIndex; i++) {
    if (budgetUseValueSum != 0) {
      if($("#budgetUseValueAdd" + i).val() != '')
        $("#budgetUsePercentAdd" + i).val((parseFloat(getNumber($("#budgetUseValueAdd" + i).val())) / budgetUseValueSum * 100).toFixed(2));
      else 
        $("#budgetUsePercentAdd" + i).val("");
    }
    else {
      $("#budgetUsePercentAdd" + i).val(0);
    }
  }

  $(".budgetUsePercentSum").val(100);

}

function budgetSave(){
  $('#loading').show();
  var budgetSourcesNumbers = <?php echo $budgetSourceRowNum; ?>;
  var budgetSourcesJS = JSON.parse('<?php echo json_encode($budgetSources); ?>');
  var budgetUsesNumbers = <?php echo $budgetUseRowNum; ?>;
  var budgetUsesJS = JSON.parse('<?php echo json_encode($budgetUses); ?>');
  var budgetSourcesUpdateData = [];
  var budgetSourcesAddData = [];
  var budgetUsesUpdateData = [];
  var budgetUsesAddData = [];
  var budgetSourcesUpdateDataNumbers = new Array();
  var budgetSourcesDataAddNumbers = new Array();
  var budgetSourcesDataDeleteNumbers = new Array();
  var budgetUsesUpdateDataNumbers = new Array();
  var budgetUsesDataAddNumbers = new Array();
  var budgetUsesDataDeleteNumbers = new Array();
  for(var i = 0; i < budgetSourcesNumbers; i++)
  {
    var index = budgetSourcesJS[i]["budget_id"];
    console.log("index = ", index);
    if($("#budgetSourceRow"+index).css("text-decoration") != "line-through")
    {
      budgetSourcesUpdateDataNumbers.push(index);
      tempUpdateData = [];
      tempUpdateData[0] = $("#budgetSourceName"+index).val();
      tempUpdateData[1] = getNumber($("#budgetSourceValue"+index).val());
      budgetSourcesUpdateData[index] = tempUpdateData;
    }

    if($("#budgetSourceRow"+index).css("text-decoration") == "line-through")
    {
      budgetSourcesDataDeleteNumbers.push(index);
    }
  }

  for(var i = 0; i < addBudgetSourceIndex; i++)
  {
    if($("#budgetSourceRowAdd"+i).css("display") != "none")
    {
      budgetSourcesDataAddNumbers.push(i);
      tempAddData = [];
      tempAddData[0] = $("#budgetSourceNameAdd"+i).val();
      tempAddData[1] = getNumber($("#budgetSourceValueAdd"+i).val());
      budgetSourcesAddData[i] = tempAddData;
    }
  }

  for(var i = 0; i < budgetUsesNumbers; i++)
  {
    var index = budgetUsesJS[i]["budget_id"];
    if($("#budgetUseRow"+index).css("text-decoration") != "line-through")
    {
      budgetUsesUpdateDataNumbers.push(index);
      tempUpdateData = [];
      tempUpdateData[0] = $("#budgetUseName"+index).val();
      tempUpdateData[1] = getNumber($("#budgetUseValue"+index).val());
      budgetUsesUpdateData[index] = tempUpdateData;
    }

    if($("#budgetUseRow"+index).css("text-decoration") == "line-through")
    {
      budgetUsesDataDeleteNumbers.push(index);
    }
  }

  for(var i = 0; i < addBudgetUseIndex; i++)
  {
    if($("#budgetUseRowAdd"+i).css("display") != "none")
    {
      budgetUsesDataAddNumbers.push(i);
      tempAddData = [];
      tempAddData[0] = $("#budgetUseNameAdd"+i).val();
      tempAddData[1] = getNumber($("#budgetUseValueAdd"+i).val());
      budgetUsesAddData[i] = tempAddData;
    }
  }

  console.log("SourceDelete = ");
  console.log(budgetSourcesDataDeleteNumbers);
  console.log("SourceAdd = ");
  console.log(budgetSourcesDataAddNumbers);
  console.log(budgetSourcesAddData);
  console.log("SourceUpdate = ");
  console.log(budgetSourcesUpdateDataNumbers);
  console.log(budgetSourcesUpdateData);

  console.log("UseDelete = ");
  console.log(budgetUsesDataDeleteNumbers);
  console.log("UseAdd = ");
  console.log(budgetUsesDataAddNumbers);
  console.log(budgetUsesAddData);
  console.log("UseUpdate = ");
  console.log(budgetUsesUpdateDataNumbers);
  console.log(budgetUsesUpdateData);
  
  var budgetTotal = getNumber($(".budgetTotal").val());
  if(budgetTotal == '') budgetTotal = 0;
  $.ajax({
    type: "POST",
    url: "saveBudgets.php",
    data: {'deleteSourceIDs' : budgetSourcesDataDeleteNumbers, 'updateSourceIDs': budgetSourcesUpdateDataNumbers, 'updateSourceDatas': budgetSourcesUpdateData, 'addSourceIDs': budgetSourcesDataAddNumbers, 'addSourceDatas': budgetSourcesAddData, 
      'deleteUseIDs' : budgetUsesDataDeleteNumbers, 'updateUseIDs': budgetUsesUpdateDataNumbers, 'updateUseDatas': budgetUsesUpdateData, 'addUseIDs': budgetUsesDataAddNumbers, 'addUseDatas': budgetUsesAddData, 
      'budgetTotal': budgetTotal},
    success: function() {
      $('#loading').hide();
      location.reload();
    },
    error: function(){
      alert('error handing here');
    }
  });
}

function exportToPDF() {
  var budgetSourcesNumbers = <?php echo $budgetSourceRowNum; ?>;
  var budgetSourcesJS = JSON.parse('<?php echo json_encode($budgetSources); ?>');
  var budgetUsesNumbers = <?php echo $budgetUseRowNum; ?>;
  var budgetUsesJS = JSON.parse('<?php echo json_encode($budgetUses); ?>');
  for(var i = 0; i < budgetSourcesNumbers; i++)
  {
    var index = budgetSourcesJS[i]["budget_id"];
    if($("#budgetSourceRow"+index).css("text-decoration") == "line-through")
    {
      alert("Please Save Budget Before Export!");
      return;
    }
  }

  for(var i = 0; i < budgetUsesNumbers; i++)
  {
    var index = budgetUsesJS[i]["budget_id"];
    if($("#budgetUseRow"+index).css("text-decoration") == "line-through")
    {
      alert("Please Save Budget Before Export!");
      return;
    }
  }

  if(addBudgetSourceIndex > 0 || addBudgetUseIndex > 0)
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
    doc.save(projectname +"_budget.pdf");
    location.reload();
  });
}

function buildHTMLToPrint() {
  $(".budget-source-tableToPrint").html("");
  $(".budget-source-table-bottomToPrint").html("");
  $(".budget-use-tableToPrint").html("");
  $(".budget-use-table-bottomToPrint").html("");
  $(".totalBudgetToPrint").html("");
  $(".budget-Source-table > div").each(function(){
    console.log($(this).find(".budgetSourcePercent").val());
    if($(this).css('display') != 'none') {
      var newNode = '<div class="col-md-12 paddingtop10">'
            + '<div class="col-md-6">'
            + '<p><b>' + $(this).find(".budgetSourceName").val() + '</b></p>'
            + '</div>'
            + '<div class="col-md-3">'
            + '<p><b>$' + $(this).find(".budgetSourceValue").val() + '</b></p>'
            + '</div>'
            + '<div class="col-md-3">'
            + '<p><b>' + $(this).find(".budgetSourcePercent").val() + '%</b></p>'
            + '</div>'
            + '</div>';
    }
    $(".budget-source-tableToPrint").append(newNode);
  });
  $(".budget-use-table > div").each(function(){

    if($(this).css('display') != 'none') {
      var newNode = '<div class="col-md-12 paddingtop10">'
            + '<div class="col-md-6">'
            + '<p><b>' + $(this).find(".budgetUseName").val() + '</b></p>'
            + '</div>'
            + '<div class="col-md-3">'
            + '<p><b>$' + $(this).find(".budgetUseValue").val() + '</b></p>'
            + '</div>'
            + '<div class="col-md-3">'
            + '<p><b>' + $(this).find(".budgetUsePercent").val() + '%</b></p>'
            + '</div>'
            + '</div>';
    }
    $(".budget-use-tableToPrint").append(newNode);
  });

  var newNode = '<div class="col-md-6">' 
        + '</div>'
        + '<div class="col-md-3">'
        + '<p><b>$' + $(".budgetSourceValueSum").val() + '</b></p>'
        + '</div>'
        + '<div class="col-md-3">'
        + '<p><b>' + $(".budgetSourcePercentSum").val() + '%</b></p>'
        + '</div>';

  $(".budget-source-table-bottomToPrint").append(newNode);

  var newNode = '<div class="col-md-6">' 
        + '</div>'
        + '<div class="col-md-3">'
        + '<p><b>$' + $(".budgetUseValueSum").val() + '</b></p>'
        + '</div>'
        + '<div class="col-md-3">'
        + '<p><b>' + $(".budgetUsePercentSum").val() + '%</b></p>'
        + '</div>';

  $(".budget-use-table-bottomToPrint").append(newNode);

  var newNode = '<p><b>' + 'Total Project Budget: $' + $(".budgetTotal").val() + '</b></p>';
  $(".totalBudgetToPrint").append(newNode);
}
</script>

<style>

.budgetSourceCell *, .budgetUseCell *, .budget-Source-table-bottom *, .budget-use-table-bottom *{
  text-align: right !important;
}

.budgetSourceName, .budgetUseName {
  text-align: left !important;
}

input[type='checkbox']
{
   margin-top: 10px !important;
}
</style>
<?php
  include("include/footer.php");
?>




