<!--expense for product Modal -->
<div class="modal fade" id="charges-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Today Expenses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
  
      <div class="modal-body">
        
        <label class="font-weight-bold">Delivery Charges</label>
        <input type="number" class="form-control" id="delivery_charges"  >

        <label class="font-weight-bold">Installation Charges</label>
        <input type="text" class="form-control" id="install_charges"  >  
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" id="charge-button">Save</button>
      </div>

    </div>
  </div>
</div>