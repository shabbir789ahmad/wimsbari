
   <div class="form-group">
    <label for="">Search By Customer<span class="text-danger">*</span>
    </label>
    <select  id="search_by_customer" class="form-control ">
     <option selected disabled hidden>Search By Customer</option>
     @foreach ($customers as $customer)
      
      <option value="{{$customer['id']}}" >{{$customer['customer_name']}}</option>
    
     @endforeach
    </select>
   </div>
