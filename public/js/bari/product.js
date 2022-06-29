$(document).ready(function(){

  $('#paying_by').change(function(){
    let payment_type=$(this).val();
    if(payment_type=='Bank')
    {
      $('#cheque_detail').css('display','flex')
    }else
    {
       $('#cheque_detail').css('display','none')    	
    }
  })

});