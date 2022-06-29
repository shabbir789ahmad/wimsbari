 <div class="modal fade" id="new_expenses_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Create Expense Type</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
       </div>
   
       <div class="modal-body">
        <div class="row">
          <div class="col-md-10 ml-2 p-0">
            <lable class="font-weight-bold mt-2">Expense Type</lable>
            <select class="form-control expense_types" id="e_type">
        
            </select>
          </div>
          <div class="col-1 p-0">
           <button class="btn  btn-info mt-4" id="expense_type2" data-id="0">Add</button>
          </div>
        </div>
        
        <lable class="font-weight-bold mt-5">Expense Amount</lable>
         <input type="number"  id="expense_amount" placeholder="Expense Amount" class="form-control">
      
         <lable class="font-weight-bold mt-4">Customer Name</lable>
         <input type="text"  id="expense_user" placeholder="User For Wich Expense Created" class="form-control">
         
      </div>
      <div class="modal-footer">
        
        <button type="button"  class="btn btn-primary" id="add_new_expense">Create</button>
      </div>
    
    </div>
  </div>
</div>
