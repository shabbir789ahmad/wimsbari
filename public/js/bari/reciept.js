$(document).ready(function(){

 // create delivery challan
   $(document).on('click','#bari_payment',function()
   {
     $('.bari_invoice').css('display','none');
     $('.delivery_challan').css('display','block');
     $('#reciept_type').val('challan');
     PaymentModel()
    }); 
   
   // create invoice
    $(document).on('click','#bari_invoice',function()
   {
    $('.delivery_challan').css('display','none');
    $('.bari_invoice').css('display','block');
    $('#reciept_type').val('invoice');
     PaymentModel()
    }); 

    // create invoice
    $(document).on('click','#bari_quatation',function()
   {
    $('.delivery_challan').css('display','none');
    $('.bari_invoice').css('display','block');
    $('#reciept_type').val('quotation');
    
     PaymentModel()
    }); 

    function PaymentModel()
    {
      if( $('#pos-table').children().length ==0)
       {
          alert ('Please Select Prodcut')
       }else
       {
         $('#payment-modal').modal('show')
         $('#paying_amount').select();
       }
    }

});
