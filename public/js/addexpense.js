$(document).ready(function()
{

	$(document).on('click','#expense_type2,#expense_type',function(e)
    {  
         $('#add_expense_type').attr('data-id',$(this).data('id'))
         e.preventDefault()
         $('#expenseModal').modal('show')
     });

 
  $(document).on('click','#add_expense_type',function()
  {
   let id=$(this).data('id')
    $.ajax({

          url: '/expense',
          type: 'POST',
          datatype: 'json',
          data:{
                 "_token": $('#csrf-token')[0].content ,
            	'expence_type' : $('#expence_type').val()
               },
         })
        .done(function()
        {
            if(id===1)
            {
                    location.reload()
             }else{
                getExpenseType()
             }
           $('#expenseModal').modal('hide')
  	    });//ajax end

  });


  


// add new expenses with ajax

  $(document).on('click','#new_expence',function(e)
  {  
      
       $('#add_new_expense').attr('data-id',$(this).data('id'))
       getExpenseType();
       e.preventDefault()
      $('#new_expenses_modal').modal('show')
   })


    $('#add_new_expense').click(function(e)
    {  
        let id=$(this).data('id')
        e.preventDefault()
        $('#new_expenses_modal').modal('hide')
        $.ajax({
         
              url : "/expence",
              type : 'POST',
              dataType : 'json',
              data: {
                       "_token": $('#csrf-token')[0].content ,
                       e_type: $('.expense_types').val(),
                       expense_amount:$('#expense_amount').val(),
                       expense_user:$('#expense_user').val(),
                    }
               })
               .done(function(res)
               {
                //if id is 1 then reload page else it is for pos wich cannot be reloaded
                 if(id==1)
                 {
                    location.reload()
                 }
           
                }).fail(function(res){
                     alert('something went Wrong');
                });
    });


    function getExpenseType()
    {
         $.ajax({
                   url : "/expense/create",
                   type : 'GET',
                   dataType : 'json',
                  
               })
                .done(function(res)
                {
                  $('.expense_types').empty();
                  $('.expense_types').append(`<option selected disabled hidden>Select Expense Type</option>`);
                 $.each(res,function(index,val) {

                     $('.expense_types').append(`
                         <option value="${val.id}">${val.expence_type}</option>
                        `);
                 })
          
                });
    }
});
