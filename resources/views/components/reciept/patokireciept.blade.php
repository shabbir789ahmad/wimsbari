<div class="row mt-0 pt-0 printer bari_invoice" id="printer">
    <div class="col-md-12 pt-0 mt-0">
      <div class="d-flex mt-0 pt-0" >
          
           <div class="info mt-0 pt-0"> 
            <p class="heads text-center">ا حمد پلا سٹک اینڈ بلڈ نگ مٹیر یل سٹو ر </p>
             
              <div class="row footer-p" style="display: flex; flex-direction:row;">
              <div class="col-md-6 text-center" style="display: flex; flex-direction:row;width: 50%;" >
               <p >{{ date('d/m/Y h.m.s A') }}</p>
              </div>
              <div class="col-md-6" style="display: flex; flex-direction:column;width: 50%;">
                <div  style="display: flex; flex-direction:row;">
               <p class="ml-1">Invoice Id:#</p>
               <p  class="invoice_id"></p>
               </div>
               <p id="customer_name_print"></p>
               </div>
            </div>
          
            
           </div>
        
          <div class="table-responsive">
            <table class="table ">
              <thead class="table-head">
                <tr class="table-font  " style="display: flex; flex-direction:row; width: 100%;">
                  <th class="col-4" scope="col">PRODUCT</th>
                  <th class="col-2 text-center" scope="col">PRICE</th>
                  <th class="col-2 text-center" scope="col">QTY</th>
                  <th class="col-2 text-center" scope="col">VAT</th>
                  <th class="col-2 text-center" scope="col"> AMOUNT</th>
                  
                </tr>
              </thead>
              
              <tbody id="pos-table2" class="table-font" style="height:20%; ">
              
              </tbody>
            </table>
          </div>
          <div class="table-responsive">
            <table class="table ">
             <tbody id="pos-table3" class="table-font" style="height:20%; ">
              
              </tbody>
            </table>
          </div>
          <div class="card footer">
          <div class="row footer-p" style="display: flex; flex-direction:row;">
              <div class="col-md-6 " style="display: flex; flex-direction:row;width: 50%;" >
               <p class="ml-1">Qty#</p>
               <p class="ml-auto mr-1 font-weight-bold "><span class="items">0</span></p>
              </div>
              <div class="col-md-6" style="display: flex; flex-direction:row;width: 50%;">
               <p class="ml-1">Total Tax</p>
               <p class="ml-auto  font-weight-bold g_total3" ></p>
               <!-- <p class=" mr-1 font-weight-bold " >.000</p> -->
               
              </div>
            </div>
            <div class="row footer-p" style="display: flex; flex-direction:row;">
              <div class="col-md-6 " style="display: flex; flex-direction:row;width: 50%;" >
               <p class="ml-1">Total Amount </p>
               <p class="ml-auto mr-1 font-weight-bold total_amount g_total2"></p>
              </div>
              <div class="col-md-6" style="display: flex; flex-direction:row;width: 50%;">
               <p class="ml-1">Balance </p>
               <p class="ml-auto  font-weight-bold return_amount" >0</p>
               <!-- <p class=" mr-1 font-weight-bold " >.000</p> -->
               
              </div>
            </div>

            <div class="row footer-p" style="display: flex; flex-direction:row;">
               <div class="col-md-6 " style="display: flex; flex-direction:row;width: 50%;" >
               <p class="ml-1 mb-0">Cashier : </p>
               
              
              </div><div class="col-md-6 " style="display: flex; flex-direction:row;width: 50%;" >
               <p class="ml-1 mb-0">{{Auth::user()->name}}</p>
               
              
              </div>
            </div>
            <div class="row footer-p" style="display: flex; flex-direction:row;">
               <div class="col-md-6 " style="display: flex; flex-direction:row;width: 50%;" >
               <p class="ml-1">Time : </p>
               
              
              </div><div class="col-md-6 " style="display: flex; flex-direction:row;width: 50%;" >
              <p class="ml-1">{{ date(' h.m.s A') }}</p>
               
              
              </div>
            </div>


          
          </div>
          <div class="bottom mt-3"style="display: flex; flex-direction:row; justify-content: center;" >
            <h3 class=" footer-total ">Final Total  :</h3> <h3 class="g_total2 footer-total"></h3>
          </div>

           <div class="footer-print " >

            <p class="text-center mt-2"><strong class="footer-thank">Thanks for Comming</strong> 
              <br>
          <span>
              <strong class="footer-copy mt-1">Address: گیلن پھا ٹک چیک  9 پتوکی قصور</strong>
            </span> 
              <span>
              <strong class="footer-copy mt-2">Copyright &copy; {{ date('Y') }} WasiSoft Technology.</strong>
            </span>
            </p>
           
            
          </div>
         </div>

    </div>
  </div>