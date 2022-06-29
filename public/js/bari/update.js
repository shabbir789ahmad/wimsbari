$(document).ready(function(){

   $(document).on('change','.update_bari_product',function()
       {
       
         $.ajax({
         
                    url : "/bari/update/orders",
                    type : 'POST',
                    data: {
                       "_token": $('#csrf-token')[0].content ,
                        
                        id : $(this).data('id'),
                        quentity : $(this).val(),
                        
                      
                    },
                success: function (res){
                
                 if(res.success)
                {
                  snack(1,res.success)
                }else{
                  snack(0,res.fail)
                }
                 appendProduct(res);
                 sumCount();
                 quentityCount();
                 }
                 });

       });


   $(document).on('change','.update_bari_component',function()
       {
       
         $.ajax({
         
                    url : "/bari/update/orders/component",
                    type : 'POST',
                    data: {
                       "_token": $('#csrf-token')[0].content ,
                        
                        id : $(this).data('id'),
                        quentity : $(this).val(),
                        
                      
                    },
                success: function (res){
                
                 if(res.success)
                {
                  snack(1,res.success)
                }else{
                  snack(0,res.fail)
                }
                 appendProduct(res);
                 sumCount();
                 quentityCount();
                 }
                 });

       });



});