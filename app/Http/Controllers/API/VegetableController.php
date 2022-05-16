<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Vegetable;
use Illuminate\Http\Request;

class VegetableController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $name = $request->input('name');
        $types = $request->input('types');

        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');
        
        $rate_from = $request->input('rate_from');
        $rate_to = $request->input('rate_to');
    
        if($id){
            $vegetable = Vegetable::find('id');

            if($vegetable){
                return ResponseFormatter::success(
                    $vegetable,
                    'Vegetable Data has Successfully Fetched'
                );
            }else{
                return ResponseFormatter::error(
                    null, 
                    'Vegetable Data Not Found', 
                    404);
            }
        }

        $vegetable = Vegetable::query();

        if($name){
            $vegetable->where('name','like','%'.$name.'%');
        }
        
        if($types){
            $vegetable->where('types','like','%'.$types.'%');
        }

        if($price_from){
            $vegetable->where('price','>=',$price_from);
        }
        if($price_to){
            $vegetable->where('price','<=',$price_to);
        }
        
        if($rate_from){
            $vegetable->where('rate','>=',$rate_from);
        }
        if($rate_to){
            $vegetable->where('rate','<=',$rate_to);
        }

        return ResponseFormatter::success(
            $vegetable->paginate($limit),
            'Vegetable List Data has Succesfully Fetched'
        );
    }
}
