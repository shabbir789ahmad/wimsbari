$(document).ready(function(){

$(document).on('click','#customer,#customer_pos',function(){
     
        $('#customerModal').modal('show');
        let id=$(this).data('id');
        $('.create_customer').attr('data-id',id);
    });

 $(document).on('click','.create_customer',function()
 {  
   
    let type=$(this).data('id');
        
    $.ajax({
             url : "/customer",
             type : 'POST',
             datatype:'json',
             data: {
                "_token": $('#csrf-token')[0].content ,
                customer_group:$('#c_group').val(),
                customer_name:$('#customer_name').val(),
                customer_company:$('#customer_company').val(),
                customer_address:$('#customer_address').val(),
                customer_city:$('#customer_city').val(),
                customer_email:$('#customer_email').val(),
                customer_phone:$('#customer_phone').val(),
              },
                 
            }).done(function(res)
            {
               //if type is 1 than apend response to panel view  
               customer(type)
                $('#customerModal').modal('hide');
                
              if(type===1)
              {
              location.reload()
              }
            }).fail(function(res){
                  alert('fail to add customer')
            });
  });

 


$(document).on('click','#bari_quatation,#bari_invoice,#bari_payment',function(){

    let type=2;
    customer(type)

});
  //get all customer 
  function customer(type)
  {
    $.ajax({
              url:'/ajax/customer',
          })
           .done(function(res) 
           {
            
              $('#all_customer').empty();
              $('#customers').empty();
              $.each(res, function(index, val) 
              {

                if(type==1)
                {
                  $('#all_customer').append(`
                        
                      <tr>
                             <th scope="col">Customer Image</th>
                                <th scope="col">${ val.customer_name }</th>
                                <th scope="col">${ val.customer_address }</th>
                                <th scope="col">${ val.customer_phone}</th>
                                
                                <th scope="col">${ val.customer_email }</th>
                                
                                <td class=" d-flex">

                                    <a href="{{ route('customer.edit', ['customer' => ${val.id}]) }}" type="button" class="btn btn-xs btn-info ml-2" >
                                            Update 
                                        </a>
                                    <form action="{{ route('customer.destroy', ['customer' => ${val.id}]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger ml-2">
                                        Delete
                                    </button>
                                </form>
                                    
                            </td>
                       </tr>
                        
                    `);
                }else if(type===2)
                {
                  
                    $('#customers').append(`
                        
                     <option value="${ val.id }     ${ val.customer_name }">
                        
                    `);
                }
                 
              });

            })
            .fail(function()
             {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
   } 
});            