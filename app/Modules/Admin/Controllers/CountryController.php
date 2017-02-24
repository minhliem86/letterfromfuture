<?php namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Notification;
use App\Http\Requests\ImageRequest;
use App\Models\Image as ImgModel;


class CountryController extends Controller {

	protected $country;

    protected $upload_folder = 'country';
    protected $upload_folder_banner = 'banner';
    protected $upload_sub_folder = "slider";

	public function __construct(Country $country){
		$this->country = $country;
	}

	public function index()
    {
        $country = $this->country->select('id','name','status','order','img_avatar')->get();
        return view('Admin::pages.country.index')->with(compact('country'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin::pages.country.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,ImageRequest $imgrequest, Country $country)
    {
        $order = $this->country->orderBy('order','DESC')->first();
        count($order) == 0 ?  $current = 1 :  $current = $order->order +1 ;

        if($imgrequest->hasFile('img')){
            $file = $imgrequest->file('img');
            $destinationPath = 'public/upload'.'/'.$this->upload_folder;
            $name = preg_replace('/\s+/', '', $file->getClientOriginalName());
            $filename = time().'_'.$name;

            $file->move($destinationPath,$filename);

            // $size = getimagesize($file);
            // if($size[0] > 620){
            //     \Image::make($file->getRealPath())->resize(620,null,function($constraint){$constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
            // }else{
            //     $file->move($destinationPath,$filename);
            // }

            $img_url = asset('public/upload').'/'.$this->upload_folder.'/'.$filename;
            // $img_alt = \GetNameImage::make('\/',$filename);
        }else{
            $img_url = asset('public/assets/backend/img/image_thumbnail.gif');
            // $img_alt = \GetNameImage::make('\/',$img_url);
        }

        if($imgrequest->hasFile('imgslide')){
            $file = $imgrequest->file('imgslide');
            $destinationPath = 'public/upload'.'/'.$this->upload_folder.'/'.$this->upload_sub_folder;
            $name = preg_replace('/\s+/', '', $file->getClientOriginalName());
            $filename = time().'_'.$name;

            // $file->move($destinationPath,$filename);
            $filename_resize = $destinationPath.'/'.$filename;
            $size = getimagesize($file);
             \Image::make($file->getRealPath())->resize(660,325)->save($filename_resize);

            $imgslide_url = asset('public/upload').'/'.$this->upload_folder.'/'.$this->upload_sub_folder.'/'.$filename;
            // $img_alt = \GetNameImage::make('\/',$filename);
        }else{
            $imgslide_url = asset('public/assets/frontend/images/default-img/country-default.jpg');
            // $img_alt = \GetNameImage::make('\/',$img_url);
        }

        $data = [
            'name'=>$request->name,
            'slug' => \Unicode::make($request->name),
            'description' => $request->description,
            'multi_countries' => $request->multi_countries,
            'home_show' => $request->home_show,
            'status'=> $request->status,
            'img_avatar'=> $img_url,
            'img_slide'=> $imgslide_url,
            'order'=>$current
        ];
        $country = $this->country->create($data);

        if($imgrequest->hasFile('img-banner')){
            $file = $imgrequest->file('img-banner');
            $destinationPath = 'public/upload'.'/'.$this->upload_folder.'/'.$this->upload_folder_banner;
            $name = preg_replace('/\s+/', '', $file->getClientOriginalName());
            $filename = time().'_'.$name;

            $filename_resize = $destinationPath.'/'.$filename;
             \Image::make($file->getRealPath())->resize(1170,350)->save($filename_resize);

            $imgbanner_url = asset('public/upload').'/'.$this->upload_folder.'/'.$this->upload_folder_banner.'/'.$filename;

            $order_img = ImgModel::orderBy('order','DESC')->first();
            count($order_img) == 0 ?  $current = 1 :  $current = $order_img->order +1 ;

            $image = new ImgModel(['img_url'=>$imgbanner_url,'status'=>1,'order'=>$current,'type'=>'banner_country']);
            $country->images()->save($image);
        }

        if($imgrequest->hasFile('img-banner-mobile')){
            $file = $imgrequest->file('img-banner-mobile');
            $destinationPath = 'public/upload'.'/'.$this->upload_folder.'/'.$this->upload_sub_folder;
            $name = preg_replace('/\s+/', '', $file->getClientOriginalName());
            $filename = time().'_'.$name;

            // $file->move($destinationPath,$filename);
            $filename_resize = $destinationPath.'/'.$filename;
            $size = getimagesize($file);
             \Image::make($file->getRealPath())->resize(800,600)->save($filename_resize);

            $imgslide_mobile_url = asset('public/upload').'/'.$this->upload_folder.'/'.$this->upload_sub_folder.'/'.$filename;

            $image = new ImgModel(['img_url'=>$imgslide_mobile_url,'status'=>1,'order'=>$current,'type'=>'banner_country_mobile']);
            $country->images()->save($image);
            // $img_alt = \GetNameImage::make('\/',$filename);
        }

        Notification::success('Created');
        return  redirect()->route('admin.country.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = $this->country->with('images')->find($id);
        // dd($country);
        return view('Admin::pages.country.view')->with(compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,ImageRequest $imgrequest, $id)
    {
        if($imgrequest->hasFile('img')){
            $file = $imgrequest->file('img');
            $destinationPath = 'public/upload'.'/'.$this->upload_folder;
            $name = preg_replace('/\s+/', '', $file->getClientOriginalName());
            $filename = time().'_'.$name;

            $file->move($destinationPath,$filename);

            // $size = getimagesize($file);
            // if($size[0] > 620){
            //     \Image::make($file->getRealPath())->resize(620,null,function($constraint){$constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
            // }else{
            //     $file->move($destinationPath,$filename);
            // }

            $img_url = asset('public/upload').'/'.$this->upload_folder.'/'.$filename;
        }else{
            $img_url = $request->input('img-bk');
        }

        if($imgrequest->hasFile('imgslide')){
            $file = $imgrequest->file('imgslide');
            $destinationPath = 'public/upload'.'/'.$this->upload_folder.'/'.$this->upload_sub_folder;
            $name = preg_replace('/\s+/', '', $file->getClientOriginalName());
            $filename = time().'_'.$name;

            // $file->move($destinationPath,$filename);
             $filename_resize = $destinationPath.'/'.$filename;
            $size = getimagesize($file);
            // dd($size);
            \Image::make($file->getRealPath())->resize(660,325)->save($filename_resize);
            // if($size[0] > 660){

            // }else{
            //     $file->move($destinationPath,$filename);
            // }

            $imgslide_url = asset('public/upload').'/'.$this->upload_folder.'/'.$this->upload_sub_folder.'/'.$filename;
        }else{
            $imgslide_url = $request->input('imgslide-bk');
        }

        $country = $this->country->find($id);
        $country->name = $request->name;
        $country->slug = \Unicode::make($request->name);
        $country->description = $request->description;
        $country->multi_countries = $request->multi_countries;
        $country->home_show = $request->home_show;
        $country->img_avatar = $img_url;
        $country->img_slide = $imgslide_url;
        $country->status = $request->status;
        $country->order = $request->order;
        $country->save();

        if($imgrequest->hasFile('img-banner')){
            $file = $imgrequest->file('img-banner');
            $destinationPath = 'public/upload'.'/'.$this->upload_folder.'/'.$this->upload_folder_banner;
            $name = preg_replace('/\s+/', '', $file->getClientOriginalName());
            $filename = time().'_'.$name;

            $filename_resize = $destinationPath.'/'.$filename;
             \Image::make($file->getRealPath())->resize(1170,350)->save($filename_resize);
            $imgbanner_url = asset('public/upload').'/'.$this->upload_folder.'/'.$this->upload_folder_banner.'/'.$filename;

            $order_img = ImgModel::orderBy('order','DESC')->first();
            count($order_img) == 0 ?  $current = 1 :  $current = $order_img->order +1 ;

            $image = new ImgModel(['img_url'=>$imgbanner_url,'status'=>1,'order'=>$current,'type'=>'banner_country']);
            $country->images()->save($image);
        }

        if($imgrequest->hasFile('img-banner-mobile')){
            $file = $imgrequest->file('img-banner-mobile');
            $destinationPath = 'public/upload'.'/'.$this->upload_folder.'/'.$this->upload_folder_banner;
            $name = preg_replace('/\s+/', '', $file->getClientOriginalName());
            $filename = time().'_'.$name;

            $filename_resize = $destinationPath.'/'.$filename;
             \Image::make($file->getRealPath())->resize(800,600)->save($filename_resize);
            $imgbanner_url_mobile = asset('public/upload').'/'.$this->upload_folder.'/'.$this->upload_folder_banner.'/'.$filename;

            $order_img = ImgModel::orderBy('order','DESC')->first();
            count($order_img) == 0 ?  $current = 1 :  $current = $order_img->order +1 ;

            $image = new ImgModel(['img_url'=>$imgbanner_url_mobile,'status'=>1,'order'=>$current,'type'=>'banner_country_mobile']);
            $country->images()->save($image);
        }

        Notification::success('Updated');
        return  redirect()->route('admin.country.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $this->country->destroy($id);
        \Notification::success('Remove Successful');
        return redirect()->route('admin.country.index');
    }

    public function deleteAll(Request $request){
        if(!$request->ajax()){
            return view('404');
        }else{
            $data = $request->arr;
            if($data){
                $this->country->destroy($data);
                return response()->json(array('msg'=>'ok'));
            }else{
                return response()->json(array('msg'=>'error'));
            }
        }
    }

    public function checkRelate(Request $request){
        $country = $this->country->find($request->dataid);
        $count = $country->image()->get()->count();
        if($count > 0){
            return response()->json(['msg'=>'yes']);
        }else{
            $country->delete();
            return response()->json(['msg'=>'done']);
        }
    }

    public function removeBanner(Request $request){
        if($request->ajax()){
            $img_id = $request->input('id');
            ImgModel::destroy($img_id);
            return response()->json(['rs'=>'ok']);
        }else{
            abort('404');
        }
    }

}