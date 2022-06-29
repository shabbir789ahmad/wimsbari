$(document).ready(function(){

  $('#payable').click(function()
   {
       $('#payable_supplier').modal('show');
       allPayableAmount()
   });

  
 


    $(document).on('click','.pay_now',function()
    {
    	id=$(this).parents('tr').children('td:first-child').text()
    	$(this).prop('disabled',true).css('background', '#C6C6C6');
      $.ajax({

         url:"/pay/now/"+id,
         type:'POST',
         data:{
         	"_token": $('#csrf-token')[0].content ,
         }
      }).done(function(res){
          
           
      });

    });
});