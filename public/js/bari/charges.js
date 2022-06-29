$(document).ready(function(){

  $(document).on('click','#charge-button',function(){
  
       let delivery=$('#delivery_charges').val();

       let install=$('#install_charges').val();

       let text_value=$('#discount-input').val()
       let grand_total=$('#g_total').text()
       let discount= $('#discount').text()
       if(delivery=='')
       {
        delivery=0;
       }
       if(install=='')
       {
        install=0;
       }
      
       let total=parseInt(install)+parseInt(delivery)
         +parseInt(grand_total)
         charges(parseInt(install)+parseInt(delivery));
       

        $('.delivery_charges').val(delivery)
        $('.install_charges').val(install)
        $('.grand_total').val(total)
        $('.g_total2').text(total)
        $('#charges').text(parseInt(install)+parseInt(delivery))

        $('#charges-modal').modal('hide')
      
  });



  function charges(charges)
  {
 
         let check=$('#pos-table1').children('.table-product').find('#charge_td');
       if(check.length===0)
        {
          $('#pos-table1:last-child').append(`<tr class="table-product"><td class="col-6">Delivery + Installation Charges</td><td></td><td></td><td></td><td></td><td class="float-right col-6 font-weight-bold mr-3" id="charge_td">`+charges+`</td</tr>`);  
        }else{
            $('#pos-table1').children('.table-product').find('#charge_td').text(charges)
        }
     }


     $(document).on('change','.delivery_charges',function(){

       let delivery_charges=$(this).val();
       let install_charges=$('.install_charges').val();
       if(delivery_charges <=0)
       {
        delivery_charges=0
        $(this).val('');
       }else{
         
         delivery_charges=delivery_charges;
          
       }

       let total=$('#g_total').text();
          
          if(install_charges == '')
          {
            install_charges=0
          }
          total =parseInt(total)+ parseInt(delivery_charges)+parseInt(install_charges);
          $('.g_total2').text(total)
          $('#payable_amount').val(total)

     });

     $(document).on('change','.install_charges',function(){

       let install_charges=$(this).val();
       let delivery_charges=$('.delivery_charges').val();
       if(install_charges <=0)
       {
        install_charges=0;
        $(this).val('');
       }else{

          install_charges=install_charges;
       }
       let total=$('#g_total').text();
          if(delivery_charges == '')
          {
            delivery_charges=0
          }
          total =parseInt(total)+ parseInt(install_charges)+parseInt(delivery_charges);
          $('.g_total2').text(total)
          $('#payable_amount').val(total)
     });


});