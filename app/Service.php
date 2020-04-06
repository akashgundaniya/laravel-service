<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = [
        'name', 'description',
    ]; 
    public function serviceCategory(){
        return $this->belongsTo('App\Category','category_id');
    }
    public function serviceSubCategory(){
        return $this->belongsTo('App\Category','sub_category_id');
    }
    public static function getActiveServices(){
        return self::whereStatus(1)->get()->pluck('name','id');
    }
    public static function getAllServices($parma = []){
        $categories = self::whereStatus(1);
        if(!empty($parma) && $parma['limit']){
           $categories = $categories->limit($parma['limit']);
        }
         $categories =  $categories->get();
        return  $categories ;
    }
}
