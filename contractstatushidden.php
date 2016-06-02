

<div id="toprint" class='printbody' style="background-color: white; display: none" >

    <center>
        <h4><u>PARTIAL PAYMENT ESTIMATE</u></h4> 
      </center>
   
      <div class="row paddingtop10">
        
        <div id="row_con" class="col-md-4">
          <p><b>CONTRACTOR:</b></p>
          <p><b><span class="con_orgName"></span></b></p>
          <p><b><span id="con_Address"></span>&nbsp;&nbsp;<span id="con_zip"></span></b></p>
          <p><b><span id="con_Name"></span></b></p>
          <p><b>Ph:</b> <span id="con_phone"></span></p>
          <p><b>Fax:</b> <span id="con_fax"></span></p>
        </div>
        
        <div id="row_eng" class="col-md-4">
          <p><b>ENGINEER:</b></p>
          <p><b><span class="eng_orgName"></span></b></p>
          <p><b><span id="eng_Address">&nbsp;&nbsp;<span id="eng_zip"></span></span></b></p>
          <p><b><span id="eng_Name"></span></b></p>
          <p><b>Ph:</b> <span id="eng_phone"></span></p>
          <p><b>Fax:</b> <span id="eng_fax"></span></p>
        </div>
        
        <div id="row_own" class="col-md-4">
          <p><b>OWNER:</b></p>
          <p><b><span class="own_orgName"></span></b></p>
          <p><b><span id="own_Address">&nbsp;&nbsp;<span id="own_zip"></span></span></b></p>
          <p><b><span id="own_Name"></span></b></p>
          <p><b>Ph:</b> <span id="own_phone"></span></p>
          <p><b>Fax:</b> <span id="own_fax"></span></p>
        </div>
        
      </div>
      
      <div class="row paddingtop10">
        
        <div class="col-md-6">
          <p><b>Project Name:</b> <?php echo $project_name ?></p>
         
        </div>
        
        <div class="col-md-6">
          <p><b>Partial Payment Estimate No:</b> <span id="test123"></span></p>
          <p><b>Submittal Date:</b> <span id="con_sub_date"></span></p>
        </div>
        
      </div>
      
      
      <div class="row paddingtop10">
        
        <div class="col-md-6">
          <p><b>Project No:</b> <?php echo $project_number ?></p>
          <p><b>Period Covered:</b> <span id="cdate_from"></span></p>
        </div>
        
        <div class="col-md-6">
          <p>&nbsp;</p>
          <p><b>through:</b> <span id="cdate_to"></span></p>
        </div>
        
      </div>
      
      
      <div class="row paddingtop10">
                
        <div class="col-md-6">
          <h3>CONTRACT STATUS</h3>
          
          <p><b>Bids Received:</b> <span id="bidsreceiveddate"></span></p>
          <p><b>Contract Date:</b> <span id="contractdate"></span></p>
          <p><b>Notice To Proceed:</b> <span id="noticetoproceed"></span></p>
          <p><b>Calendar Days To Substantial Completion:</b> <span id="daystosubcomplete"></span></p>
          <p><b>Calendar Days To Final Completion:</b> <span id="daystocomplete"></span></p>
          <p><b>Original Subst. Completion Date:</b> <span id="originalsubstcompletedate"></span></p>
          <p><b>Original Completion Date:</b> <span id="originalcompletedate"></span></p>

          <p><b>Days Extension, Substantial Completion:</b> <span id="dayssubextension"></span></p>
          <p><b>Days Extension, Final Completion:</b> <span id="daysextension"></span></p>
          <p><b>New Substantial Completion Date:</b> <span id="newsubcompletedate"></span></p>
          <p><b>New Completion Date:</b> <span id="newcompletedate"></span></p>

          <p><b>Original Contract Amount:</b> <span id="originalcontractamt"></span></p>
          <p><b>Revised Contract Amount:</b> <span id="revisedcontractamt"></span></p>
          <p><b>Adjustments to Date:</b> <span id="adjtodate"></span></p>
          <p><b>Percentage Complete:</b> <span id="percentcompl"></span></p>
        </div>
        
        
        
      
                
        <div class="col-md-6">
          <h3>Summary Of Jobs Status</h3>
          
          <p><b>Total Work Completed:</b> <span id="totalworkcompleted"></span></p>
          <p><b>Prepayment:</b> <span id="prepayment"></span></p>
          <p><b>Material Stored on Site:</b> <span id="materialstoredonsite"></span></p>
          <p><b>Subtotal:</b> <span id="subtotal1"></span></p>
          <p><b>Less Liquidated Damage:</b> <span id="liquiddamage"></span></p>
          <p><b>Subtotal:</b> <span id="subtotal2"></span></p>
          <p><b>Less Retainage(%):</b> <span id="retainage"></span></p>
          <p><b>Less Retainage:</b> <span id="retainagedollar"></span></p>
          <p><b>Subtotal:</b> <span id="subtotal3"></span></p>
          <p><b>Less Previous Payments:</b> <span id="previouspayment"></span></p>
          <p><b>Amount Due This Period:</b> <span id="amountdue"></span></p>
        </div>
        
        
        
      </div>
      
      
      <div class="row paddingtop10">
        <p><b>Approved For Payment</b></p>
        <hr>
        <div id="sign_con" class="col-md-4">
            
            <p><b>Signature:</b></p>
            
            <p><b><span class="con_firstName"></span> <span class="con_lastName"></span></b></p>
            
            <p><b><span class="con_orgName"></span></b></p>
           
            <p><b><span class="con_groupType"></span></b></p>
            
            <p><b>Date:</b></p>
        </div>
         
        <div id="sign_eng" class="col-md-4">
            
            <p><b>Signature</b></p>
           
            <p><b><span class="eng_firstName"></span> <span class="eng_lastName"></span></b></p>
            
            <p><b><span class="eng_orgName"></span></b></p>
           
            <p><b><span class="eng_groupType"></span></b></p>
            
            <p><b>Date:</b></p>
        </div>
        
        <div id="sign_own" class="col-md-4">
            
            <p><b>Signature:</b></p>
           
            <p><b><span class="own_firstName"></span> <span class="own_lastName"></span></b></p>
            
            <p><b><span class="own_orgName"></span></b></p>
            
            <p><b><span class="own_groupType"></span></b></p>
            
            <p><b>Date:</b></p>
        </div>
        
        
      </div>
      
</div>





