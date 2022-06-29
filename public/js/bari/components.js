$(document).ready(function()
{

   $(document).on('click','.hide_component',function(){
     let id=$(this).data('id')
      $(this).css('background','#5CB85C').text('Add').addClass('show_component ').removeClass('hide_component')
    });



	$(document).on('click','.show_component',function()
	{
		
          let $this=$(this);
		  $(this).css('background','red').text('Hide').addClass('hide_component').removeClass('show_component');
		  
	
		// alert(id2)
        $.ajax({
                 cache:false,
                 url : "/bari/components",
                 type : 'GET',
                 data:
                   {
              
                      id : $(this).data('id'),
                   
                    }  
              }).done(function(res)
              {


                 let ph='';
              	 $this.parents('.brn').parents('.r').parents('.p').next('.component_apend').empty()
              	 $.each(res,function(key,item)
              	 {
                   ph = baseURL + "uploads/products/" + item[0].product_image;
                    
                    $this.parents('.brn').parents('.r').parents('.p').next('.component_apend').append(`

                       <a href="#" class="p customer-tr2  border-bottom"  tabIndex="-1">
                       <div class="row r">
                       <div class="col-md-1 px-0"><img src="${ph}" class="img-thumbnail mr-1 card-img" alt="..."  loading="lazy"></div>
                       <div class="col-md-4 product-font font px-0 "><h6>${item[0].product_name}</h6>

                       </div> 
                       <div class=" col-md-5 brn text-center p-0 o " >
                        <button class="btn  single_brand text-light text-left mt-2 pos-product p-2 mb-0" data-id="${item[0].id}" style="width:15rem;background-color:#17A2B8">${item[0].product_name}<span class="float-right"></span></button>

                       </div>
                       <div class="w col-md-2 px-0 "> 
                       <div class="float-right mt-2">
                         <button class="mt-0 btn btn-md mr-2 text-light mb-1 ab" style="background:#5CB85C">R</button>
                        </div>
                       </div></div></a>

                 	`);
                 
              	})
                 
               


              }).fail(function(res)
              {
                
                 alert ('No Product Found ');

              }).always(function() 
              {
                console.log("complete");
               
             });


	   })

});