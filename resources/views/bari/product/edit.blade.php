    @extends('bari.master')
    @section('content')

    <form action="{{ route('bari.product.update',['id'=>$product['id']]) }}" method="POST" enctype="multipart/form-data" id="create_edit">
    	@csrf
        @method('PUT')
    	<div class="row">
    	 <div class="col">
    	  <div class="card">
    	   <div class="card-body">
    		<div class="row">

              <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Brand <span class="text-danger">*</span>
                                    </label>
                <select name="bri_brand_id" class="form-control ">
                
                   @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $product['bri_brand_id']== $brand->id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                  @endforeach
                                    </select>
                                    <span class="text-danger small">@error ('brand_id') <i class="fa fa-times-circle"></i>{{$message}} @enderror</span>
                                </div>
                            </div>

    		  <div class="col-12 col-md-6">
    		    <div class="form-group">
    			 <label for="">Category
                  <span class="text-danger">*</span>
    			 </label>
    			 <select name="bri_category_id" class="form-control">
    			  
    				@foreach($categories as $category)
    				<option value="{{ $category->id }}" {{ $product['bri_category_id']== $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
    				@endforeach
    		     </select>
    	         <span class="text-danger small">@error ('category_id') <i class="fa fa-times-circle"></i>{{$message}} @enderror</span>
    							</div>
    						</div>
    						
    					</div>
    					<div class="row" id="">
                            <input type="hidden" name="quotation" value="{{$product['quotation']}}">
    						<div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="">
                              Product Name <span class="text-danger">*</span>
                            </label>
                         <x-forms.input name="bri_product_name" value="{{$product['bri_product_name']}}"></x-forms.input>
                        </div>
                       </div>

                       <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="">
                              Product Size <span class="text-danger">*</span>
                            </label>
                         <x-forms.input name="size" value="{{$product['size']}}"></x-forms.input>
                        </div>
                       </div>

                       <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="">
                              Per Product Rate/Price  <span class="text-danger">*</span>
                            </label>
                         <x-forms.input name="rate" value="{{$product['rate']}}"></x-forms.input>
                        </div>
                       </div>
                       <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="">
                               Product Image  <span class="text-danger">*</span>
                            </label>
                         <input type="file" class="form-control" name="image" />
                        </div>
                       </div>
               </div>
               <div class="row"> 
             @foreach($product->components as $component)
       
                       <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="">
                                         Total Quentity <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="bri_quentity[]" class="form-control" value="{{$component->bri_quentity}}">
                                    
                                </div>
                            </div>
                            
                <div class="col-12 col-md-4">
                <div class="form-group">
                 <label for=""> Total Sizes 
                  <span class="text-danger">*</span>
                 </label>
    			 <select class="form-control" name="bri_product_id[]" >
    			  @foreach($productComponents as $product)
                  @if($product['sub_category_id']==$component->sub_category_id)
                   <option value="{{$product['id']}}">{{$product['product_name']}}</option>
                   @endif
                   @endforeach
    			 </select>

                  </div>
                </div>
                       <input type="hidden" name="ids[]" value="{{$component['id']}}">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="">
                                         Category Name <span class="text-danger">*</span>
                                    </label>
                                    
                                    <input type="text" name="category_name[]" class="form-control" value="{{$component->category_name}}" readonly>
                                </div>
                            </div>
    						
    					
    				@endforeach	
    					</div>
                      
                        
                        
    					<div class="row">
    						<div class="col-12">
    							
                               
                                <button type="submit" id="create_button_submit" class="btn btn-primary" >
                                    Update
                                </button>
                             
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </form>

    @endsection
