$(document).ready(function(){

$('#search_by_customer').change(function(){
 	 let id=$(this).val();
 	 $('#by_customer').val(id)
 	 $('#search_form').submit()
 });
 $('#category_id').change(function(){
 	 let id=$(this).val();
 	 $('#by_category_id').val(id)
 	 $('#search_form').submit()
 });
  $('#brand_search').change(function(){
 	 let id=$(this).val();
 	 $('#by_brand_id').val(id)
 	 $('#search_form').submit()
 });

})