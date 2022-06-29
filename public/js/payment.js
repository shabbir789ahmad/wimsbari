$(document).ready(function()
 {
   //payment modal open
   $(document).on('click','#payment,.payments',function()
   {

     if( $('#pos-table').children().length ==0)
       {
          alert ('Please Select Prodcut')
       }else
       {
         $('#payment-modal').modal('show')
         $('#paying_amount').select();
       }
    }); 
  

  
       
    
 
$('#paying_amount').change(function(){

  let amount=$(this).val();
  let payable=$('#payable_amount').val();

  let re= (payable * 10 - amount * 10) / 10;
  re=Number.parseFloat(re).toFixed(2)
 
  $('#remaining').text(re)
  $('#remaining').css('color','red')
  $('.total_amount').text(amount)
  $('.return_amount').text(Math.abs(re))
  
  


});

  //partial payment  modal open
  $(document).on('click','.partial-payment2',function()
  {
     date=$('.paying_date').val()
     checkDate(date)
     customer()
     $('#payment-partial-modal').modal('show')
     let id=$(this).data('id')
     changeTextModal(id);
   });

   $(document).on('click','.pbs',function()
  {
     date=$('.paying_date').val()
     checkDate(date)
     customer()
     $('#payment-partial-modal').modal('show')
     let id=$(this).data('id')
     changeTextModal(id);
   });
  function changeTextModal(id)
  {
    if(id==1)
    {
      $('#Partial').text('Temporary Account')
      $('#account_type').val(0)
    }else if(id==0)
    {
       $('#Partial').text('Permanant Account')
       $('#account_type').val(1)
    }

      $('#payment-modal').modal('hide') 
  }
    
  $('.paying_date').change(function()
  {
      let date=$('.paying_date').val();
      checkDate(date)
  });

   function checkDate(date)
   {
     if(date=='' || $('#pos-table').children().length ==0)
      {
         $('#save-button').prop('disabled',true)

      }else
      {
        $('#save-button').prop('disabled',false)
      }
   }

  //for partial payment functions
  $('.as').change(function()
  {
     let v=$(this).val();
     $('#total_paying2').text(v)
     let total=$('.grand_total').val()
     let new_total=total - v;
     if(new_total < 0)
     {
        $('#remaining2').css('color','red');
        $('#change').text('Change');
        $('#change').css('color','red');
        $('#remaining2').text(Math.abs(new_total));
    }else
    {
            
        $('#change').text('Remaining');
        $('#change').css('color','#212529');
        $('#remaining2').css('color','#3E065F');
        ('#remaining2').text(new_total);
    }
  });

 

  
   $(document).on('click','.discount',function()
   {
     $('.dis').css('display','block')
   });
  
  $(document).on('change','#paying_amount',function()
  {
     let amount=$(this).val();
     let payable=$('#payable_amount').val();
     if(amount < payable)
     {
        $('#pay-button').prop('disabled',true)
     }else
     {
        $('#pay-button').prop('disabled',false)
     }
  });

  $('#clear2').click(function()
  {
     $('#amount2').val(0)
     $('#total_paying2').text(0)
     $('#remaining2').text(0)
  });

 



 

  // //get all payment
  // getPayment()
  // function getPayment()
  // {
  //   $.ajax
  //   ({
  //        url:'/get/payment/installment',
  //        type:"GET",
  //        datatype : 'json'
  //     })
  //      .done(function(res)
  //      {
  //        $('#payment_recievable').empty();
  //        $.each(res, function(index,val)
  //        {
  //           $('#payment_recievable').append(`
           
                
  //            `);
  //        });
  //       })
  //       .fail(function(){ });
  // }//payment function endd

});