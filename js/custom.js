    jQuery(document).ready(function ($) {
        $('#tabs').tab();
        
           $(".glyphicon-menu-down").on('click', function(event) {
     
   
   $(this).toggleClass("glyphicon-menu-down glyphicon-menu-up");
  
   //$(this).toggleClass("glyphicon-menu-down").toggleClass("glyphicon-menu-up");
   //alert('test');
    
  });
  
        $(".glyphicon-menu-up").on('click', function(event) {
     
   
   $(this).toggleClass("glyphicon-menu-down glyphicon-menu-up");
  
   //$(this).toggleClass("glyphicon-menu-down").toggleClass("glyphicon-menu-up");
   //alert('test');
    
  });
  
    $("#sort_projects").change(function() {       
    sort_projects();
       });
       
  $("#sort_projects").on("mouseover", function(){
    //alert("The paragraph was clicked.");
});
       
    $("#typefilter").change(function() {       
    filterprojects();
       }); 
       
       $("#statusfilter").change(function() {       
    filterprojects();
       });     
        
    });
  
  
  
  function toggle(divname)
  {
    $('#'+divname).toggle();

  }


  $("#sort_projects").change(function() {      
    sort_projects();
       });
       
  $("#sort_projects").on("mouseover", function(){
    //alert("The paragraph was clicked.");
});
       
    $("#typefilter").change(function() {       
    filterprojects();
       }); 
       
       $("#statusfilter").change(function() {       
    filterprojects();
       });       
       

  function filterprojects()
  {
    
    var statusvalue = $("#statusfilter").val();
    var typevalue = $("#typefilter").val();
    
    //alert(statusvalue);
    $(".project").show();
    var filtervalue;
    
    if((statusvalue!= '')&&(typevalue == ''))
    {
      filtervalue = statusvalue;
    }
    
    else if((statusvalue== '')&&(typevalue != ''))
    {
      filtervalue = typevalue;
    }
    else if((statusvalue!= '')&&(typevalue != ''))
    {
      filtervalue = typevalue + statusvalue;
    }
    else
    {
      filtervalue = '';
    }
    
    
    //var filtervalue = ".roadway.planning";
    if(filtervalue != ''){
        $(".project:not("+filtervalue+")").hide();
        }

    
    

 
   }

  

  function filterprojectsold()
  {
    var statusvalue = $("#statussort").val();
    var typevalue = $("#typesort").val();
    var filtervalue = "planning";
    
    //$(".project").not(+statusvalue+typevalue);
        $(".project").show();
      alert("test");        
        if(typeof filtervalue !== undefined){
        $(".project:not("+filtervalue+")").hide();
        }
 
   }   

  function sort_projects()
  {
     option = $( "#sort_projects" ).val();
    
    if(option == 'project_name_asc')
    {tinysort('.project',{order:'asc'});}
    
    if(option == 'project_name_desc')
    {tinysort('.project',{order:'desc'});}
    
       if(option == 'most_recent')
    {tinysort('.project','.recent_activity', {order:'asc'});}
    
    
   }
   
   $(".glyphicon").on('click', function(event) {
     
   $(this).toggleClass("glyphicon-menu-down glyphicon-menu-up");
   //$(this).toggleClass("glyphicon-menu-down").toggleClass("glyphicon-menu-up");
   //alert('test');
    
  });
  

  function setfolder(fid,pid){
    $("#proid").val(pid);
    setTimeout(function(){$("#upfid").val(fid)},300);
  }

  function deletefile(docid){
    if(confirm("Are you sure want to delete this file?") == true){
      $.post("deletefile.php",{
        did : docid
      }, function(response){
        location.reload();
      });  
    }    
  }

  function recoverfile(docid){
    if(confirm("Are you sure want to recover this file?") == true){
      $.post("recoverfile.php",{
        did : docid
      }, function(response){
        location.reload();
      });  
    }    
  }

  function deletefolder(){
    var folderid = $('#demodal_fid').val();
    if (folderid > 0 && folderid < 5)
    {
      //alert("This folder is not allowed to delete!");
      return;
    }
    if(confirm("Are you sure want to delete this folder?") == true){
      $.post("deletefolder.php",{
        did : folderid
      }, function(response){
        location.reload();
      });  
    }    
  }

  function recoverfolder(folderid){
    if(confirm("Are you sure want to recover this folder?") == true){
      $.post("recoverfolder.php",{
        did : folderid
      }, function(response){
        location.reload();
      });  
    }    
  }

  function checkpending(){
    $.post("checkpendings.php",
    {},
    function()
    {
      console.log("checkpending success");
      updateNotification();
    });
  }

  function requestsig(filename, doctype, useremail)
  {
    
    var emails = ['','',''];
    var names = ['','',''];
    var orders = ['','',''];
    if($("#sel_con").val() != "-"){
      emails[0] = users[$("#sel_con").val()]['user_email'];
      names[0] = users[$("#sel_con").val()]['account_firstname'] + " " + users[$("#sel_con").val()]['account_lastname'];
      orders[0] = $("#sel_con_order").val();
    }
    if($("#sel_eng").val() != "-"){
      emails[1]=users[$("#sel_eng").val()]['user_email'];
      names[1] = users[$("#sel_eng").val()]['account_firstname'] + " " + users[$("#sel_eng").val()]['account_lastname'];
      orders[1] = $("#sel_eng_order").val();
    }
    if($("#sel_own").val() != "-"){
      emails[2]=users[$("#sel_own").val()]['user_email'];
      names[2] = users[$("#sel_own").val()]['account_firstname'] + " " + users[$("#sel_own").val()]['account_lastname'];
      orders[2] = $("#sel_own_order").val();
    }

    if(!$("#signerOrderCheck").prop("checked")){
      orders = ['','',''];
    }
    console.log(orders);
    uploadattach(function(attids){
      $.post("requestsignature.php",
      {filename: filename, emails : JSON.stringify(emails), orders : JSON.stringify(orders), names : JSON.stringify(names), attids : attids, useremail : useremail},
      function(claimurl)
      {
            cleanurl = claimurl.trim();
            HelloSign.init('3c822ee48c6bf4865212a8dc8a0b2b53');
            HelloSign.open({
            url: cleanurl,
            debug: false,
            skipDomainVerification: true,
            allowCancel: true,
            messageListener: function(eventData) {
                  $('#loading').hide();
                  if(eventData.signature_request_id){
                    console.log(emails);
                    $.post("savepending.php",{reqid:eventData.signature_request_id, emails : JSON.stringify(emails), filename:filename, pid : projectid, doctype: doctype, attids:attids},function(response){
                      setTimeout(function(){ updateNotification();},500);
                    });
                  }
                }
            });
      });
    });
  }

  function updateNotification(){
    $.post("getNotCount.php",{},function(response){
      console.log("Update Notification");
      if(response != "")
        $("#not_Count").html(response);
    });
  }

  function setReqSig(docname, doctype, useremail){
    $("#doc_name").val(docname);
    $("#doc_type").val(doctype);
    $("#doc_uemail").val(useremail);
  }

  function docReqSig(){
    $("#docSigner").modal('hide');
    
    $('#loading').show();
      var unCount = 0;
  var supportingOrder = $("#signerOrderCheck").prop("checked");
  if($("#doc_signer1").val() == "-"){
    unCount++;
    if($("#doc_signer1_order").val() != "-" && supportingOrder){
      alert("You have to select correct order");
      $('#loading').hide();
      return false;
    }
  } else{
    if($("#doc_signer1_order").val() == "-" && supportingOrder){
      alert("You have to select correct order");
      $('#loading').hide();
      return false;
    }
  }
  if($("#doc_signer2").val() == "-"){
    unCount++;
    if($("#doc_signer2_order").val() != "-" && supportingOrder){
      alert("You have to select correct order");
      $('#loading').hide();
      return false;
    }
  } else {
    if($("#doc_signer2_order").val() == "-" && supportingOrder){
      alert("You have to select correct order");
      $('#loading').hide();
      return false;
    }
  }
  if($("#doc_signer3").val() == "-"){
    unCount++;
    if($("#doc_signer3_order").val() != "-" && supportingOrder){
      alert("You have to select correct order");
      $('#loading').hide();
      return false;
    }
  } else {
    if($("#doc_signer3_order").val() == "-" && supportingOrder){
      alert("You have to select correct order");
      $('#loading').hide();
      return false;
    }
  }
  var return3num = make3num($("#doc_signer1_order").val(), $("#doc_signer2_order").val(), $("#doc_signer3_order").val());
  if (supportingOrder) {
    if(return3num == 1 || return3num == 10 || return3num == 100 || return3num == 12 || return3num == 21 || return3num == 120 || return3num == 102 || return3num == 210 || return3num == 201 || return3num == 123 || return3num == 132 || return3num == 213 || return3num == 231 || return3num == 312 || return3num == 321)
    {

    }
    else {
      alert("You have to select correct order");
      $('#loading').hide();
      return false;
    }
  }
  if(unCount == 3){
    alert("You have to select at least one Signer");
    $('#loading').hide();
    return false;
  }
    var emails = ['','',''];
    var names = ['','',''];
    var orders = ['','',''];
    if($("#doc_signer1").val() != "-"){
      emails[0] = users[$("#doc_signer1").val()]['user_email'];
      names[0] = users[$("#doc_signer1").val()]['account_firstname'] + " " + users[$("#doc_signer1").val()]['account_lastname'];
      orders[0] = $("#doc_signer1_order").val();
    }
    if($("#doc_signer2").val() != "-"){
      emails[1]=users[$("#doc_signer2").val()]['user_email'];
      names[1] = users[$("#doc_signer2").val()]['account_firstname'] + " " + users[$("#doc_signer2").val()]['account_lastname'];
      orders[1] = $("#doc_signer2_order").val();
    }
    if($("#doc_signer3").val() != "-"){
      emails[2]=users[$("#doc_signer3").val()]['user_email'];
      names[2] = users[$("#doc_signer3").val()]['account_firstname'] + " " + users[$("#doc_signer3").val()]['account_lastname'];
      orders[2] = $("#doc_signer3_order").val();
    }

    docname = $("#doc_name").val();
    doctype = $("#doc_type").val();
    useremail = $("#doc_uemail").val();
    if(!supportingOrder) {
      orders = ['','',''];
    }
    console.log(orders);
    var fname = "";
    if(docname.slice(-4,-3) == ".")
      fname = docname.slice(0,-4)+"_sign.pdf";
    else
      fname = docname.slice(0,-5)+"_sign.pdf";
    $.post("requestsignature.php",
      {filename: docname, fromdoc : "1", useremail : useremail, emails : JSON.stringify(emails), orders : JSON.stringify(orders) ,names : JSON.stringify(names) },
      function(claimurl)
      {
            cleanurl = claimurl.trim();
            HelloSign.init('3c822ee48c6bf4865212a8dc8a0b2b53');
            HelloSign.open({
            url: cleanurl,
            debug: false,
            skipDomainVerification: true,
            allowCancel: true,
            messageListener: function(eventData) {
                  $('#loading').hide();
                  console.log(eventData);
                  console.log(projectid);
                  if(eventData.signature_request_id){
                    $.post("savepending.php",{reqid:eventData.signature_request_id, emails : JSON.stringify(emails), filename:fname, pid : projectid, doctype: doctype},function(response){
                      setTimeout(function(){ updateNotification();},500);
                    });
                  }
                }
            });
      });
  }

  function openSignURL(url){
    if(url == "Error"){
      alert("Previous signers need to sign on this doc.");
      return;
    }
    HelloSign.init("3c822ee48c6bf4865212a8dc8a0b2b53");
    HelloSign.open({
        url: url,
        allowCancel: true,
        debug: false,
        skipDomainVerification: true,
        messageListener: function(eventData) {
          console.log(eventData);
          if(eventData.event == "signature_request_signed"){
            setTimeout(function(){ checkpending(); }, 2000);
            setTimeout(function(){location.reload();},3000);
          }
        }
    });
  }

  function orderrequestsig(filename, doctype, useremail)
  {
    var emails = ['','',''];
    var names = ['','',''];
    var orders = ['','',''];
    if($("#order_sel_con").val() != "-"){
      emails[0] = users[$("#order_sel_con").val()]['user_email'];
      names[0] = users[$("#order_sel_con").val()]['account_firstname'] + " " + users[$("#order_sel_con").val()]['account_lastname'];
      orders[0] = $("#order_sel_con_order").val();
    }
    if($("#order_sel_eng").val() != "-"){
      emails[1]=users[$("#order_sel_eng").val()]['user_email'];
      names[1] = users[$("#order_sel_eng").val()]['account_firstname'] + " " + users[$("#order_sel_eng").val()]['account_lastname'];
      orders[1] = $("#order_sel_eng_order").val();
    }
    if($("#order_sel_own").val() != "-"){
      emails[2]=users[$("#order_sel_own").val()]['user_email'];
      names[2] = users[$("#order_sel_own").val()]['account_firstname'] + " " + users[$("#order_sel_own").val()]['account_lastname'];
      orders[2] = $("#order_sel_own_order").val();
    }
    if(!$("#signerOrderCheck").prop("checked")) {
      orders = ['','',''];
    }
  uploadattach(function(attids){
      $.post("requestsignature.php",
      {filename: filename, emails : JSON.stringify(emails), orders : JSON.stringify(orders), names : JSON.stringify(names), attids : attids, useremail : useremail},
      function(claimurl)
      {
            cleanurl = claimurl.trim();
            HelloSign.init('3c822ee48c6bf4865212a8dc8a0b2b53');
            HelloSign.open({
            url: cleanurl,
            debug: false,
            skipDomainVerification: true,
            allowCancel: true,
            messageListener: function(eventData) {
                  $('#loading').hide();
                  console.log(eventData);
                  console.log(projectid);
                  if(eventData.signature_request_id){
                    console.log(emails);
                    $.post("savepending.php",{reqid:eventData.signature_request_id, emails : JSON.stringify(emails), filename:filename, pid : projectid, doctype: doctype, attids:attids},function(response){
                      setTimeout(function(){ updateNotification();},500);
                    });
                  }
                }
            });
      });
    });
    
    
  }

  function dailyrequestsig(filename, doctype, useremail)
  {
    var emails = ['','',''];
    var names = ['','',''];
    var orders = ['', '', ''];
    if($("#daily_sel_con").val() != "-"){
      emails[0] = users[$("#daily_sel_con").val()]['user_email'];
      names[0] = users[$("#daily_sel_con").val()]['account_firstname'] + " " + users[$("#daily_sel_con").val()]['account_lastname'];
    }
    if($("#daily_sel_eng").val() != "-"){
      emails[1]=users[$("#daily_sel_eng").val()]['user_email'];
      names[1] = users[$("#daily_sel_eng").val()]['account_firstname'] + " " + users[$("#daily_sel_eng").val()]['account_lastname'];
    }
    if($("#daily_sel_own").val() != "-"){
      emails[2]=users[$("#daily_sel_own").val()]['user_email'];
      names[2] = users[$("#daily_sel_own").val()]['account_firstname'] + " " + users[$("#daily_sel_own").val()]['account_lastname'];
    }
    
    uploadattach(function(attids){
      $.post("requestsignature.php",
      {filename: filename, emails : JSON.stringify(emails), orders : JSON.stringify(orders), names : JSON.stringify(names), attids : attids, useremail : useremail},
      function(claimurl)
      {
            cleanurl = claimurl.trim();
            HelloSign.init('3c822ee48c6bf4865212a8dc8a0b2b53');
            HelloSign.open({
            url: cleanurl,
            debug: false,
            skipDomainVerification: true,
            allowCancel: true,
            messageListener: function(eventData) {
                  $('#loading').hide();
                  console.log(eventData);
                  console.log(projectid);
                  if(eventData.signature_request_id){
                    console.log(emails);
                    $.post("savepending.php",{reqid:eventData.signature_request_id, emails : JSON.stringify(emails), filename:filename, pid : projectid, doctype: doctype, attids:attids},function(response){
                      setTimeout(function(){ updateNotification();},500);
                    });
                  }
                }
            });
      });
    });
    
  }

  function fdotrequestsig(filename, doctype, useremail)
  {
    var emails = ['','',''];
    var names = ['','',''];
    var orders = ['', '', ''];
    if($("#fdot_sel_con").val() != "-"){
      emails[0] = users[$("#fdot_sel_con").val()]['user_email'];
      names[0] = users[$("#fdot_sel_con").val()]['account_firstname'] + " " + users[$("#fdot_sel_con").val()]['account_lastname'];
    }
    if($("#fdot_sel_eng").val() != "-"){
      emails[1]=users[$("#fdot_sel_eng").val()]['user_email'];
      names[1] = users[$("#fdot_sel_eng").val()]['account_firstname'] + " " + users[$("#fdot_sel_eng").val()]['account_lastname'];
    }
    if($("#fdot_sel_own").val() != "-"){
      emails[2]=users[$("#fdot_sel_own").val()]['user_email'];
      names[2] = users[$("#fdot_sel_own").val()]['account_firstname'] + " " + users[$("#fdot_sel_own").val()]['account_lastname'];
    }
    
   uploadattach(function(attids){
      $.post("requestsignature.php",
      {filename: filename, emails : JSON.stringify(emails), orders : JSON.stringify(orders), names : JSON.stringify(names), attids : attids, useremail : useremail},
      function(claimurl)
      {
            cleanurl = claimurl.trim();
            HelloSign.init('3c822ee48c6bf4865212a8dc8a0b2b53');
            HelloSign.open({
            url: cleanurl,
            debug: false,
            skipDomainVerification: true,
            allowCancel: true,
            messageListener: function(eventData) {
                  $('#loading').hide();
                  console.log(eventData);
                  console.log(projectid);
                  if(eventData.signature_request_id){
                    console.log(emails);
                    $.post("savepending.php",{reqid:eventData.signature_request_id, emails : JSON.stringify(emails), filename:filename, pid : projectid, doctype: doctype, attids:attids},function(response){
                      setTimeout(function(){ updateNotification();},500);
                    });
                  }
                }
            });
      });
    });
    
    
  }

  function pullRequest(reqid){
    $('#loading').show();
    $.post("pullrequest.php",
      {reqid: reqid},
      function(response){
        $('#loading').hide();
        location.reload();
      });
  }

  function sendReminder(reqid){
    $('#loading').show();
    $.post("sendreminder.php",
      {reqid: reqid},
      function(response){
        $('#loading').hide();
        
      });
  }
  
  function makepdf(name)
  {

    var pdf = new jsPDF();
    pdf.addHTML($('#toprint').get(0),function() {
        pdf.save(name);  
    });  
  }
  
  function loadDoc() {
  window.open('contractstatusprint.php')
}


function savepdftolocation(projectname, doctype ,projectid, callback)
{

    var doc = new jsPDF();
    doc.addHTML($('#toprint').get(0),function() {  
    var pdf = btoa(doc.output()); 
    $('#toprint').hide();
    $.ajax({
        type: "POST",
        url: "/uploadpdf.php",
        data: {data: pdf, projectname: projectname, projectid: projectid, doctype: doctype},
      }).done(function(response){
        
        callback(response);
      });

    });

}

function ordersavepdftolocation(projectname, doctype ,projectid, callback)
{

    var doc = new jsPDF();
    doc.addHTML($('#ordertoprint').get(0),function() { 
    $('#ordertoprint').hide(); 
    var pdf = btoa(doc.output()); 
    $.ajax({
        type: "POST",
        url: "/uploadpdf.php",
        data: {data: pdf, projectname: projectname, projectid: projectid, doctype: doctype},
      }).done(function(response){
         callback(response);
      });

    });

}

function dailysavepdftolocation(projectname, doctype ,projectid, callback)
{

    var doc = new jsPDF();
    doc.addHTML($('#dailytoprint').get(0),function() {  
      $('#dailytoprint').hide(); 
    var pdf = btoa(doc.output()); 
    $.ajax({
        type: "POST",
        url: "/uploadpdf.php",
        data: {data: pdf, projectname: projectname, projectid: projectid, doctype: doctype},
      }).done(function(response){
         callback(response);
      });

    });

}

function fdotsavepdftolocation(projectname, doctype ,projectid, callback)
{

    var doc = new jsPDF();
    doc.addHTML($('#fdottoprint').get(0),function() {  
      $('#fdottoprint').hide(); 
    var pdf = btoa(doc.output()); 
    $.ajax({
        type: "POST",
        url: "/uploadpdf.php",
        data: {data: pdf, projectname: projectname, projectid: projectid, doctype: doctype},
      }).done(function(response){
         callback(response);
      });

    });

}


  
function savecontractstatus2()
{
        $('#toprint').show();
  $.when( makepdf() ).done(function(){
       $.when( savepdftolocation(name, 1)).done(function(){
     $('#toprint').hide();
  });
    
  });

 
}

function savecontractstatus()
{
  contractstatushiddenchanges();

  var datastring = $("#contractstatusform").serialize();
  datastring = datastring + "&location=" + name;
    $.ajax({
            type: "POST",
            url: "contractstatussave.php",
            data: datastring,
            success: function() {
                console.log("success");
            },
            error: function(){
                  alert('error handing here');
            }
        });

}
function uploadattach(callback){
  var filedata = document.getElementById("input_file"),formdata = false;
  if (window.FormData) {
    formdata = new FormData(document.getElementById("file_attach"));
  }

  if (formdata) {
    $.ajax({
      url: "uploadattachment.php",
      type: "POST",
      data: formdata,
      processData: false,
      contentType: false,
      success: function(res) {
        callback(res);
      },       
      error: function(res) {

       }       
    });
  }

}

function make3num(int1, int2, int3){
  if(int1 == "-") {
    int1 = 0;
  }
  else{
    int1 = parseInt(int1);
  }
  if(int2 == "-") {
    int2 = 0;
  }
  else{
    int2 = parseInt(int2);
  }
  if(int3 == "-") {
    int3 = 0;
  }
  else{
    int3 = parseInt(int3);
  }
  return int1*100 + int2*10 + int3;
}

function sendcontractstatusforsig(doctype, projectname, useremail)
{
  savecontractstatus();
  contractstatushiddenchanges();
  var unCount = 0;

  $("#row_con").show();
  $("#row_eng").show();
  $("#row_own").show();
  $("#sign_con").show();
  $("#sign_eng").show();
  $("#sign_own").show();
  var supportingOrder = $("#signerOrderCheck").prop("checked");
  if($("#sel_con").val() == "-"){
    unCount++;
    $("#row_con").hide();
    $("#sign_con").hide();
    if($("#sel_con_order").val() != "-" && supportingOrder){

      alert("You have to select correct order");
      return false;
    }
  } else{
    $(".con_orgName").html(users[$("#sel_con").val()]['account_organization']);
    $(".con_firstName").html(users[$("#sel_con").val()]['account_firstname']);
    $(".con_lastName").html(users[$("#sel_con").val()]['account_lastname']);
    $(".con_grouptype").html(users[$("#sel_con").val()]['account_organization_type']);
    $("#con_Address").html(users[$("#sel_con").val()]['account_location']);
    $("#con_zip").html(users[$("#sel_con").val()]['account_zip']);
    $("#con_fax").html(users[$("#sel_con").val()]['account_fax']);
    $("#con_Name").html(users[$("#sel_con").val()]['account_firstname'] + " " + users[$("#sel_con").val()]['account_lastname'] + ", "+users[$("#sel_con").val()]['account_title']);
    $("#con_phone").html(users[$("#sel_con").val()]['account_phone']);
    if($("#sel_con_order").val() == "-" && supportingOrder){
      alert("You have to select correct order");
      return false;
    }
  }
  if($("#sel_eng").val() == "-"){
    unCount++;
    $("#row_eng").hide();
    $("#sign_eng").hide();
    if($("#sel_eng_order").val() != "-" && supportingOrder){
      alert("You have to select correct order");
      return false;
    }
  } else {
    if($("#sel_eng_order").val() == "-" && supportingOrder){

      alert("You have to select correct order");
      return false;
    }
    $(".eng_orgName").html(users[$("#sel_eng").val()]['account_organization']);
    $(".eng_firstName").html(users[$("#sel_eng").val()]['account_firstname']);
    $(".eng_lastName").html(users[$("#sel_eng").val()]['account_lastname']);
    $(".eng_grouptype").html(users[$("#sel_eng").val()]['account_organization_type']);
    $("#eng_Address").html(users[$("#sel_eng").val()]['account_location']);
    $("#eng_Name").html(users[$("#sel_eng").val()]['account_firstname'] + " " + users[$("#sel_eng").val()]['account_lastname'] + ", "+users[$("#sel_eng").val()]['account_title']);
    $("#eng_phone").html(users[$("#sel_eng").val()]['account_phone']);
    $("#eng_zip").html(users[$("#sel_eng").val()]['account_zip']);
    $("#eng_fax").html(users[$("#sel_eng").val()]['account_fax']);
  }
  if($("#sel_own").val() == "-"){
    unCount++;
    if($("#sel_own_order").val() != "-" && supportingOrder){
      alert("You have to select correct order");
      return false;
    }
    $("#row_own").hide();
    $("#sign_own").hide();
  } else {
    if($("#sel_own_order").val() == "-" && supportingOrder){
      alert("You have to select correct order");
      return false;
    }
    $(".own_orgName").html(users[$("#sel_own").val()]['account_organization']);
    $(".own_firstName").html(users[$("#sel_own").val()]['account_firstname']);
    $(".own_lastName").html(users[$("#sel_own").val()]['account_lastname']);
    $(".own_grouptype").html(users[$("#sel_own").val()]['account_organization_type']);
    $("#own_Address").html(users[$("#sel_own").val()]['account_location']);
    $("#own_Name").html(users[$("#sel_own").val()]['account_firstname'] + " " + users[$("#sel_own").val()]['account_lastname'] + ", "+users[$("#sel_own").val()]['account_title']);
    $("#own_phone").html(users[$("#sel_own").val()]['account_phone']);
    $("#own_zip").html(users[$("#sel_own").val()]['account_zip']);
    $("#own_fax").html(users[$("#sel_own").val()]['account_fax']);
  }
  var return3num = make3num($("#sel_con_order").val(), $("#sel_eng_order").val(), $("#sel_own_order").val());
  if(supportingOrder) {
    if(return3num == 1 || return3num == 10 || return3num == 100 || return3num == 12 || return3num == 21 || return3num == 120 || return3num == 102 || return3num == 210 || return3num == 201 || return3num == 123 || return3num == 132 || return3num == 213 || return3num == 231 || return3num == 312 || return3num == 321)
    {

    }
    else {

      alert("You have to select correct order");
      return false;
    }
  }
  if(unCount == 3){
    alert("You have to select at least one Signer");
    return false;
  }
  $('#loading').show();
  $('#toprint').show();
  savepdftolocation(projectname, doctype, 1,function(filename){
    $('#toprint').hide();
    var newfile = "files/" + name;
    requestsig(filename, doctype,useremail);
    $('#goodalert').show();
  });
}

function printcontractstatus(doctype, projectname)
{
  savecontractstatus();
  contractstatushiddenchanges();

  var unCount = 0;

  $("#row_con").show();
  $("#row_eng").show();
  $("#row_own").show();
  $("#sign_con").show();
  $("#sign_eng").show();
  $("#sign_own").show();

  if($("#sel_con").val() == "-"){
    unCount++;
    $("#row_con").hide();
    $("#sign_con").hide();
  } else{
    $(".con_orgName").html(users[$("#sel_con").val()]['account_organization']);
    $(".con_firstName").html(users[$("#sel_con").val()]['account_firstname']);
    $(".con_lastName").html(users[$("#sel_con").val()]['account_lastname']);
    $(".con_grouptype").html(users[$("#sel_con").val()]['account_organization_type']);
    $("#con_Address").html(users[$("#sel_con").val()]['account_location']);
    $("#con_zip").html(users[$("#sel_con").val()]['account_zip']);
    $("#con_fax").html(users[$("#sel_con").val()]['account_fax']);
    $("#con_Name").html(users[$("#sel_con").val()]['account_firstname'] + " " + users[$("#sel_con").val()]['account_lastname'] + ", "+users[$("#sel_con").val()]['account_title']);
    $("#con_phone").html(users[$("#sel_con").val()]['account_phone']);
  }
  if($("#sel_eng").val() == "-"){
    unCount++;
    $("#row_eng").hide();
    $("#sign_eng").hide();
  } else {
    $(".eng_orgName").html(users[$("#sel_eng").val()]['account_organization']);
    $(".eng_firstName").html(users[$("#sel_eng").val()]['account_firstname']);
    $(".eng_lastName").html(users[$("#sel_eng").val()]['account_lastname']);
    $(".eng_grouptype").html(users[$("#sel_eng").val()]['account_organization_type']);
    $("#eng_Address").html(users[$("#sel_eng").val()]['account_location']);
    $("#eng_Name").html(users[$("#sel_eng").val()]['account_firstname'] + " " + users[$("#sel_eng").val()]['account_lastname'] + ", "+users[$("#sel_eng").val()]['account_title']);
    $("#eng_phone").html(users[$("#sel_eng").val()]['account_phone']);
    $("#eng_zip").html(users[$("#sel_eng").val()]['account_zip']);
    $("#eng_fax").html(users[$("#sel_eng").val()]['account_fax']);
  }
  if($("#sel_own").val() == "-"){
    unCount++;
    $("#row_own").hide();
    $("#sign_own").hide();
  } else {
    $(".own_orgName").html(users[$("#sel_own").val()]['account_organization']);
    $(".own_firstName").html(users[$("#sel_own").val()]['account_firstname']);
    $(".own_lastName").html(users[$("#sel_own").val()]['account_lastname']);
    $(".own_grouptype").html(users[$("#sel_own").val()]['account_organization_type']);
    $("#own_Address").html(users[$("#sel_own").val()]['account_location']);
    $("#own_Name").html(users[$("#sel_own").val()]['account_firstname'] + " " + users[$("#sel_own").val()]['account_lastname'] + ", "+users[$("#sel_own").val()]['account_title']);
    $("#own_phone").html(users[$("#sel_own").val()]['account_phone']);
    $("#own_zip").html(users[$("#sel_own").val()]['account_zip']);
    $("#own_fax").html(users[$("#sel_own").val()]['account_fax']);
  }


  if(unCount == 3){
    alert("You have to select at least one Signer");
    return false;
  }
  
  $('#loading').show();
  $('#toprint').show();
  savepdftolocation(projectname, doctype, 1 ,function(){
    savecontract(projectname, doctype);
    $('#goodalert').show();
  });
}

function savecontract(projectname, doctype){
  $.ajax({
    type: "POST",
    url: "savecontract.php",
    data: {projectname : projectname, doctype : doctype},
    success: function() {
      $('#loading').hide();
      location.reload();
    },
    error: function(){
      alert('error handing here');
    }
  });
}

function contractstatuscalcs()
{
  var noticetoproceed =  $('[name="noticetoproceed"]').val();
  var daystocomplete =  $('[name="daystocomplete"]').val();
  if((noticetoproceed != '')&&(daystocomplete !=''))
  {
  var originalcompletion = moment(noticetoproceed, "MM-DD-YYYY").add( daystocomplete,'days');
  $('[name="originalcompletedate"]').val(originalcompletion.format('MM/DD/YYYY'));
  }

  var daystosubcomplete =  $('[name="daystosubcomplete"]').val();
  if((noticetoproceed != '')&&(daystocomplete !=''))
  {
  var originalsubstcompletedate = moment(noticetoproceed, "MM-DD-YYYY").add( daystosubcomplete,'days');
  $('[name="originalsubstcompletedate"]').val(originalsubstcompletedate.format('MM/DD/YYYY'));
  }
  
  var originalcompletiondate =  $('[name="originalcompletedate"]').val();
  var daysextension =  $('[name="daysextension"]').val();
  
  if((originalcompletiondate != '')&&(daysextension !=''))
  {
  var newcompletedate = moment(originalcompletiondate, "MM-DD-YYYY").add(daysextension, 'days');
  $('[name="newcompletedate"]').val(newcompletedate.format('MM/DD/YYYY'));
  }

  var subcompletiondate =  $('[name="originalsubstcompletedate"]').val();
  var dayssubextension =  $('[name="dayssubextension"]').val();
  
  if((subcompletiondate != '')&&(dayssubextension !=''))
  {
  var newsubcompletedate = moment(subcompletiondate, "MM-DD-YYYY").add(dayssubextension, 'days');
  $('[name="newsubcompletedate"]').val(newsubcompletedate.format('MM/DD/YYYY'));
  }
  
  var originalcontractamt =  $('[name="originalcontractamt"]').val();
  var revisedcontractamt =  $('[name="revisedcontractamt"]').val();
  
  if((originalcontractamt != '')&&(revisedcontractamt !=''))
  {
    originalcontractamt = parseFloat(originalcontractamt, 10);
    revisedcontractamt = parseFloat(revisedcontractamt, 10);
    adjtodate = revisedcontractamt - originalcontractamt;
    $('[name="adjtodate"]').val(adjtodate.toFixed(2));
  }
  
  var percentcompl = $('[name="percentcompl"]').val();
  if((percentcompl != '')&&(revisedcontractamt !=''))
  {
    percentcompl = parseFloat(percentcompl, 10);
    totworkcompl = percentcompl * revisedcontractamt / 100;
    $('[name="totalworkcompleted"]').val(totworkcompl.toFixed(2));
    
  }

  var totalworkcompleted = $('[name="totalworkcompleted"]').val();
  var prepayment = $('[name="prepayment"]').val();
  var materialstoredonsite = $('[name="materialstoredonsite"]').val();
  if((totalworkcompleted != '')&&(prepayment !='')&&(materialstoredonsite !=''))
  {
    totalworkcompleted = parseFloat(totalworkcompleted, 10);
    prepayment = parseFloat(prepayment, 10);
    materialstoredonsite = parseFloat(materialstoredonsite, 10);
    subtotal1 = totalworkcompleted + prepayment + materialstoredonsite;
    $('[name="subtotal1"]').val(subtotal1.toFixed(2));
  }
  
  var subtotal1 = $('[name="subtotal1"]').val();
  var liquiddamage = $('[name="liquiddamage"]').val();
  if((subtotal1 != '0')&&(liquiddamage !=''))
  {
    subtotal1 = parseFloat(subtotal1);
    liquiddamage = parseFloat(liquiddamage );
    subtotal2 = subtotal1 - liquiddamage ;
    $('[name="subtotal2"]').val(subtotal2.toFixed(2));
    
  }
  
  var subtotal2 = $('[name="subtotal2"]').val();
  var retainage = $('[name="retainage"]').val();
  if((subtotal2 != '0')&&(retainage !=''))
  {
    subtotal2 = parseFloat(subtotal2);
    retainage = parseFloat(retainage);
    retainagedollars = (retainage/100) * subtotal2;
    subtotal3 = subtotal2 * (1 - (retainage/100)) ;
    $('[name="subtotal3"]').val(subtotal3.toFixed(2));
    $('[name="retainagedollar"]').val(retainagedollars.toFixed(2));
    
  }
  
  var subtotal3 = $('[name="subtotal3"]').val();
  var previouspayment = $('[name="previouspayment"]').val();
  if((subtotal3 != '0')&&(previouspayment !=''))
  {
    subtotal3 = parseFloat(subtotal3);
    previouspayment = parseFloat(previouspayment);
    amountdue = subtotal3 - previouspayment ;
    $('[name="amountdue"]').val(amountdue.toFixed(2));
    
  }
}



var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

function checkfolders(fid, pid, fname){
  console.log(fid);
  $("#demodal_deletebutton").show();
  if(parseInt(fid) <= 4){
    $("#demodal_fName").prop("disabled", true);  
    $("#demodal_deletebutton").hide();  
  }

  
  $("#demodal_fName").val(fname);
  $("#demodal_fid").val(fid);
  $("#demodal_pid").val(pid);
  $(".fgroup_check input").each(function(){
    $(this).prop('checked',false);
  })
  $.ajax({
    type: "POST",
    url: "getgfrelation.php",
    data: {pid:pid, fid:fid},
    success: function(res) {
      arr = JSON.parse(res);
      for(var i=0; i<arr.length;i++){
        $("#group_"+arr[i]['id']).prop('checked',true);
      }
    },
    error: function(){
      alert('error handing here');
    }
  });
}
Number.prototype.format = function(n, x, s, c) {
    if(isNaN(this))
      return 0;
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};
function contractstatushiddenchanges()
{
  
  var currentdate = new Date(); 
  var datetime = (((currentdate.getMonth()+1) < 10)?"0":"") + (currentdate.getMonth()+1) + "/"
                + ((currentdate.getDate() < 10)?"0":"") + currentdate.getDate()  + "/" 
                + currentdate.getFullYear();
  $('#cdate_from').html( $('#input_cfrom').val());
  $('#cdate_to').html( $('#input_cto').val());       
   
  $("#con_sub_date").html(datetime);

  $('#bidsreceiveddate').html( $('[name="bidsreceiveddate"]').val());
  $('#contractdate').html( $('[name="contractdate"]').val());
  $('#noticetoproceed').html( $('[name="noticetoproceed"]').val());
  $('#daystocomplete').html( $('[name="daystocomplete"]').val());
  $('#daystosubcomplete').html( $('[name="daystosubcomplete"]').val());
  $('#originalsubstcompletedate').html( $('[name="originalsubstcompletedate"]').val());
  $('#originalcompletedate').html( $('[name="originalcompletedate"]').val());

  $('#dayssubextension').html( $('[name="dayssubextension"]').val());
  $('#daysextension').html( $('[name="daysextension"]').val());
  $('#newsubcompletedate').html( $('[name="newsubcompletedate"]').val());
  $('#newcompletedate').html( $('[name="newcompletedate"]').val());

  $('#originalcontractamt').html("$" + parseInt($('[name="originalcontractamt"]').val()).format(2,3,",","."));
  $('#revisedcontractamt').html("$" + parseInt($('[name="revisedcontractamt"]').val()).format(2,3,",","."));
  $('#adjtodate').html("$" + parseInt($('[name="adjtodate"]').val()).format(2,3,",","."));
  $('#percentcompl').html(parseInt( $('[name="percentcompl"]').val()).format(2,3,",",".") + "%");
  $('#totalworkcompleted').html("$" + parseInt($('[name="totalworkcompleted"]').val()).format(2,3,",","."));
  $('#prepayment').html("$" + parseInt($('[name="prepayment"]').val()).format(2,3,",","."));
  $('#materialstoredonsite').html("$" + parseInt($('[name="materialstoredonsite"]').val()).format(2,3,",","."));
  $('#subtotal1').html("$" + parseInt($('[name="subtotal1"]').val()).format(2,3,",","."));
  $('#liquiddamage').html("$" + parseInt($('[name="liquiddamage"]').val()).format(2,3,",","."));
  $('#subtotal2').html("$" + parseInt($('[name="subtotal2"]').val()).format(2,3,",","."));
  $('#retainage').html( parseInt($('[name="retainage"]').val()).format(2,3,",",".") + "%");
  $('#retainagedollar').html("$" + parseInt($('[name="retainagedollar"]').val()).format(2,3,",","."));
  $('#subtotal3').html("$" + parseInt($('[name="subtotal3"]').val()).format(2,3,",","."));
  $('#previouspayment').html("$" + parseInt($('[name="previouspayment"]').val()).format(2,3,",","."));
  $('#amountdue').html("$" + parseInt($('[name="amountdue"]').val()).format(2,3,",","."));
  
}
   

function savecontractchangeorder()
{
  contractchangeorderhiddenchanges();

  var datastring = $("#contractchangeorderform").serialize();
  datastring = datastring + "&location=" + name;
  $.ajax({
          type: "POST",
          url: "contractchangeordersave.php",
          data: datastring,
          success: function() {
              console.log("success");
          },
          error: function(){
                alert('error handing here');
          }
      });

}

function sendcontractchangeorderforsig(doctype, projectname, useremail)
{
  savecontractchangeorder();
  contractchangeorderhiddenchanges();

  var unCount = 0;

  $("#order_row_con").show();
  $("#order_row_eng").show();
  $("#order_row_own").show();
  $("#order_sign_con").show();
  $("#order_sign_eng").show();
  $("#order_sign_own").show();
  var supportingOrder = $("#signerOrderCheck").prop("checked");
  if($("#order_sel_con").val() == "-"){
    if($("#order_sel_con_order").val() != "-" && supportingOrder){
      alert("You have to select correct order");
      return false;
    }
    unCount++;
    $("#order_row_con").hide();
    $("#order_sign_con").hide();
  } else{
    if($("#order_sel_con_order").val() == "-" && supportingOrder){
      alert("You have to select correct order");
      return false;
    }
    $(".order_con_orgName").html(users[$("#order_sel_con").val()]['account_organization']);
    $(".order_con_firstName").html(users[$("#order_sel_con").val()]['account_firstname']);
    $(".order_con_lastName").html(users[$("#order_sel_con").val()]['account_lastname']);
    $(".order_con_grouptype").html(users[$("#order_sel_con").val()]['account_organization_type']);
    $("#order_con_Address").html(users[$("#order_sel_con").val()]['account_location']);
    $("#order_con_zip").html(users[$("#order_sel_con").val()]['account_zip']);
    $("#order_con_fax").html(users[$("#order_sel_con").val()]['account_fax']);
    $("#order_con_Name").html(users[$("#order_sel_con").val()]['account_firstname'] + " " + users[$("#order_sel_con").val()]['account_lastname'] + ", "+users[$("#order_sel_con").val()]['account_title']);
    $("#order_con_phone").html(users[$("#order_sel_con").val()]['account_phone']);
  }
  if($("#order_sel_eng").val() == "-"){
    if($("#order_sel_eng_order").val() != "-" && supportingOrder){
      alert("You have to select correct order");
      return false;
    }
    unCount++;
    $("#order_row_eng").hide();
    $("#order_sign_eng").hide();
  } else {
    if($("#order_sel_eng_order").val() == "-" && supportingOrder){
      alert("You have to select correct order");
      return false;
    }
    $(".order_eng_orgName").html(users[$("#order_sel_eng").val()]['account_organization']);
    $(".order_eng_firstName").html(users[$("#order_sel_eng").val()]['account_firstname']);
    $(".order_eng_lastName").html(users[$("#order_sel_eng").val()]['account_lastname']);
    $(".order_eng_grouptype").html(users[$("#order_sel_eng").val()]['account_organization_type']);
    $("#order_eng_Address").html(users[$("#order_sel_eng").val()]['account_location']);
    $("#order_eng_Name").html(users[$("#order_sel_eng").val()]['account_firstname'] + " " + users[$("#order_sel_eng").val()]['account_lastname'] + ", "+users[$("#order_sel_eng").val()]['account_title']);
    $("#order_eng_phone").html(users[$("#order_sel_eng").val()]['account_phone']);
    $("#order_eng_zip").html(users[$("#order_sel_eng").val()]['account_zip']);
    $("#order_eng_fax").html(users[$("#order_sel_eng").val()]['account_fax']);
  }
  if($("#order_sel_own").val() == "-"){
    if($("#order_sel_own_order").val() != "-" && supportingOrder){
      alert("You have to select correct order");
      return false;
    }
    unCount++;
    $("#order_row_own").hide();
    $("#order_sign_own").hide();
  } else {
    if($("#order_sel_own_order").val() == "-" && supportingOrder){
      alert("You have to select correct order");
      return false;
    }
    $(".order_own_orgName").html(users[$("#order_sel_own").val()]['account_organization']);
    $(".order_own_firstName").html(users[$("#order_sel_own").val()]['account_firstname']);
    $(".order_own_lastName").html(users[$("#order_sel_own").val()]['account_lastname']);
    $(".order_own_grouptype").html(users[$("#order_sel_own").val()]['account_organization_type']);
    $("#order_own_Address").html(users[$("#order_sel_own").val()]['account_location']);
    $("#order_own_Name").html(users[$("#order_sel_own").val()]['account_firstname'] + " " + users[$("#order_sel_own").val()]['account_lastname'] + ", "+users[$("#order_sel_own").val()]['account_title']);
    $("#order_own_phone").html(users[$("#order_sel_own").val()]['account_phone']);
    $("#order_own_zip").html(users[$("#order_sel_own").val()]['account_zip']);
    $("#order_own_fax").html(users[$("#order_sel_own").val()]['account_fax']);
  }
  var return3num = make3num($("#order_sel_con_order").val(), $("#order_sel_eng_order").val(), $("#order_sel_own_order").val());
  if(supportingOrder)
  {
    if(return3num == 1 || return3num == 10 || return3num == 100 || return3num == 12 || return3num == 21 || return3num == 120 || return3num == 102 || return3num == 210 || return3num == 201 || return3num == 123 || return3num == 132 || return3num == 213 || return3num == 231 || return3num == 312 || return3num == 321)
    {

    }
    else {
      alert("You have to select correct order");
      return false;
    }
  }
  if(unCount == 3){
    alert("You have to select at least one Signer");
    return false;
  }

  
  $('#loading').show();
  $('#ordertoprint').show();
  ordersavepdftolocation(projectname, doctype, 1,function(filename){
    $('#ordertoprint').hide();
    var newfile = "files/" + name;
    orderrequestsig(filename, doctype, useremail);
    $('#goodalert').show();
  });
}

function printcontractchangeorder(doctype, projectname)
{
  savecontractchangeorder();
  contractchangeorderhiddenchanges();

  var unCount = 0;

  $("#order_row_con").show();
  $("#order_row_eng").show();
  $("#order_row_own").show();
  $("#order_sign_con").show();
  $("#order_sign_eng").show();
  $("#order_sign_own").show();

 if($("#order_sel_con").val() == "-"){
    unCount++;
    $("#order_row_con").hide();
    $("#order_sign_con").hide();
  } else{
    $(".order_con_orgName").html(users[$("#order_sel_con").val()]['account_organization']);
    $(".order_con_firstName").html(users[$("#order_sel_con").val()]['account_firstname']);
    $(".order_con_lastName").html(users[$("#order_sel_con").val()]['account_lastname']);
    $(".order_con_grouptype").html(users[$("#order_sel_con").val()]['account_organization_type']);
    $("#order_con_Address").html(users[$("#order_sel_con").val()]['account_location']);
    $("#order_con_zip").html(users[$("#order_sel_con").val()]['account_zip']);
    $("#order_con_fax").html(users[$("#order_sel_con").val()]['account_fax']);
    $("#order_con_Name").html(users[$("#order_sel_con").val()]['account_firstname'] + " " + users[$("#order_sel_con").val()]['account_lastname'] + ", "+users[$("#order_sel_con").val()]['account_title']);
    $("#order_con_phone").html(users[$("#order_sel_con").val()]['account_phone']);
  }
  if($("#order_sel_eng").val() == "-"){
    unCount++;
    $("#order_row_eng").hide();
    $("#order_sign_eng").hide();
  } else {
    $(".order_eng_orgName").html(users[$("#order_sel_eng").val()]['account_organization']);
    $(".order_eng_firstName").html(users[$("#order_sel_eng").val()]['account_firstname']);
    $(".order_eng_lastName").html(users[$("#order_sel_eng").val()]['account_lastname']);
    $(".order_eng_grouptype").html(users[$("#order_sel_eng").val()]['account_organization_type']);
    $("#order_eng_Address").html(users[$("#order_sel_eng").val()]['account_location']);
    $("#order_eng_Name").html(users[$("#order_sel_eng").val()]['account_firstname'] + " " + users[$("#order_sel_eng").val()]['account_lastname'] + ", "+users[$("#order_sel_eng").val()]['account_title']);
    $("#order_eng_phone").html(users[$("#order_sel_eng").val()]['account_phone']);
    $("#order_eng_zip").html(users[$("#order_sel_eng").val()]['account_zip']);
    $("#order_eng_fax").html(users[$("#order_sel_eng").val()]['account_fax']);
  }
  if($("#order_sel_own").val() == "-"){
    unCount++;
    $("#order_row_own").hide();
    $("#order_sign_own").hide();
  } else {
    $(".order_own_orgName").html(users[$("#order_sel_own").val()]['account_organization']);
    $(".order_own_firstName").html(users[$("#order_sel_own").val()]['account_firstname']);
    $(".order_own_lastName").html(users[$("#order_sel_own").val()]['account_lastname']);
    $(".order_own_grouptype").html(users[$("#order_sel_own").val()]['account_organization_type']);
    $("#order_own_Address").html(users[$("#order_sel_own").val()]['account_location']);
    $("#order_own_Name").html(users[$("#order_sel_own").val()]['account_firstname'] + " " + users[$("#order_sel_own").val()]['account_lastname'] + ", "+users[$("#order_sel_own").val()]['account_title']);
    $("#order_own_phone").html(users[$("#order_sel_own").val()]['account_phone']);
    $("#order_own_zip").html(users[$("#order_sel_own").val()]['account_zip']);
    $("#order_own_fax").html(users[$("#order_sel_own").val()]['account_fax']);
  }

  if(unCount == 3){
    alert("You have to select at least one Signer");
    return false;
  }

  
  $('#loading').show();
  $('#ordertoprint').show();
  ordersavepdftolocation(projectname, doctype, 1 ,function(){
  $('#ordertoprint').hide();
  savecontract(projectname, doctype);
  $('#goodalert').show();
  });
}

function contractchangeorderhiddenchanges()
{
  
  var currentdate = new Date(); 
  var datetime = (((currentdate.getMonth()+1) < 10)?"0":"") + (currentdate.getMonth()+1) + "/"
                + ((currentdate.getDate() < 10)?"0":"") + currentdate.getDate()  + "/" 
                + currentdate.getFullYear();    
   
  $('#originalcontractamount').html( $('[name="originalcontractamount"]').val());
  $('#netofpreviouschangeorder').html( $('[name="netofpreviouschangeorder"]').val());
  $('#adjustedcontractamount').html( $('[name="adjustedcontractamount"]').val());
  $('#newcontractamountincludingthischangeorder').html( $('[name="newcontractamountincludingthischangeorder"]').val());

  $('#changeordernumber').html( $('[name="changeordernumber"]').val());
  $('#descriptionofchange').html( $('[name="descriptionofchange"]').val());
  $('#decreasein').html( $('[name="decreasein"]').val());
  $('#increasein').html( $('[name="increasein"]').val());
  $('#noticetoproceeddays').html( $('[name="noticetoproceeddays"]').val());
  $('#noticetoproceeddate').html( $('[name="noticetoproceeddate"]').val());
  $('#originalcontracttimedays').html( $('[name="originalcontracttimedays"]').val());
  $('#originalcontracttimedate').html( $('[name="originalcontracttimedate"]').val());
  $('#netofpreviouschangeordertimedays').html( $('[name="netofpreviouschangeordertimedays"]').val());
  $('#netofpreviouschangeordertimedate').html( $('[name="netofpreviouschangeordertimedate"]').val());
  $('#adjustedcontracttimedays').html( $('[name="adjustedcontracttimedays"]').val());
  $('#adjustedcontracttimedate').html( $('[name="adjustedcontracttimedate"]').val());
  $('#addtimedays').html( $('[name="addtimedays"]').val());
  $('#addtimedate').html( $('[name="addtimedate"]').val());
  $('#deducttimedays').html( $('[name="deducttimedays"]').val());
  $('#deducttimedate').html( $('[name="deducttimedate"]').val());
  $('#changeordersubtotaldays').html( $('[name="changeordersubtotaldays"]').val());
  $('#changeordersubtotaldate').html( $('[name="changeordersubtotaldate"]').val());
  $('#presentcontracttimedays').html( $('[name="presentcontracttimedays"]').val());
  $('#presentcontracttimedate').html( $('[name="presentcontracttimedate"]').val());
  $('#thischargeadddeductdays').html( $('[name="thischargeadddeductdays"]').val());
  $('#thischargeadddeductdate').html( $('[name="thischargeadddeductdate"]').val());
  $('#newcontracttimedays').html( $('[name="newcontracttimedays"]').val());
  $('#newcontracttimedate').html( $('[name="newcontracttimedate"]').val());
  $('#substantialcompletiondate').html( $('[name="substantialcompletiondate"]').val());
  $('#finalcompletiondate').html( $('[name="finalcompletiondate"]').val());
  $('#changeordersubtotal').html(parseInt( $('[name="changeordersubtotal"]').val()).format(2,3,",","."));
  $('#add').html( parseInt($('[name="add"]').val()).format(2,3,",","."));
  $('#net').html( parseInt($('[name="net"]').val()).format(2,3,",","."));
  $('#deduct').html( parseInt($('[name="deduct"]').val()).format(2,3,",","."));
  $('#originalcontractsum').html( parseInt($('[name="originalcontractsum"]').val()).format(2,3,",","."));
  $('#presentcontractsum').html( parseInt($('[name="presentcontractsum"]').val()).format(2,3,",","."));
  $('#newcontractsum').html( parseInt($('[name="newcontractsum"]').val()).format(2,3,",","."));
  $('#reflectcontractorder').html( $('[name="reflectcontractorder"]').val());
  $('#thru').html( $('[name="thru"]').val());
}

function savedailyobservations()
{
  //dailyobservationshiddenchanges();

  var datastring = $("#dailyobservationsform").serialize();
  datastring = datastring + "&location=" + name;
    $.ajax({
            type: "POST",
            url: "dailyobservationssave.php",
            data: datastring,
            success: function() {
                console.log("success");
            },
            error: function(){
                  alert('error handing here');
            }
        });

}

function senddailyobservationsforsig(doctype, projectname, useremail)
{
  savedailyobservations();
  dailyobservationshiddenchanges();

  var unCount = 0;

  $("#daily_row_con").show();
  $("#daily_row_eng").show();
  $("#daily_row_own").show();
  $("#daily_sign_con").show();
  $("#daily_sign_eng").show();
  $("#daily_sign_own").show();

  if($("#daily_sel_con").val() == "-"){
    unCount++;
    $("#daily_row_con").hide();
    $("#daily_sign_con").hide();
    alert("You have to select at least one Signer");
    return false;
  } else{
    $(".daily_con_orgName").html(users[$("#daily_sel_con").val()]['account_organization']);
    $(".daily_con_firstName").html(users[$("#daily_sel_con").val()]['account_firstname']);
    $(".daily_con_lastName").html(users[$("#daily_sel_con").val()]['account_lastname']);
    $(".daily_con_grouptype").html(users[$("#daily_sel_con").val()]['account_organization_type']);
    $("#daily_con_Address").html(users[$("#daily_sel_con").val()]['account_location']);
    $("#daily_con_zip").html(users[$("#daily_sel_con").val()]['account_zip']);
    $("#daily_con_fax").html(users[$("#daily_sel_con").val()]['account_fax']);
    $("#daily_con_Name").html(users[$("#daily_sel_con").val()]['account_firstname'] + " " + users[$("#daily_sel_con").val()]['account_lastname'] + ", "+users[$("#daily_sel_con").val()]['account_title']);
    $("#daily_con_phone").html(users[$("#daily_sel_con").val()]['account_phone']);
  }
  if($("#daily_sel_eng").val() == "-"){
    unCount++;
    $("#daily_row_eng").hide();
    $("#daily_sign_eng").hide();
  } else {
    $(".daily_eng_orgName").html(users[$("#daily_sel_eng").val()]['account_organization']);
    $(".daily_eng_firstName").html(users[$("#daily_sel_eng").val()]['account_firstname']);
    $(".daily_eng_lastName").html(users[$("#daily_sel_eng").val()]['account_lastname']);
    $("#daily_eng_Address").html(users[$("#daily_sel_eng").val()]['account_location']);
    $("#daily_eng_Name").html(users[$("#daily_sel_eng").val()]['account_firstname'] + " " + users[$("#daily_sel_eng").val()]['account_lastname'] + ", "+users[$("#daily_sel_eng").val()]['account_title']);
    $("#daily_eng_phone").html(users[$("#daily_sel_eng").val()]['account_phone']);
    $("#daily_eng_zip").html(users[$("#daily_sel_eng").val()]['account_zip']);
    $("#daily_eng_fax").html(users[$("#daily_sel_eng").val()]['account_fax']);
  }
  if($("#daily_sel_own").val() == "-"){
    unCount++;
    $("#daily_row_own").hide();
    $("#daily_sign_own").hide();
  } else {
    $(".daily_own_orgName").html(users[$("#daily_sel_own").val()]['account_organization']);
    $(".daily_own_firstName").html(users[$("#daily_sel_own").val()]['account_firstname']);
    $(".daily_own_lastName").html(users[$("#daily_sel_own").val()]['account_lastname']);
    $("#daily_own_Address").html(users[$("#daily_sel_own").val()]['account_location']);
    $("#daily_own_Name").html(users[$("#daily_sel_own").val()]['account_firstname'] + " " + users[$("#daily_sel_own").val()]['account_lastname'] + ", "+users[$("#daily_sel_own").val()]['account_title']);
    $("#daily_own_phone").html(users[$("#daily_sel_own").val()]['account_phone']);
    $("#daily_own_zip").html(users[$("#daily_sel_own").val()]['account_zip']);
    $("#daily_own_fax").html(users[$("#daily_sel_own").val()]['account_fax']);
  }

  if(unCount == 3){
    alert("You have to select at least one Signer");
    return false;
  }

  
  $('#loading').show();
    $('#dailytoprint').show();
    dailysavepdftolocation(projectname, doctype, 1,function(filename){
      $('#toprint').hide();
      var newfile = "files/" + name;
      dailyrequestsig(filename, doctype, useremail);
      $('#goodalert').show();
    });
}

function printdailyobservations(doctype, projectname)
{
  savedailyobservations();
  dailyobservationshiddenchanges();

  var unCount = 0;

  $("#daily_row_con").show();
  $("#daily_row_eng").show();
  $("#daily_row_own").show();
  $("#daily_sign_con").show();
  $("#daily_sign_eng").show();
  $("#daily_sign_own").show();

  if($("#daily_sel_con").val() == "-"){
    unCount++;
    $("#daily_row_con").hide();
    $("#daily_sign_con").hide();
    //alert("You have to select at least one Signer");
    //return false;
  } else{
    $(".daily_con_orgName").html(users[$("#daily_sel_con").val()]['account_organization']);
    $(".daily_con_firstName").html(users[$("#daily_sel_con").val()]['account_firstname']);
    $(".daily_con_lastName").html(users[$("#daily_sel_con").val()]['account_lastname']);
    $(".daily_con_grouptype").html(users[$("#daily_sel_con").val()]['account_organization_type']);
    $("#daily_con_Address").html(users[$("#daily_sel_con").val()]['account_location']);
    $("#daily_con_zip").html(users[$("#daily_sel_con").val()]['account_zip']);
    $("#daily_con_fax").html(users[$("#daily_sel_con").val()]['account_fax']);
    $("#daily_con_Name").html(users[$("#daily_sel_con").val()]['account_firstname'] + " " + users[$("#daily_sel_con").val()]['account_lastname'] + ", "+users[$("#daily_sel_con").val()]['account_title']);
    $("#daily_con_phone").html(users[$("#daily_sel_con").val()]['account_phone']);
  }
  if($("#daily_sel_eng").val() == "-"){
    unCount++;
    $("#daily_row_eng").hide();
    $("#daily_sign_eng").hide();
  } else {
    $(".daily_eng_orgName").html(users[$("#daily_sel_eng").val()]['account_organization']);
    $(".daily_eng_firstName").html(users[$("#daily_sel_eng").val()]['account_firstname']);
    $(".daily_eng_lastName").html(users[$("#daily_sel_eng").val()]['account_lastname']);
    $("#daily_eng_Address").html(users[$("#daily_sel_eng").val()]['account_location']);
    $("#daily_eng_Name").html(users[$("#daily_sel_eng").val()]['account_firstname'] + " " + users[$("#daily_sel_eng").val()]['account_lastname'] + ", "+users[$("#daily_sel_eng").val()]['account_title']);
    $("#daily_eng_phone").html(users[$("#daily_sel_eng").val()]['account_phone']);
    $("#daily_eng_zip").html(users[$("#daily_sel_eng").val()]['account_zip']);
    $("#daily_eng_fax").html(users[$("#daily_sel_eng").val()]['account_fax']);
  }
  if($("#daily_sel_own").val() == "-"){
    unCount++;
    $("#daily_row_own").hide();
    $("#daily_sign_own").hide();
  } else {
    $(".daily_own_orgName").html(users[$("#daily_sel_own").val()]['account_organization']);
    $(".daily_own_firstName").html(users[$("#daily_sel_own").val()]['account_firstname']);
    $(".daily_own_lastName").html(users[$("#daily_sel_own").val()]['account_lastname']);
    $("#daily_own_Address").html(users[$("#daily_sel_own").val()]['account_location']);
    $("#daily_own_Name").html(users[$("#daily_sel_own").val()]['account_firstname'] + " " + users[$("#daily_sel_own").val()]['account_lastname'] + ", "+users[$("#daily_sel_own").val()]['account_title']);
    $("#daily_own_phone").html(users[$("#daily_sel_own").val()]['account_phone']);
    $("#daily_own_zip").html(users[$("#daily_sel_own").val()]['account_zip']);
    $("#daily_own_fax").html(users[$("#daily_sel_own").val()]['account_fax']);
  }

  /*if(unCount == 3){
    alert("You have to select at least one Signer");
    return false;
  }*/

  $('#loading').show();
  $('#dailytoprint').show();
  dailysavepdftolocation(projectname, doctype, 1 ,function(){
  $('#toprint').hide();
  savecontract(projectname, doctype);
  $('#goodalert').show();
  });
}

function dailyobservationshiddenchanges()
{
  
  var currentdate = new Date(); 
  var datetime = (((currentdate.getMonth()+1) < 10)?"0":"") + (currentdate.getMonth()+1) + "/"
                + ((currentdate.getDate() < 10)?"0":"") + currentdate.getDate()  + "/" 
                + currentdate.getFullYear();
  
  $('#weather').html( $('[name="weather"]').val());
  $('#temperature').html( $('[name="temperature"]').val());
  $('#time').html( $('[name="time"]').val());
  $('#temperaturetime').html( $('[name="temperaturetime"]').val());
  $('#raingaugereading').html( $('[name="raingaugereading"]').val());
  $('#date').html( $('[name="date"]').val());
  $('#contractday').html( $('[name="contractday"]').val());
  $('#hoursonsite').html( $('[name="hoursonsite"]').val());
  $('#contractor').html( $('[name="contractor"]').val());
  $('#workforce').html( $('[name="workforce"]').val());
  $('#equipment').html( $('[name="equipment"]').val());
  $('#workactivities').html(encode4HTML($('[name="workactivities"]').val()));
  $('#testsperformed').html(encode4HTML($('[name="testsperformed"]').val()));
  $('#materialsdelivered').html(encode4HTML($('[name="materialsdelivered"]').val()));
  $('#visitors').html(encode4HTML($('[name="visitors"]').val()));
  $('#defectiveworktobecorrected').html(encode4HTML($('[name="defectiveworktobecorrected"]').val()));
  console.log(encode4HTML($('[name="workactivities"]').val()));
}

function encode4HTML(str) {
    return str
        .replace(/\r\n?/g,'\n')
        // normalize newlines - I'm not sure how these
        // are parsed in PC's. In Mac's they're \n's
        .replace(/(^((?!\n)\s)+|((?!\n)\s)+$)/gm,'')
        // trim each line
        .replace(/(?!\n)\s+/g,' ')
        // reduce multiple spaces to 2 (like in "a    b")
        .replace(/^\n+|\n+$/g,'')
        // trim the whole string
        .replace(/[<>&"']/g,function(a) {
        // replace these signs with encoded versions
            switch (a) {
                case '<'    : return '&lt;';
                case '>'    : return '&gt;';
                case '&'    : return '&amp;';
                case '"'    : return '&quot;';
                case '\''   : return '&apos;';
            }
        })
        .replace(/\n{2,}/g,'</p><p>')
        // replace 2 or more consecutive empty lines with these
        .replace(/\n/g,'<br />')
        // replace single newline symbols with the <br /> entity
        //.replace(/^(.+?)$/,'<p>$1</p>');
        // wrap all the string into <p> tags
        // if there's at least 1 non-empty character
}

function dailyobservationscalcs()
{
  var noticetoproceed =  $('[name="noticetoproceed"]').val();
  var daystocomplete =  $('[name="daystocomplete"]').val();
  if((noticetoproceed != '')&&(daystocomplete !=''))
  {
  var originalcompletion = moment(noticetoproceed, "MM-DD-YYYY").add( daystocomplete,'days');
  $('[name="originalcompletedate"]').val(originalcompletion.format('MM/DD/YYYY'));
  }
  
  var originalcompletiondate =  $('[name="originalcompletedate"]').val();
  var daysextension =  $('[name="daysextension"]').val();
  
  if((originalcompletiondate != '')&&(daysextension !=''))
  {
  var newcompletedate = moment(originalcompletiondate, "MM-DD-YYYY").add(daysextension, 'days');
  $('[name="newcompletedate"]').val(newcompletedate.format('MM/DD/YYYY'));
  }
  
  var originalcontractamt =  $('[name="originalcontractamt"]').val();
  var revisedcontractamt =  $('[name="revisedcontractamt"]').val();
  
  if((originalcontractamt != '')&&(revisedcontractamt !=''))
  {
    originalcontractamt = parseFloat(originalcontractamt, 10);
    revisedcontractamt = parseFloat(revisedcontractamt, 10);
    adjtodate = revisedcontractamt - originalcontractamt;
    $('[name="adjtodate"]').val(adjtodate.toFixed(2));
  }
  
  var percentcompl = $('[name="percentcompl"]').val();
  if((percentcompl != '')&&(revisedcontractamt !=''))
  {
    percentcompl = parseFloat(percentcompl, 10);
    totworkcompl = percentcompl * revisedcontractamt / 100;
    $('[name="totalworkcompleted"]').val(totworkcompl.toFixed(2));
    
  }

  var totalworkcompleted = $('[name="totalworkcompleted"]').val();
  var prepayment = $('[name="prepayment"]').val();
  var materialstoredonsite = $('[name="materialstoredonsite"]').val();
  if((totalworkcompleted != '')&&(prepayment !='')&&(materialstoredonsite !=''))
  {
    totalworkcompleted = parseFloat(totalworkcompleted, 10);
    prepayment = parseFloat(prepayment, 10);
    materialstoredonsite = parseFloat(materialstoredonsite, 10);
    subtotal1 = totalworkcompleted + prepayment + materialstoredonsite;
    $('[name="subtotal1"]').val(subtotal1.toFixed(2));
  }
  
  var subtotal1 = $('[name="subtotal1"]').val();
  var liquiddamage = $('[name="liquiddamage"]').val();
  if((subtotal1 != '0')&&(liquiddamage !=''))
  {
    subtotal1 = parseFloat(subtotal1);
    liquiddamage = parseFloat(liquiddamage );
    subtotal2 = subtotal1 - liquiddamage ;
    $('[name="subtotal2"]').val(subtotal2.toFixed(2));
    
  }
  
  var subtotal2 = $('[name="subtotal2"]').val();
  var retainage = $('[name="retainage"]').val();
  if((subtotal2 != '0')&&(retainage !=''))
  {
    subtotal2 = parseFloat(subtotal2);
    retainage = parseFloat(retainage);
    retainagedollars = (retainage/100) * subtotal2;
    subtotal3 = subtotal2 * (1 - (retainage/100)) ;
    $('[name="subtotal3"]').val(subtotal3.toFixed(2));
    $('[name="retainagedollar"]').val(retainagedollars.toFixed(2));
    
  }
  
  var subtotal3 = $('[name="subtotal3"]').val();
  var previouspayment = $('[name="previouspayment"]').val();
  if((subtotal3 != '0')&&(previouspayment !=''))
  {
    subtotal3 = parseFloat(subtotal3);
    previouspayment = parseFloat(previouspayment);
    amountdue = subtotal3 - previouspayment ;
    $('[name="amountdue"]').val(amountdue.toFixed(2));
    
  }
}


function contractchangeordercalcs()
{
  var noticetoproceeddate =  $('[name="noticetoproceeddate"]').val();
  var originalcontracttimedays =  $('[name="originalcontracttimedays"]').val();
  if((noticetoproceeddate != '')&&(originalcontracttimedays !=''))
  {
  var originalcontracttimedate = moment(noticetoproceeddate, "MM-DD-YYYY").add( originalcontracttimedays,'days');
  $('[name="originalcontracttimedate"]').val(originalcontracttimedate.format('MM/DD/YYYY'));
  }
  
  var originalcontracttimedate =  $('[name="originalcontracttimedate"]').val();
  var netofpreviouschangeordertimedays =  $('[name="netofpreviouschangeordertimedays"]').val();
  if((originalcontracttimedate != '')&&(netofpreviouschangeordertimedays !=''))
  {
  var adjustedcontracttimedate = moment(originalcontracttimedate, "MM-DD-YYYY").add( netofpreviouschangeordertimedays,'days');
  $('[name="adjustedcontracttimedate"]').val(adjustedcontracttimedate.format('MM/DD/YYYY'));
  }

  var originalcontracttimedays =  $('[name="originalcontracttimedays"]').val();
  var netofpreviouschangeordertimedays =  $('[name="netofpreviouschangeordertimedays"]').val();
  if((originalcontracttimedays != '')&&(netofpreviouschangeordertimedays !=''))
  {
  var adjustedcontracttimedays = parseInt(originalcontracttimedays) + parseInt(netofpreviouschangeordertimedays);
  $('[name="adjustedcontracttimedays"]').val(adjustedcontracttimedays);
  }

  var addtimedays =  $('[name="addtimedays"]').val();
  var deducttimedays =  $('[name="deducttimedays"]').val();
  if((addtimedays != '')&&(deducttimedays !=''))
  {
  var changeordersubtotaldays = addtimedays - deducttimedays;
  $('[name="changeordersubtotaldays"]').val(changeordersubtotaldays);
  }

  var adjustedcontracttimedate =  $('[name="adjustedcontracttimedate"]').val();
  var changeordersubtotaldays =  $('[name="changeordersubtotaldays"]').val();
  if((adjustedcontracttimedate != '')&&(changeordersubtotaldays !=''))
  {
  var newcontracttimedate = moment(adjustedcontracttimedate, "MM-DD-YYYY").add( changeordersubtotaldays,'days');
  $('[name="newcontracttimedate"]').val(newcontracttimedate.format('MM/DD/YYYY'));
  }
  /*var originalcontracttimedate =  $('[name="originalcontracttimedate"]').val();
  var thischargeadddeductdays =  $('[name="thischargeadddeductdays"]').val();
  
  if((originalcontracttimedate != '')&&(thischargeadddeductdays !=''))
  {
    var thischargeadddeductdate = moment(originalcontracttimedate, "MM-DD-YYYY").add(thischargeadddeductdays, 'days');
    $('[name="thischargeadddeductdate"]').val(thischargeadddeductdate.format('MM/DD/YYYY'));
  }
  
  var originalcontracttimedays =  $('[name="originalcontracttimedays"]').val();
  var thischargeadddeductdays =  $('[name="thischargeadddeductdays"]').val();
  
  if((originalcontracttimedays != '')&&(thischargeadddeductdays !=''))
  {
    originalcontracttimedays = parseFloat(originalcontracttimedays);
    thischargeadddeductdays = parseFloat(thischargeadddeductdays );
    newcontracttimedays = originalcontracttimedays + thischargeadddeductdays ;
    $('[name="newcontracttimedays"]').val(newcontracttimedays);
  }

  var originalcontracttimedate =  $('[name="originalcontracttimedate"]').val();
  var newcontracttimedays =  $('[name="newcontracttimedays"]').val();
  
  if((originalcontracttimedate != '')&&(newcontracttimedays !=''))
  {
    var newcontracttimedate = moment(originalcontracttimedate, "MM-DD-YYYY").add(newcontracttimedays, 'days');
    $('[name="newcontracttimedate"]').val(newcontracttimedate.format('MM/DD/YYYY'));
  }*/

  var add = $('[name="add"]').val();
  var deduct = $('[name="deduct"]').val();
  if((add != '')&&(deduct !=''))
  {
    add = parseFloat(add, 10);
    deduct = parseFloat(deduct, 10);
    changeordersubtotal = add - deduct;
    $('[name="changeordersubtotal"]').val(changeordersubtotal.toFixed(2));
  }
  
  var changeordersubtotal = $('[name="changeordersubtotal"]').val();
  var presentcontractsum = $('[name="presentcontractsum"]').val();
  if((presentcontractsum != '')&&(changeordersubtotal !=''))
  {
    presentcontractsum = parseFloat(presentcontractsum);
    changeordersubtotal = parseFloat(changeordersubtotal );
    newcontractsum = changeordersubtotal + presentcontractsum ;
    $('[name="newcontractsum"]').val(newcontractsum.toFixed(2));
  }

  var originalcontractamount = $('[name="originalcontractamount"]').val();
  var netofpreviouschangeorder = $('[name="netofpreviouschangeorder"]').val();
  if((originalcontractamount != '')&&(netofpreviouschangeorder !=''))
  {
    originalcontractamount = parseFloat(originalcontractamount);
    netofpreviouschangeorder = parseFloat(netofpreviouschangeorder );
    adjustedcontractamount = originalcontractamount + netofpreviouschangeorder ;
    $('[name="adjustedcontractamount"]').val(adjustedcontractamount.toFixed(2));
  }

  var add = $('[name="add"]').val();
  var deduct = $('[name="deduct"]').val();
  var adjustedcontractamount = $('[name="adjustedcontractamount"]').val();
  if((add != '')&&(deduct !='')&&(adjustedcontractamount !=''))
  {
    add = parseFloat(add, 10);
    deduct = parseFloat(deduct, 10);
    adjustedcontractamount = parseFloat(adjustedcontractamount );
    newcontractamountincludingthischangeorder = adjustedcontractamount + add - deduct ;
    $('[name="newcontractamountincludingthischangeorder"]').val(newcontractamountincludingthischangeorder.toFixed(2));
  }
  
}

function setGroupDetails(gid){
  
  $("#ed_gName").val(grouplist[gid]["name"]);
  $("#ed_otherTName").val(grouplist[gid]["otherType"]);

  $('#ed_gType').selectpicker('val',grouplist[gid]['type']);
  $("#ed_gid").val(grouplist[gid]["groupid"]);
  var pickers = new Array();

  $(".fepicker option").each(function(){
    if(gfarr[gid].indexOf($(this).val()+",") >= 0){
      pickers.push($(this).val());
      
    }
  });
  $(".fepicker").selectpicker('val',pickers);

  
}

function sendInviteEmail() {
  location.href = "sendInviteEmail.php?userid=" + $("#userid").val();
}

function setPassword() {
  location.href = "setPassword.php?userid=" + $("#userid").val();
}

function removeFromProject() {
  location.href = "removeUserFromProject.php?userid=" + $("#userid").val() + "&groupid=" + $("#groupid").val();
  // $.ajax({
  //   type: "POST",
  //   url: "removeFromProject.php",
  //   data: {userid : $("#userid").val(), groupid : $("#groupid").val()},
  //   success: function() {
  //     $('#loading').hide();
  //     location.reload();
  //   },
  //   error: function(){
  //     alert('error handing here');
  //   }
  // });
}

function setDocEditDetails(docid, docname, folid) {
  $('#folderToMove').selectpicker('val',folid);
  $("#doc_id").val(docid);
  $("#nameToChange").val(docname);
  console.log(docid, folid);
}

function moveFolder() {
  location.href = "moveFolder.php?docid=" + $("#doc_id").val() + "&folid=" + $('#folderToMove').val();
}

function editDocumentName() {
  location.href = "editDocumentName.php?docid=" + $("#doc_id").val() + "&docname=" + $('#nameToChange').val();
}

function setUserDetails(uid){
  
  $("#edituserfirstname").val(grouplistuser[uid]['account_firstname']);
  $("#edituserlastname").val(grouplistuser[uid]['account_lastname']);
  $('#editusergroup').selectpicker('val',grouplistuser[uid]['groupid']);
  var roles = ['','Administrator', 'Collaborate', 'Limited'];
  console.log("level" + roles[grouplistuser[uid]['level']]);
  $('#edituserrolepicker').selectpicker('val',roles[grouplistuser[uid]['level']]);
  $("#editusertitle").val(grouplistuser[uid]['account_title']);
  $("#edituserphone").val(grouplistuser[uid]['account_phone']);
  $("#edituserfax").val(grouplistuser[uid]['account_fax']);
  $("#edituseraddress").val(grouplistuser[uid]['account_location']);
  $("#edituserzip").val(grouplistuser[uid]['account_zip']);
  $("#edituseremail").val(grouplistuser[uid]['user_email']);
  var status = ['Invited', 'Active'];
  $("#edituserstatus").val(status[grouplistuser[uid]['user_status']]);
  $("#userid").val(grouplistuser[uid]['userid']);
  $("#groupid").val(grouplistuser[uid]['groupid']);
  //$("#groupid").val()
  /*var pickers = new Array();

  $(".fepicker option").each(function(){
    if(gfarr[gid].indexOf($(this).val()+",") >= 0){
      pickers.push($(this).val());
      
    }
  });
  $(".fepicker").selectpicker('val',pickers);

  $("#edituserfirstname").val(grouplistuser[]);
  $("#edituserfirstname").val(grouplistuser[uid]['account_firstname']);

  /*$("#ed_otherTName").val(grouplist[gid]["otherType"]);

  $('#ed_gType').selectpicker('val',grouplist[gid]['type']);
  $("#ed_gid").val(grouplist[gid]["groupid"]);
  var pickers = new Array();

  $(".fepicker option").each(function(){
    if(gfarr[gid].indexOf($(this).val()+",") >= 0){
      pickers.push($(this).val());
      
    }
  });
  $(".fepicker").selectpicker('val',pickers);

  $("#edituserfirstname").val(grouplistuser[]);*/
}

function delGroup(){
  location.href="/groupdel.php?gid="+$("#ed_gid").val();
}


function savefdot()
{
  fdothiddenchanges();

  var datastring = $("#fdotform").serialize();
  datastring = datastring + "&location=" + name;
    $.ajax({
            type: "POST",
            url: "fdotsave.php",
            data: datastring,
            success: function() {
                console.log("success");
            },
            error: function(){
                  alert('error handing here');
            }
        });

}

function sendfdotforsig(doctype, projectname, useremail)
{
  savefdot();
  fdothiddenchanges();

  var unCount = 0;

  $("#fdot_row_con").show();
  $("#fdot_row_eng").show();
  $("#fdot_row_own").show();
  $("#fdot_sign_con").show();
  $("#fdot_sign_eng").show();
  $("#fdot_sign_own").show();

  if($("#fdot_sel_con").val() == "-"){
    unCount++;
    $("#fdot_row_con").hide();
    $("#fdot_sign_con").hide();
    alert("You have to select at least one Signer");
    return false;
  } else{
    $(".fdot_con_orgName").html(users[$("#fdot_sel_con").val()]['account_organization']);
    $(".fdot_con_firstName").html(users[$("#fdot_sel_con").val()]['account_firstname']);
    $(".fdot_con_lastName").html(users[$("#fdot_sel_con").val()]['account_lastname']);
    $(".fdot_con_grouptype").html(users[$("#fdot_sel_con").val()]['account_organization_type']);
    $("#fdot_con_Address").html(users[$("#fdot_sel_con").val()]['account_location']);
    $("#fdot_con_zip").html(users[$("#fdot_sel_con").val()]['account_zip']);
    $("#fdot_con_fax").html(users[$("#fdot_sel_con").val()]['account_fax']);
    $("#fdot_con_Name").html(users[$("#fdot_sel_con").val()]['account_firstname'] + " " + users[$("#fdot_sel_con").val()]['account_lastname'] + ", "+users[$("#fdot_sel_con").val()]['account_title']);
    $("#fdot_con_phone").html(users[$("#fdot_sel_con").val()]['account_phone']);
  }
  if($("#fdot_sel_eng").val() == "-"){
    unCount++;
    $("#fdot_row_eng").hide();
    $("#fdot_sign_eng").hide();
  } else {
    $(".fdot_eng_orgName").html(users[$("#fdot_sel_eng").val()]['account_organization']);
    $(".fdot_eng_firstName").html(users[$("#fdot_sel_eng").val()]['account_firstname']);
    $(".fdot_eng_lastName").html(users[$("#fdot_sel_eng").val()]['account_lastname']);
    $("#fdot_eng_Address").html(users[$("#fdot_sel_eng").val()]['account_location']);
    $("#fdot_eng_Name").html(users[$("#fdot_sel_eng").val()]['account_firstname'] + " " + users[$("#fdot_sel_eng").val()]['account_lastname'] + ", "+users[$("#fdot_sel_eng").val()]['account_title']);
    $("#fdot_eng_phone").html(users[$("#fdot_sel_eng").val()]['account_phone']);
    $("#fdot_eng_zip").html(users[$("#fdot_sel_eng").val()]['account_zip']);
    $("#fdot_eng_fax").html(users[$("#fdot_sel_eng").val()]['account_fax']);
  }
  if($("#fdot_sel_own").val() == "-"){
    unCount++;
    $("#fdot_row_own").hide();
    $("#fdot_sign_own").hide();
  } else {
    $(".fdot_own_orgName").html(users[$("#fdot_sel_own").val()]['account_organization']);
    $(".fdot_own_firstName").html(users[$("#fdot_sel_own").val()]['account_firstname']);
    $(".fdot_own_lastName").html(users[$("#fdot_sel_own").val()]['account_lastname']);
    $("#fdot_own_Address").html(users[$("#fdot_sel_own").val()]['account_location']);
    $("#fdot_own_Name").html(users[$("#fdot_sel_own").val()]['account_firstname'] + " " + users[$("#fdot_sel_own").val()]['account_lastname'] + ", "+users[$("#fdot_sel_own").val()]['account_title']);
    $("#fdot_own_phone").html(users[$("#fdot_sel_own").val()]['account_phone']);
    $("#fdot_own_zip").html(users[$("#fdot_sel_own").val()]['account_zip']);
    $("#fdot_own_fax").html(users[$("#fdot_sel_own").val()]['account_fax']);
  }

  if(unCount == 3){
    alert("You have to select at least one Signer");
    return false;
  }

  
  $('#loading').show();
    $('#fdottoprint').show();
    fdotsavepdftolocation(projectname, doctype, 1,function(filename){
      $('#fdottoprint').hide();
      var newfile = "files/" + name;
      fdotrequestsig(filename, doctype, useremail);
      $('#goodalert').show();
    });
}

function printfdot(doctype, projectname)
{
  savefdot();
   fdothiddenchanges();

  var unCount = 0;

  $("#fdot_row_con").show();
  $("#fdot_row_eng").show();
  $("#fdot_row_own").show();
  $("#fdot_sign_con").show();
  $("#fdot_sign_eng").show();
  $("#fdot_sign_own").show();

  if($("#fdot_sel_con").val() == "-"){
    unCount++;
    $("#fdot_row_con").hide();
    $("#fdot_sign_con").hide();
    //alert("You have to select at least one Signer");
    //return false;
  } else{
    $(".fdot_con_orgName").html(users[$("#fdot_sel_con").val()]['account_organization']);
    $(".fdot_con_firstName").html(users[$("#fdot_sel_con").val()]['account_firstname']);
    $(".fdot_con_lastName").html(users[$("#fdot_sel_con").val()]['account_lastname']);
    $(".fdot_con_grouptype").html(users[$("#fdot_sel_con").val()]['account_organization_type']);
    $("#fdot_con_Address").html(users[$("#fdot_sel_con").val()]['account_location']);
    $("#fdot_con_zip").html(users[$("#fdot_sel_con").val()]['account_zip']);
    $("#fdot_con_fax").html(users[$("#fdot_sel_con").val()]['account_fax']);
    $("#fdot_con_Name").html(users[$("#fdot_sel_con").val()]['account_firstname'] + " " + users[$("#fdot_sel_con").val()]['account_lastname'] + ", "+users[$("#fdot_sel_con").val()]['account_title']);
    $("#fdot_con_phone").html(users[$("#fdot_sel_con").val()]['account_phone']);
  }
  if($("#fdot_sel_eng").val() == "-"){
    unCount++;
    $("#fdot_row_eng").hide();
    $("#fdot_sign_eng").hide();
  } else {
    $(".fdot_eng_orgName").html(users[$("#fdot_sel_eng").val()]['account_organization']);
    $(".fdot_eng_firstName").html(users[$("#fdot_sel_eng").val()]['account_firstname']);
    $(".fdot_eng_lastName").html(users[$("#fdot_sel_eng").val()]['account_lastname']);
    $("#fdot_eng_Address").html(users[$("#fdot_sel_eng").val()]['account_location']);
    $("#fdot_eng_Name").html(users[$("#fdot_sel_eng").val()]['account_firstname'] + " " + users[$("#fdot_sel_eng").val()]['account_lastname'] + ", "+users[$("#fdot_sel_eng").val()]['account_title']);
    $("#fdot_eng_phone").html(users[$("#fdot_sel_eng").val()]['account_phone']);
    $("#fdot_eng_zip").html(users[$("#fdot_sel_eng").val()]['account_zip']);
    $("#fdot_eng_fax").html(users[$("#fdot_sel_eng").val()]['account_fax']);
  }
  if($("#fdot_sel_own").val() == "-"){
    unCount++;
    $("#fdot_row_own").hide();
    $("#fdot_sign_own").hide();
  } else {
    $(".fdot_own_orgName").html(users[$("#fdot_sel_own").val()]['account_organization']);
    $(".fdot_own_firstName").html(users[$("#fdot_sel_own").val()]['account_firstname']);
    $(".fdot_own_lastName").html(users[$("#fdot_sel_own").val()]['account_lastname']);
    $("#fdot_own_Address").html(users[$("#fdot_sel_own").val()]['account_location']);
    $("#fdot_own_Name").html(users[$("#fdot_sel_own").val()]['account_firstname'] + " " + users[$("#fdot_sel_own").val()]['account_lastname'] + ", "+users[$("#fdot_sel_own").val()]['account_title']);
    $("#fdot_own_phone").html(users[$("#fdot_sel_own").val()]['account_phone']);
    $("#fdot_own_zip").html(users[$("#fdot_sel_own").val()]['account_zip']);
    $("#fdot_own_fax").html(users[$("#fdot_sel_own").val()]['account_fax']);
  }

  /*if(unCount == 3){
    alert("You have to select at least one Signer");
    return false;
  }*/
  
  $('#loading').show();
  $('#fdottoprint').show();
  fdotsavepdftolocation(projectname, doctype, 1 ,function(){
  $('#fdottoprint').hide();
  savecontract(projectname, doctype);
  $('#goodalert').show();
  });
}

function fdothiddenchanges()
{
  
  var currentdate = new Date(); 
  var datetime = (((currentdate.getMonth()+1) < 10)?"0":"") + (currentdate.getMonth()+1) + "/"
                + ((currentdate.getDate() < 10)?"0":"") + currentdate.getDate()  + "/" 
                + currentdate.getFullYear();    
  


  $('#invoicenumber').html( $('[name="invoicenumber"]').val());
  $('#phasebeinginvoiced').html( $('[name="phasebeinginvoiced"]').val());
  $('#financialprojectid').html( $('[name="financialprojectid"]').val());
  $('#contractnumber').html( $('[name="contractnumber"]').val());
  $('#projectdescription').html( $('[name="projectdescription"]').val());
  $('#attn').html( $('[name="attn"]').val());
  $('#jpalapexecutiondate').html( $('[name="jpalapexecutiondate"]').val());
  $('#localagencyname').html( $('[name="localagencyname"]').val());
  $('#localagencyaddress').html( $('[name="localagencyaddress"]').val());
  $('#servicebegindate').html( $('[name="servicebegindate"]').val());
  $('#serviceenddate').html( $('[name="serviceenddate"]').val());
  $('#totalamountofreimbursementagreement').html( parseInt($('[name="totalamountofreimbursementagreement"]').val()).format(2,3,",","."));
  $('#totalpreviouslybilled').html( parseInt($('[name="totalpreviouslybilled"]').val()).format(2,3,",","."));
  $('#daysuntilcurrentphassecompletion').html( $('[name="daysuntilcurrentphassecompletion"]').val());
  $('#totalforcurrentbilling').html( parseInt($('[name="totalforcurrentbilling"]').val()).format(2,3,",","."));
  $('#percentageofjpalapfundsexpended').html( parseInt($('[name="percentageofjpalapfundsexpended"]').val()).format(2,3,",","."));
  $('#balanceonjpalapagreement').html( parseInt($('[name="balanceonjpalapagreement"]').val()).format(2,3,",","."));
}

function fdotcalcs()
{
  var totalamountofreimbursementagreement = $('[name="totalamountofreimbursementagreement"]').val();
  var totalpreviouslybilled = $('[name="totalpreviouslybilled"]').val();
  var totalforcurrentbilling = $('[name="totalforcurrentbilling"]').val();
  if((totalamountofreimbursementagreement != '')&&(totalpreviouslybilled !='')&&(totalforcurrentbilling !=''))
  {
    totalamountofreimbursementagreement = parseFloat(totalamountofreimbursementagreement, 10);
    totalpreviouslybilled = parseFloat(totalpreviouslybilled, 10);
    totalforcurrentbilling = parseFloat(totalforcurrentbilling, 10);
    percentageofjpalapfundsexpended = (totalforcurrentbilling + totalpreviouslybilled) / totalamountofreimbursementagreement * 100;
    $('[name="percentageofjpalapfundsexpended"]').val(percentageofjpalapfundsexpended.toFixed(2));
    balanceonjpalapagreement = totalamountofreimbursementagreement - totalforcurrentbilling - totalpreviouslybilled;
    $('[name="balanceonjpalapagreement"]').val(balanceonjpalapagreement.toFixed(2));
  }  
}

function updatePasswordOnMyAccount(userid) {
  var password = $('[name="password"]').val();
  console.log(password);
  $.ajax({
      type: "POST",
      url: "/updatePasswordOnMyAccount.php",
      data: {password:password, userid:userid},
    }).done(function(response){
       if(response = 'success')
       {
          $('#goodalert').show();
       }
    });

}

