$(document).ready(function(){

 $(document).on('click','#print2,.print2',function()
 {  
   // print customer name
     let customer_id=$('#customer_id').val();
    let reciept_type=$('#reciept_type').val();
    $('#customer_name_print').text(customer_id.substr(2))
      
   
    $.ajax({
             url : "/order/bari/printer",
             type : 'POST',
             datatype:'json',
             data:{
                     "_token": $('#csrf-token')[0].content ,
                     biller_name : $('#biller_name').val(),
                     customer_id : customer_id.replace(/\D/g, ''),
                     paying_by : $('#paying_by').val(),
                     paying_amount : $('#paying_amount').val(),
                     payable_amount : $('#payable_amount').val(),
                     discount : $('.delivery_charges').val(),
                     cheque_no : $('#cheque_no').val(),
                     cheque_image : $('#cheque_image').val(),
                     reciept_type : reciept_type,
                     tax : $('#tax').val(),
                  },
                 
            }).done(function(res)
            {
               
               let data=res.cart_data;  
               let data2=res.cart_data2;  
               let success=res.success; 
               let payment=res.payment; 
               let product=res.product; 
        
              
               
               if(reciept_type==='challan')
               {
               let  i=challanReciept(data,payment,product)

                  if(data2.length > 0){apendextra(data2,i,payment)}
               }else if(reciept_type=='invoice')
               {
                $('#receipt_name').text('ESTIMATE INVOICE');
                InvoiceReciept(data,payment,product)

                if(data2.length > 0){apendextra2(data2)}

               }else if(reciept_type=='quotation')
               {
                $('#receipt_name').text('QUOTATION');
                $('#bari_address').css('display','none');
                InvoiceReciept(data,payment,product)
               }
              // print challan
                
                 
                  window.print();
                 
                  $('#payment-modal').modal('hide');
                  $('#bari_recipt').empty()
                  $('#pos-table').empty()
                 $('.g_total2').text('')
                 $('.quan').text('')
                 $('.items').text('')
                 sumCount();
                 quentityCount(); 
                snack(1,success)  
                 dailySale()
              });
      });

 function InvoiceReciept(data,payment)
 {
    $('#bari_invoice_recipt').empty()
    $('#invoice_id').text(payment.sr_number)
    $.each(data,function(key,item)
    {
      let apend2=` 
                  <div class="table_invoice3" >
                   <div style="width:10%; text-align: center;">01</div>
                   <div  style="width:40%;"><strong style="font-size:3vw">${item.description}</strong> <span style="font-size:2vw; font-weight:700;">With `;
                    let component=JSON.parse(item.properties)
                    let j2=item.shelf_quentity;
                
                   $.each(component,function(key,pro)
                   {
                     apend2=apend2+`
                     ${pro.q} ${pro.name} +`;
                    });

                    apend2=apend2+`
                    </span></div>
                    <div style="width:15%; text-align:center">${item.size}</div>
                    <div style="width:10%; text-align:center">${item.shelf_quentity}</div>
                    <div style="width:10%;text-align:center">${item.price}/-</div>
                    <div style="width:15%; text-align:center">${payment.paying_amount}/-</div>
                  </div> `;
              
                  $('#bari_invoice_recipt').append(apend2);
                 
                     ts=payment.paying_amount;
                     if(isNaN(parseInt(payment.tax)) )
                     {  
                        t=0
                     }else{
                        t=parseInt(payment.tax)
                     }
                     if(isNaN(parseInt(payment.discount))  )
                     {  
                        t2=0
                     }else{
                        t2=parseInt(payment.discount)
                     }
                 $('#invoice_total').text( ts + '/-');  
                 $('#invoice_finale_total').text((parseInt(payment.paying_amount)+ t + t2) + '/-');  
                 $('#sr_no').text(payment.id );  
                 $('#invoice_install_charges').text(payment.tax + '/-');  
                 $('#invoice_delivery_charges').text(payment.discount + '/-');  
                 $('#invoice_client_name').text($('#customer_name').val() );  

                 $('#pos-table1').children('.table-product').remove();
                 $('.delivery_charges').val('')
                 $('.install_charges').val('')

                 });
 }

// print challan function 
//this use for generate challan
 function challanReciept(data,payment,product)
 { 
   let i=1;
   
    $('#bari_recipt').empty()
    $.each(data,function(key,item){
    $('#sr_number2').text(payment.sr_number)
    let apend2=` 

                <div class="table_new3" >
                <div style="width:10%; text-align: center;">0${i++}</div>
                <div  style="width: 80%;"><strong style="font-size:3vw">${item.description} ${item.size}</strong> <span style="font-size:2vw; font-weight:700;">With `;
                let component=JSON.parse(item.properties)
                let j2=item.shelf_quentity;
                let payment_id=item.payment_id;
                
                $.each(component,function(key,pro)
                {
                     apend2=apend2+`
                     ${pro.q} ${pro.name} +`;
                });

                apend2=apend2+`
                   </span></div>
                   <div style="width:10%; text-align: center;">${item.shelf_quentity}</div>
                    
                </div> `;
              
                $('#bari_recipt').append(apend2);
               //call appent component function here to append detail
               //of product
                apendComponent(j2,product,component,payment_id)
               
                  
                     ts=payment.paying_amount;
                     if(isNaN(parseInt(payment.tax)) )
                     {  
                        t=0
                     }else{
                        t=parseInt(payment.tax)
                     }
                     if(isNaN(parseInt(payment.discount))  )
                     {  
                        t2=0
                     }else{
                        t2=parseInt(payment.discount)
                     }
                 $('#recipt_total').text( ts + '/-');  
                 $('#total_amount').text((parseInt(payment.paying_amount)+ t + t2) + '/-');  
                 $('#sr_no').text(payment.id );  
                 $('#i_charge').text(payment.tax + '/-');  
                 $('#d_charge').text(payment.discount + '/-');  
                 $('#client_name').text($('#customer_name').val() );  

                 $('#pos-table1').children('.table-product').remove();
                 $('.delivery_charges').val('')
                 $('.install_charges').val('')

                 });
    return i;
 }

//this function use for only challan reciept
//this is used for product compoent detail
 function apendComponent(quentity,product,component,payment_id)
 {  
    $.each(component,function(key1,pro2){
     $.each(product,function(key2,pro){
       if(pro2.product_id === pro[0].id )
        {

            let q=pro2.q * quentity
            let apend2=` 
            <div class="table_new4" >
             <div class="cs" style="width:10%; text-align: center;"></div>
             <div  style="width: 50%; font-size:2vw;">${pro[0].product_name}</div>
             <div class="cs" style="width: 30%; font-size:2vw;">Qty= ${q }</div>
             <div  style="width:10%;"></div>
           </div>
             `;
              $('#bari_recipt').append(apend2);
        }
     });
    });
}

//this function append extra component to table
 function apendextra(data,i,payment)
 {  

     $('#sr_number2').text(payment.sr_number)
    let apend2=` 
             <div class="table_new4" style="margin-top:5%">
                <div style="width:10%; text-align: center;"></div>
                <div  style="width: 80%;">Components:</div>
                 <div style="width:10%; text-align: center;"></div>
               </div> `;
            $('#bari_recipt').append(apend2);
    
    $.each(data,function(key3,pro2)
    {
      let q=pro2.product_quality;
      if(!q)
      {

         let apend2=` 
                  <div class="table_new4" >
                   <div style="width:10%; text-align: center;">0${i++}</div>
                    <div  style="width: 80%;">${pro2.description}  </div>
                    <div style="width:10%; text-align: center;">${pro2.shelf_quentity}</div>
                    </div> `;
                    $('#bari_recipt').append(apend2);
       
      }else
      {      
          let qualities=JSON.parse(q)
        let apend2=` 
                  <div class="table_new4" >
                   <div style="width:10%; text-align: center;">0${i++}</div>
                    <div  style="width: 80%;">${pro2.description} ${qualities.size}
                    <p style="font-size:1.6vw;font-weight:500">Color:${qualities.color},Modal:${qualities.modal},Thickness:${qualities.thickness}</p> </div>
                    <div style="width:10%; text-align: center;">${pro2.shelf_quentity}</div>
                    </div> `;
                    $('#bari_recipt').append(apend2);
      }
        
    });
 }

//this function append extra component to table
 function apendextra2(data)
 {  

    let apend2=` 
              <div class="table_invoice3" >
                   <div style="width:10%; text-align: center;">01</div>
                      <div  style="width:40%;"><strong style="font-size:3vw"> Component</strong> 
                     </div>
                   <div style="width:15%;"></div>
                   <div style="width:10%;"></div>
                   <div style="width:10%;"></div>
                   <div style="width:15%; "></div>
                </div> `;
            $('#bari_invoice_recipt').append(apend2);
    
    $.each(data,function(key3,pro2)
    {
       let q=pro2.product_quality;
       if(!q)
       {
         let apend2=`  
                  <div class="table_invoice3" >
                   <div style="width:10%; text-align: center;">01</div>
                      <div  style="width:40%;"><strong style="font-size:2vw"> ${pro2.description}</strong>
                      </div>
                   <div style="width:15%; text-align:center">${pro2.size}</div>
                   <div style="width:10%; text-align:center">${pro2.shelf_quentity}</div>
                   <div style="width:10%; text-align:center">${pro2.price}</div>
                   <div style="width:15%; text-align:center">${pro2.shelf_quentity * pro2.price}-</div>
                  </div>  `;
             $('#bari_invoice_recipt').append(apend2);
       }else
       {
         let qualities=JSON.parse(q)
         let apend2=`  
                  <div class="table_invoice3" >
                   <div style="width:10%; text-align: center;">01</div>
                      <div  style="width:40%;"><strong style="font-size:2vw"> ${pro2.description}${qualities.size}</strong>
                       <p style="font-size:1.6vw;font-weight:500">Color:${qualities.color},Modal:${qualities.modal},Thickness:${qualities.thickness}</p></div>
                   <div style="width:15%; text-align:center">${pro2.size}</div>
                   <div style="width:10%; text-align:center">${pro2.shelf_quentity}</div>
                   <div style="width:10%; text-align:center">${pro2.price}</div>
                   <div style="width:15%; text-align:center">${pro2.shelf_quentity * pro2.price}-</div>
                  </div>  `;
             $('#bari_invoice_recipt').append(apend2);
       }
       
    });
 }

// on refresh refresh data of daily sale ,expences, and net sale
  dailySale()
 function dailySale()
  {
    $.ajax({
           url:'/bari/daily/sale',
       }).done(function(res)
       {
          $('#bari_total_sale').val('Rs. '+ Number.parseFloat(res.sale).toFixed(1) )
          $('#bari_total_recived').val('Rs. '+ Number.parseFloat(res.recieve).toFixed(1) )
          $('#bari_net-sale').val('Rs. '+  Number.parseFloat(res.netsale).toFixed(1))
          $('#new_expence').val('Rs. '+  Number.parseFloat(res.exp).toFixed(1) )
        
        }).fail(function()
        {
           console.log('fail to fetch daily sale data')
        });
  } 

});