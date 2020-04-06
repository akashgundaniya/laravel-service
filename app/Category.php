<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $fillable = ['name','parent_id'];


    /**
     * Get the index name for the model.
     *
     * @return string
    */
    public function childs() {
        return $this->hasMany('App\Category','parent_id','id') ;
    }

	 public static function getMainCategoriesPluck(){ 
	    return self::where('parent_id','=',0)->get()->pluck('name','id'); 
	 } 

	 public static function getAllSubCategoriesPluck(){ 
	    return self::where('parent_id','!=',0)->get()->pluck('name','id'); 
	 }

    public static function getSubCategoriesPluck($categoryId){ 
        return self::where('parent_id','=',$categoryId)->get()->pluck('name','id'); 
    }
    public static function getSubCategoriesByCatId($cat_id){
        $subCategories = [];
        if($cat_id != 0){
            $subCategories = self::whereParentId($cat_id)->pluck('name','id'); 
        }
        return $subCategories; 
    }
}