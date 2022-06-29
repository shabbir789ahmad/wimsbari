<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Unit;
use App\Models\ProductBrand;
use App\Models\WhereHouse;
use App\Http\Traits\ProductTrait;
use App\Http\Requests\ProductRequest;
use DB;
use Auth;
use App\Repository\ProductRepository;
class ProductController extends Controller {

    use ProductTrait;
    
    protected $stock = null;
    
    public function __construct(ProductRepository $stock)
    {
        $this->stock = $stock;
    }

    public function index() 
    {
        $products= Product::getProducts(); //from product trait
        $categories= $this->category();
        $sub_categories= $this->scategory();
        $brands= $this->brand();
        $stocks=$this->stock->getAllStock();
       
        return view('panel.products.index', compact('products','categories','brands','sub_categories','stocks'));
    }
    
    public function create()
    {

        $categories= $this->category();//from prodyuct trait
        $brands= $this->brand();//from prodyuct trait
        $units = Unit::Branch()->get();
        $wherehouses = WhereHouse::wherehouses();

        return view('panel.products.create', compact('categories', 'brands', 'units','wherehouses'));
    }

    //create single product

  public function store(ProductRequest $request)
   {
    if ($_FILES && $_FILES['image']['tmp_name']) {
            
            $uploader = new \App\Services\ImageUploadService($_FILES['image']);

            $file = $uploader->upload();

            $request->request->add(['product_image' => $file]);

        }
     
     foreach($request->sell_by as $sel)
     {
        if ($sel == 'unit') {

            $unit = $request->unit_id;
            $price = $request->price_per_unit;

        } elseif($sel == 'piece') {

            $unit = 1;
            $price = $request->price_per_piece;

        }
     }
        
   // create json colunm for color modal and size filed
    $product_qualities=['size'=>$request->product_size,'color'=>$request->product_color,'modal'=>$request->prodcut_modal];
      
    

        $sell=implode(", ", $request->sell_by);
        $product =
            [
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'product_name' => $request->product_name,
                'pack_quentity' => $request->quentity_per_pack,
                'branch_id' => Auth::user()->branch_id,
                'tax' => $request->vat??null,
                'unit_id' => $unit,
                'sell_by' => $sell,
                'admin_id'=>Auth::id(),
                'product_qualities'=>json_encode($product_qualities),
                'where_house_id'=>$request->where_house_id,
                'product_image' => $request->get('product_image')??null,
            ];


        DB::transaction(function() use($request,$product)
        {
           $data=Product::create($product);
           $brand= ProductBrand::create([

                 'brand_id' =>$request->brand_id,
                 'product_id' =>$data['id'],
                 'barcode' =>$request->barcode??null,
                 'unit_barcode' =>$request->unit_barcode??null,
                 
              ]);

            ProductStock::create([
            
                'stock' =>$request->stock,
                'pbrand_id'  =>$brand['id'],
                'product_price_piece' => $request->product_price_piece,
                'product_price_unit' => $request->product_price_unit>>null,
                'product_price_piece_wholesale' => $request->product_price_piece_wholesale??null,
                'product_price_unit_wholesale' => $request->product_price_unit_wholesale??null,
                'purchasing_price' => $request->purchasing_price,
                'active'=> 1,
                'branch_id'=>Auth::user()->branch_id,
               ]);
            
         });

       return redirect()->route('products.index')->with('flash', 'success');
    }

    //get single prodycuct for edit
  public function edit($id) 
   {
        
     $product = Product::leftjoin('product_brands','products.id','=','product_brands.product_id')
         ->select('products.category_id','products.sub_category_id','products.product_name','product_brands.barcode','products.unit_id','product_brands.brand_id','product_brands.id','product_brands.product_id','products.sell_by','products.tax','product_brands.unit_barcode','products.pack_quentity','products.where_house_id')
         ->where('product_brands.product_id',$id)
         ->first();
    
        $units = Unit::Branch()->get();
        $categories= $this->category();//from prodyuct trait
        $sub_categories= $this->scategory();//from prodyuct trait
        $brands= $this->brand();//from prodyuct trait
        $stock=ProductStock::where('pbrand_id',$product['id'])->where('active',1)->first();
       $wherehouses = WhereHouse::wherehouses();
    
     return view('panel.products.edit', compact('categories', 'sub_categories', 'product', 'brands', 'units','stock','wherehouses'));

    }


    // delete product
    public function destroy($id)
    {
        Product::destroy($id);        
        return redirect()->route('products.index')->with('flash', 'success');
    }

    //update product in bulk
  public function updateProduct(Request $request) 
  {

  try{

        for ($i=0; $i < count($request->name) ; $i++) 
        { 
            $temp =Product::findorfail($request->id[$i]);
            
            $temp->product_name = $request->name[$i];
            $temp->branch_id = Auth::user()->branch_id;
            $temp->save();
          
            //update brand and stock also
            // $brand=ProductBrand::where('product_id', $request->id[$i])->first();
            // $brand->save();

       
            $stock=ProductStock::Branch()->where('pbrand_id', $request->pbrand_id[$i])->first();
            if(!empty($stock))
            {
              $stock->stock=$request->stock[$i];
              $stock->product_price_piece = $request->product_price_piece[$i] ?? null;
              $stock->product_price_piece_wholesale = $request->product_price_piece_wholesale[$i] ?? null;
              $stock->product_price_unit = $request->product_price_unit[$i] ?? null;
              $stock->product_price_unit_wholesale = $request->product_price_unit_wholesale[$i] ?? null;
              $stock->purchasing_price=$request->purchasing_price[$i];
              $stock->branch_id=Auth::user()->branch_id;
              $stock->save();
            
            }else
            {
              ProductStock::create(
                [
                  'pbrand_id' => $request->pbrand_id[$i],
                  'stock'=> $request->stock[$i] ?? null,
                  'product_price_piece' => $request->product_price_piece[$i] ?? null,
                  'product_price_piece_wholesale' => $request->product_price_piece_wholesale[$i] ?? null,
                  'product_price_unit' => $request->product_price_unit[$i] ?? null,
                  'product_price_unit_wholesale' => $request->product_price_unit_wholesale[$i] ?? null,
                  'purchasing_price'=>$request->purchasing_price[$i],
                  'branch_id'=>Auth::user()->branch_id,
                ]);
            }

        }
          return redirect()->route('products.index')->with('flash','success');

   }catch(\Exception $e) 
    {

    return redirect()->back()->with('flash', 'error');
            
   }

  }//update bulk end here
   


// below  two function use for update in bulk

  // this function show all product on bulk page
    public function UpdateBluk(Request $req)
    {
       

        $categories = $this->category();
        $products=Product::getProducts(); //from product model
        $sub_categories = $this->scategory();
        $brands = $this->brand();
        $stocks=$stocks=$this->stock->getAllStock();
        $wherehouses=WhereHouse::wherehouses();
        return view('panel.products.update_bulk', compact('products','categories','brands','sub_categories','stocks','wherehouses'));

    }


  // this function get select product to the update page
  //to update single or bulk post function written a
  // with the name updateProduct()
     public function getProduct2(Request $req) {
 
        $products = Product::Branch()->findOrFail($req->id);
        foreach($products as $product)
        {
            $product->brand=ProductBrand::where('product_id',$product['id'])->first();
        }
            
        $categories= $this->category();//from prodyuct trait
        $sub_categories= $this->scategory();//from prodyuct trait
        $brands= $this->brand();//from prodyuct trait
        $units = Unit::Branch()->get();
     
        return view('panel.products.update_product', compact('products','brands','categories','sub_categories','units'));
     }

    





  






    

    

  
    

}