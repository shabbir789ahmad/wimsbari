$(document).ready(function(){

 $(document).on('click','.create_customer',function()
 {  
   // print customer name
    let customer_name=$('#customer_name').val();
    let reciept_type=$('#reciept_type').val();
    $('#customer_name_print').text(customer_name)
          alert('sd')
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
               let type=1;//if type is 1 than apend response to panel view  
               customer(type)
               $('#form_id').trigger("reset");

            }).fail(function(res){
                  console.log('fail to ad customer')
            });
  });


  //get all customer 
  function customer(type)
  {
    $.ajax({
              url: baseURL + 'pos/customer',
          })
           .done(function(res) 
           {
              $('#all_customer').empty();
              $('#customer_id').empty();
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
                }else
                {
                    $('#customer_id').append(`
                        
                     <option value="${ val.id }">${ val.customer_name }</option>
                        
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