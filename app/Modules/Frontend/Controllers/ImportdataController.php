<?php namespace App\Modules\Frontend\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Student;
use DB;
// use Excel;


class ImportdataController extends Controller {

    
    // public function getImport(){
    //     return view('Frontend::pages.import');
    // }

    // public function postImport(Request $request){
    //     if($request->hasFile('file')){
    //         $file = $request->file('file');
    //         $path = $file->getRealPath();
    //         $data = Excel::load($path,function($reader){})->get();
    //         if(!empty($data) && $data->count()){
    //             foreach($data as $key => $val){
    //                 $insert[] = ['name' => $val->name, 'student_account'=>$val->account,'center_code'=>$val->center,'age'=>$val->age];
    //             }
    //             if(!empty($insert)){
    //                 foreach(array_chunk($insert,100) as $t){
    //                     DB::table('students')->insert($t);
    //                 }
    //                 dd('Done');
    //             }
    //         }
    //     }
    // }

}
