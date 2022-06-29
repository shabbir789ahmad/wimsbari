<div class="row mt-0 pt-0 printer bari_invoice" id="printer">
   <div class="container-fluid " id="">
      <div  style="font-size: 4vw; font-weight: 700; text-align:center; margin: 0mm; padding: 0mm; text-decoration: underline; display: flex; flex-direction:row; justify-content:space-between;">
          <img src="{{asset('assets/defaults/logo.avif')}}" width="100%">
      </div>
      
      <div class="" style="display:flex; justify-content:space-between; flex-direction: row;  margin-top: 0%; padding-top: 0%;">
           <p style=" font-size: 3vw; display:flex; flex-direction:row; ;"><strong>SR NO:</strong> <span id="invoice_id"></span>  </p>
           <p style=" font-size: 3vw; display:flex; flex-direction:row; margin-left: auto;"><strong>Date#:</strong>  {{date('y.m.d H:m:s A')}}</p>
      </div>
      <div class="" style="display:flex; justify-content:center; flex-direction: row;  margin-top: 0%; padding-top: 0%;">
        <p style=" font-size: 5vw; font-weight: 900; text-decoration:underline" id="receipt_name">Quotation</p>
      </div>
      <div class="" style="display:flex; justify-content:space-between; flex-direction: row;  margin: 0%; padding: 0%;">
        <p style=" font-size: 4vw; display:flex; flex-direction:row; ;"><strong>To:</strong> <span id="invoice_client_name">Shabbir ahmad</span>  </p>
      </div>

     <div class="table_invoice">
      <hr class="hr_invoice1">
      <div class="table_invoice1" >
        <div style="width:10%; text-align: center;">Sr#</div>
        <div  style="width:40%; text-align: center;">Description</div>
        <div style="width:15%; text-align: center;">Size.</div>
        <div style="width:10%; text-align: center;">Qty.</div>
        <div style="width:10%; text-align: center;">Rate</div>
        <div style="width:15%; text-align: center;">Amount</div>
      </div>
      
      <div class="table_invoice2" id="bari_invoice_recipt">
       <div class="table_invoice3" >
         <div style="width:10%; text-align: center;">01</div>
            <div  style="width:40%;"><strong style="font-size:3vw"> Slotted Angle Rack 0000</strong> <span style="font-size:2vw; font-weight:700;">With 
                2 Shelf + 1 Angle + 1 Joints + 1 Bolts + dfsdf dsfsdf sdfsdf sdf1 Rubber Bush +

                apend2=apend2+`
                   </span></div>
                   <div style="width:15%;">1.5'x3'6'</div>
                   <div style="width:10%;">50</div>
                   <div style="width:10%;">14,500/-</div>
                   <div style="width:15%; ">725,000/-</div>
        </div> 
       
       
      </div>
      <hr class="hr_invoice2">
      <hr class="hr_invoice3">
      <hr class="hr_invoice4">
      <hr class="hr_invoice5">
    </div>      
    
    <!-- payment details  -->
   <div class="payment_data">
       <span>Total</span>
       <span id="invoice_total">0/-</span>
    </div>
    <div class="payment_data">
       <span>Delivery Charges(Client Responsibility)</span>
       <span id="invoice_delivery_charges">0/-</span>
    </div>
    <div class="payment_data">
       <span>Installation Charges(Client Responsibility)</span>
       <span id="invoice_install_charges">0/-</span>
    </div>
    <div class="payment_data">
       <span>Total Amount Payable</span>
       <span id="invoice_finale_total"> 72900/-</span>
    </div>
    
    <!-- term and condition -->
    <div style=" width: 100%;" >
      <div style="font-size: 3vw; font-weight: 700;text-decoration:underline;"> Terms & Conditions </div>
      
       <div class="term_conditon2" >
         <div style="display: flex; flex-direction:row"> <span style="font-size:2.1vw; font-weight:900">Payment:  75%</span><span style="font-size:2vw; font-weight: 700; margin-left: 1%;"> Advance With confirmation of order. Balance 25% before delivery payment</span></div>
         <div style="display: flex; flex-direction:row;"> <span style="font-size:2.1vw; font-weight:900">Payment:  18</span><span style="font-size:2vw;font-weight: 700; margin-left: 1%;">to 21 DAYSAFTER ADVANCE payment  With confirmation of order.</span></div>
         <div style="display: flex; flex-direction:row;"> <span style="font-size:2.1vw; font-weight:900">VAlidity: </span><span style="font-size:2vw;font-weight: 700; margin-left: 1%;">03-days from the date of quotation</span></div>
         <div > <span style="font-size:2vw; font-weight:700">Note:   Prices Exclusive of G.S.T & All Taxes.</span></div>
       </div>
    </div>


<!-- bottom address -->
   <div style="margin-top:12%; width: 100%;" id="bari_address">
     
      <hr style=" border: 2px solid #000; width:100%">
      <div class="term_conditon2" >
       <div style="font-weight:900"><strong>Office & Display Address:99-Shair Ali Road Near Of Expo Center,Joher Town, Lahore.</strong></div>
       <div ><strong>Factory Address: 36-km Main Multan Road, Lahore.</strong></div>
       <div style="margin-top:mm"><strong>Cell No: 0302-4448392, 0333-9833392 </strong></div>
       <div style="margin-top:mm"><strong>Email Address : bariengineering@gmail.com Web: www.baristeelrack.com</strong></div>
      </div>

      
    </div>
   
</div>

  </div>