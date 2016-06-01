<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MainController extends Controller
{
    public function index()
    {
        return view('index');
    }
    
    public function getById(Request $request)
    {
        $id = $request->input('id');
        $result = [];
        if ( $id ) {
            $result = app('db')->table('zipcodes')->select(['id','name','zipcode_prefecture_id as prefecture_id','zipcode_prefecture_name as prefecture_name','zipcode_city_id as zipcode_city_id','zipcode_city_name as city_name'])->where('id','=',$id)->first();
        }
        return new JsonResponse($result);
    }

    public function getByZipcode(Request $request)
    {
        $code = mb_convert_kana(str_replace("-","",$request->input('code')),"n","utf8");

        $result = [];
        if ( $code ) {
            $result = app('db')->table('zipcodes')->select(['id','name','zipcode_prefecture_id as prefecture_id','zipcode_prefecture_name as prefecture_name','zipcode_city_id as zipcode_city_id','zipcode_city_name as city_name'])->where('code','=',$code)->get();
        }
        return new JsonResponse($result);
    }
    public function js()
    {
	$response = new Response(view('js'),200);
	$response->header('Content-Type','text/javascript');
	return $response;
    }
}
