

<div id="ordertoprint" class='printbody' style="background-color: white; display: none" >

     <!--center>
        <h4>DARABI AND ASSOCIATE, INC.</h4> 
      </center>
      <center>
        <h6>ENVIRONMENTAL CONSULTANTS</h6> 
      </center>
      <center>
        <h6>ENVIRONMENTAL CONSULTANTS</h6> 
      </center-->
      <center>
        <h4>CONSTRUCTION CONTRACT CHANGE ORDER</h4>
      </center>
      <div class="row paddingtop10">
        <div class="col-md-6">
          <div class="col-md-12">
            <p><b>Change Order Number:</b> <span id="changeordernumber"></span></p>
            <p><b>Project Name:</b> <?php echo $project_name ?></p>
            <p><b>Project No:</b> <?php echo $project_number ?></p>
            <br>
            <br>
            <br>
          </div>
          <div id="order_row_eng" class="col-md-12">
            <p><b>ENGINEER:</b> </p>
            <p><b><span class="order_eng_orgName"></span></b></p>
            <p><b><span id="order_eng_Address">&nbsp;&nbsp;<span id="order_eng_zip"></span></span></b></p>
            <p><b><span id="order_eng_Name"></span></b></p>
            <p><b>Ph:</b> <span id="order_eng_phone"></span></p>
            <p><b>Fax:</b> <span id="order_eng_fax"></span></p>
          </div>
          
        </div>
        <div class="col-md-6">
          <div id="order_row_con" class="col-md-12">
            <p><b>CONTRACTOR:</b></p>
            <p><b><span class="order_con_orgName"></span></b></p>
            <p><b><span id="order_con_Address"></span>&nbsp;&nbsp;<span id="order_con_zip"></span></b></p>
            <p><b><span id="order_con_Name"></span></b></p>
            <p><b>Ph:</b> <span id="order_con_phone"></span></p>
            <p><b>Fax:</b> <span id="order_con_fax"></span></p>
          </div>
          
          <div id="order_row_own" class="col-md-12">
            <p><b>OWNER:</b></p>
            <p><b><span class="order_own_orgName"></span></b></p>
            <p><b><span id="order_own_Address">&nbsp;&nbsp;<span id="order_own_zip"></span></span></b></p>
            <p><b><span id="order_own_Name"></span></b></p>
            <p><b>Ph:</b> <span id="order_own_phone"></span></p>
            <p><b>Fax:</b> <span id="order_own_fax"></span></p>
          </div>
        </div>
      </div>
      <hr>
      <div class="row paddingtop10">
        
        <div class="col-md-8">
          <p><b>Description of Change</b></p>
          <p><span id="descriptionofchange"></span></p>
        </div>
        
        <div class="col-md-2">
          <p><b><u>Decrease In</u></b></p>
          <p><span id="decreasein"></span></p>
        </div>
        
        <div class="col-md-2">
          <p><b><u>Increase In</u></b></p>
          <p><span id="increasein"></span></p>
        </div>

      </div>
      
      
      <div class="row paddingtop10">
        
       <div class="col-md-6">
                <h4><b>CONTRACT TIME*</b></h4>
                <div class="col-md-12">
                  <div class="col-md-4"></div>
                  <div class="col-md-4"><h5><u>Days</u></h5></div>
                  <div class="col-md-4"><h5><u>Date</u></h5></div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4" style="padding-left: 0 !important"><p><b>Notice to Proceed</b></p></div>
                    <div class="col-md-4"><p><span id='noticetoproceeddays' style="display: none"></span></div>
                    <div class="col-md-4"><p><span id='noticetoproceeddate'></span></div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4" style="padding-left: 0 !important"><p><b>Original Contract Time</b></p></div>
                    <div class="col-md-4"><p><span id='originalcontracttimedays'></span></div>
                    <div class="col-md-4"><p><span id='originalcontracttimedate'></span></div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4" style="padding-left: 0 !important"><p><b>Net of Previous Change Orders</b></p></div>
                    <div class="col-md-4"><p><span id='netofpreviouschangeordertimedays'></span></div>
                    <div class="col-md-4"><p><span id='netofpreviouschangeordertimedate'></span></div>
                </div>
                
                <div class="col-md-12">
                    <div class="col-md-4" style="padding-left: 0 !important"><p><b>Adjusted Contract Time</b></p></div>
                    <div class="col-md-4"><p><span id='adjustedcontracttimedays'></span></div>
                    <div class="col-md-4"><p><span id='adjustedcontracttimedate'></span></div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-4" style="padding-left: 0 !important"><p><b>Add</b></p></div>
                    <div class="col-md-4"><p><span id='addtimedays'></span></div>
                    <div class="col-md-4"><p><span id='addtimedate' style="display:none"></span></div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4" style="padding-left: 0 !important"><p><b>Deduct</b></p></div>
                    <div class="col-md-4"><p><span id='deducttimedays'></span></div>
                    <div class="col-md-4"><p><span id='deducttimedate' style="display:none"></span></div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4" style="padding-left: 0 !important"><p><b>Change Order Subtotal</b></p></div>
                    <div class="col-md-4"><p><span id='changeordersubtotaldays'></span></div>
                    <div class="col-md-4"><p><span id='changeordersubtotaldate' style="display:none"></span></div>
                </div>
                <div class="col-md-12" style="display:none">
                    <div class="col-md-4" style="padding-left: 0 !important"><p><b>Present Contract Time</b></p></div>
                    <div class="col-md-4"><p><span id='presentcontracttimedays'></span></div>
                    <div class="col-md-4"><p><span id='presentcontracttimedate'></span></div>
                </div>
                <div class="col-md-12" style="display:none">
                    <div class="col-md-4" style="padding-left: 0 !important"><p><b>This Charge-Add-Deduct</b></p></div>
                    <div class="col-md-4"><p><span id='thischargeadddeductdays'></span></div>
                    <div class="col-md-4"><p><span id='thischargeadddeductdate'></span></div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4" style="padding-left: 0 !important"><p><b>New Contract Time</b></p></div>
                    <div class="col-md-4"><p><span id='newcontracttimedays'></span></div>
                    <div class="col-md-4"><p><span id='newcontracttimedate'></span></div>
                </div>
                
                <br>
                <br>
                <br>
                <div class="col-md-12" style="margin-top: 30px !important">
                    <p><b>Substantial Completion Date(calendar days):</b> <span id="substantialcompletiondate"></span></p>  
                </div>
                <div class="col-md-12">
                    <p><b>Final Completion Date(calendar days):</b> <span id="finalcompletiondate"></span></p>  
                </div>
            </div>
              <div class="col-md-6">
                <h4><b>CONTRACT AMOUNT*</b></h4>
                <br>
                <p><b>Original Contract Amount:</b> $<span id="originalcontractamount"></span></p>
                <p><b>Net of Previous Change Order:</b> $<span id="netofpreviouschangeorder"></span></p>
                <p><b>Adjusted Contract Amount:</b> $<span id="adjustedcontractamount"></span></p>
                <p><b>Change Order Subtotal:</b> $<span id="changeordersubtotal"></span></p>
                <p><b>Add:</b> $<span id="add"></span></p>
                <p><b>Deduct:</b> $<span id="deduct"></span></p>
                <!--p>Net: $<span id="net"></span></p-->
                <!--p><b>Original Contract Sum:</b> $<span id="originalcontractsum"></span></p>
                <p><b>Present Contract Sum:</b> $<span id="presentcontractsum"></span></p>
                <p><b>New Contract Sum:</b> $<span id="newcontractsum"></span></p-->
                <p><b>New Contract Amount, Including this Change Order:</b> $<span id="newcontractamountincludingthischangeorder"></span></p>
                <br>
                <br>
                
                  <p><b>*Reflect Contract Order Nos.</b> <span id="reflectcontractorder"></span>   <b>thru</b> <span id="thru"></span></p>

              </div>
                    
              
            
              
    
      </div>
        
      <br>
      <hr>
     
      
      <div class="row paddingtop10">
                
        <div class="col-md-12">
          
          <p><span id="contractchangestatement"><b>This Change Order is an amendment to the Contract Agreement between Contractor and the Owner, and all contract provisions shall apply unless specifically exempted.  The amount and time change designated are the maximum agreed to by both the Owner and the Contractor for this change.  In consideration of the foregoing adjustments in contract time and contract amount, the Contractor hereby releases Owner from all claims, demands or causes of action arising out of the transactions, events and occurrences giving rise to this Change Order.  This written Change Order is the entire agreement between Owner and Contractor with respect to this Change Order.  No other agreements or modifications shall apply to this Contract amendment unless expressly provided herein.  This Change Order represents final action relating to this Change Order.</b></span></p>
          
        </div>
      </div>  
        
        
      <div class="row paddingtop10">
        <p><b><u>Agreed:</u></b></p>
        <hr>
        <div id="order_sign_con" class="col-md-4">
            
            <p><b>Signature:</b></p>
            
            <p><b><span class="order_con_firstName"></span> <span class="order_con_lastName"></span></b></p>
            
            <p><b><span class="order_con_orgName"></span></b></p>
            
            <p><b><span class="order_con_groupType"></span></b></p>
            
            <p><b>Date:</b></p>
        </div>
         
        <div id="order_sign_eng" class="col-md-4">
            
            <p><b>Signature:</b></p>
            
            <p><b><span class="order_eng_firstName"></span> <span class="order_eng_lastName"></span></b></p>
            
            <p><b><span class="order_eng_orgName"></span></b></p>
            
            <p><b><span class="order_eng_groupType"></span></b></p>
            
            <p><b>Date:</b></p>
        </div>
        
        <div id="order_sign_own" class="col-md-4">
            
            <p><b>Signature:</b></p>
            
            <p><b><span class="order_own_firstName"></span> <span class="order_own_lastName"></span></b></p>
            
            <p><b><span class="order_own_orgName"></span></b></p>
            
            <p><b><span class="order_own_groupType"></span></b></p>
            
            <p><b>Date:</b></p>
        </div>
        
        
      </div>
      
</div>





