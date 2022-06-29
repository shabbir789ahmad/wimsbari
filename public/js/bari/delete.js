$(document).ready(function(){

  $(document).on('click','.remove_product',function(){

   $(this).parents('tr').remove();

    
     removeajax($(this).data('id'))
    
       

  });

  $(document).on('click','.remove_product_component',function(){
  
   $(this).parents('tr').remove();

    
     removeajax2($(this).data('id'))
    
       

  });

	 function removeajax(id)
    { 
      
      if(confirm('Are you sure to delete'))
    {
     
      $.ajax({
            url: "/bari/delete/", 
               
                method: "delete",
                data: {
                    "_token": $('#csrf-token')[0].content ,
                    id:id,
                },
                success: function (res)
                {
                     sumCount();
                     quentityCount();
                 }
            });
     }
           
  }

   function removeajax2(id)
    { 
      
      if(confirm('Are you sure to delete'))
    {
     
      $.ajax({
            url: "/bari/delete/component", 
               
                method: "delete",
                data: {
                    "_token": $('#csrf-token')[0].content ,
                    id:id,
                },
                success: function (res)
                {
                     sumCount();
                     quentityCount();
                 }
            });
     }
           
  }
})