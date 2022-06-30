<div>
    <div class="modal fade bd-example-modal-lg" id="payment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Full Payment </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  id="full_payment">
        
      <div class="modal-body" >
        <div class="row mt-2  ">
          <input type="hidden" id="biller_name" class="form-control" value="{{Auth::user()->name}}">
          <input type="hidden" id="admin_id" class="form-control" value="{{Auth::user()->id}}">
          <input type="hidden" class="form-control" id="reciept_type">
             <div class="col-md-6">
              <label class="font-weight-bold">Customer Name</label>
              <div class="d-flex">
                <input list="customers" name="customer_id" id="customer_id" class="form-control" placeholder="select Customer ">
                   <datalist id="customers"  >
                   </datalist>
                 <button type="button" class="btn btn-primary btn-xs " id="customer_pos" data-id="2">Add</button>
               
              </div>
             </div>
             <div class="col-md-6">
               <label class="font-weight-bold">Paying By</label>
               <select class="form-control" id="paying_by">
                <option value="cash">Cash</option>
                <option>Bank</option>
               </select>
               <span class="text-danger">@error ('Paying_by') {{$message}} @enderror</span>
             </div>
           </div>
           <div class="row mt-2" id="cheque_detail" style="display:none">
            <div class="col-md-6">
               <label class="font-weight-bold">Cheque Picture</label>
               <input type="file" id="cheque_image" class="form-control "  accept="image/*">
              </div>
             <div class="col-md-6">
                <label class="font-weight-bold">Cheque Number</label>
               <input type="text" id="cheque_no" class="form-control "  placeholder="Enter Cheque Number">
            
              </div>
           </div>
           <div class="row mt-2">
            <div class="col-md-6">
              <label class="font-weight-bold">Payable Amount(Rs)</label>
               <input type="number" name="payable_amount" id="payable_amount" class="form-control grand_total"  readonly>
               <span class="text-danger">@error ('payable_amount') {{$message}} @enderror</span>
            </div>
            <div class="col-md-6">
              <label class="font-weight-bold">Paying Amount(Rs)</label>
              <input type="number" name="paying_amount" id="paying_amount" class="form-control  grand_total"  autofocus>
              <span class="text-danger">@error ('paying_amount') {{$message}} @enderror</span>
            </div>
          @if(Auth::user()->branch_id==1)

         <div class="col-md-6 mt-2">
              <label class="font-weight-bold">Delivery Charges(Rs)</label>
              <input type="number" name="discount"  class="form-control  delivery_charges"   placeholder="Enter Delivery Charges">
              <span class="text-danger">@error ('delivery_charges') {{$message}} @enderror</span>
            </div>
            <div class="col-md-6 mt-2">
              <label class="font-weight-bold">Installation Charges </label>
              <input type="number" name="tax" id="tax"  class="form-control  install_charges"  placeholder="Enter Installation Charges">
              <span class="text-danger">@error ('installation_charges') {{$message}} @enderror</span>
            </div>


            @else



            <div class="col-md-6 mt-2">
              <label class="font-weight-bold">Discount</label>
              <input type="number" name="discount" id="discount"  class="form-control  "  autofocus>
              <span class="text-danger">@error ('discount') {{$message}} @enderror</span>
            </div>
            <div class="col-md-6 mt-2">
              <label class="font-weight-bold">Tax </label>
              <input type="number" name="tax" id="tax"  class="form-control  tax"  autofocus>
              <span class="text-danger">@error ('tax') {{$message}} @enderror</span>
            </div>
          @endif  
           </div>
        

         <input type="hidden" name="pro_ids"  class="form-control prod_id">
           

           <div class="row mt-5">
              <div class="col-md-6 d-flex">
               <p class="ml-1">Item</p>
               <p class="ml-auto mr-1 font-weight-bold " ><span class="items"></span><span class="quan"></span></p>
              </div>
              <div class="col-md-6 d-flex">
               <p class="ml-1">Total Payable(Rs)</p>
               <p class="ml-auto mr-1 font-weight-bold g_total2" id="total_payable">0</p>
              </div>
            </div>
            <div class="row border-top">
              <div class="col-md-6 d-flex">
               <p class="ml-1" >Total Paying (Rs)</p>
               <p class="ml-auto mr-1 font-weight-bold g_total2" >0</p>
              </div>
              <div class="col-md-6 d-flex">
               <p class="ml-1">Change(Rs) </p>
               <p class="ml-auto mr-1 font-weight-bold" id="remaining">0</p>
              </div>
            </div>
      </div>
      <div class="modal-footer d-flex">
          <!-- <div class="d-flex mr-auto">
           <button type="button" class="btn px-sm-2  payment font2 discount" > 
            Discount</button>
            <button type="button" class="btn order p-0 font2 partial-payment2" data-id="1">Temporary Account</button>
            <button type="button" class="btn font2 p-0 pbs hold-sale permanent-hold2" data-id="0">Permanent Account</button>
            
          </div> -->
          @if(auth::user()->branch_id==1)
        <button class="btn btn-primary print" id="print2" type="button">Pay & Prints</button>
        @else
         <button class="btn btn-primary print" id="print" type="button">Pay & Print</button>
        @endif
      </div>
    </form>
    </div>
  </div>
</div>
</div>