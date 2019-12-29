<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

trait ApiResponse //make this for response
{
	private function successResponse($data,$code){
		return response()->json($data,$code);
	}
	protected function errorResponse($message,$code){
		return response()->json(['error'=>$message],$code);
	}


	protected function showAll(Collection $collection,$code=200){
		if($collection->isEmpty())
			return $this->successResponse($collection,$code);
		$transformer = $collection->first()->transformer;
		$collection = $this->sortData($collection, $transformer);
		$collection = $this->filterData($collection, $transformer);
		$collection = $this->dataTransformer($collection, $transformer);
		
		// $collection = $this->paginate($collection);
		//$collection = $this->cacheResponse($collection);
		return $this->successResponse($collection,$code);
	}


	protected function showOne(Model $model,$code = 200){
		$transformer = $model->transformer;
		$model = $this->dataTransformer($model, $transformer);
		return response()->json(['data'=>$model],$code);
	}
	protected function showMessage($message,$code = 200){
		return response()->json(['data'=>$message],$code);
	}
	protected function paginate(Collection $collection,$prePage = 15){
		Validator::validate(request()->all(),[
			'pre_page' => 'integer|min:2|max:50'
		]);
		if(request()->has('pre_page'))
			$prePage = request()->pre_page;
		$page = LengthAwarePaginator::resolveCurrentPage(); // for get the crrent page
		//[LengthAwarePaginator] implament use Illuminate\Pagination\LengthAwarePaginator;
		//[prePage] => count of collection in page.
		// [(($page-1) * $prePage)] => this for calculate index of collection that will start from it.
		//[slice] => for cut collection from (start , end)
		$result = $collection->slice((($page-1) * $prePage), $prePage)->values();
		$paginate = new LengthAwarePaginator($result,$collection->count(),$prePage,$page,[
			'path' => LengthAwarePaginator::resolveCurrentPath(),
		]);
		return $paginate;
	}
	//for transformer ..
	protected function dataTransformer($data, $transformer){
		$transformation = fractal($data, new $transformer);
		return $transformation->toArray();
	}
	protected function sortData(Collection $collection, $transformer){
		if(request()->has('sort_by')){
			$attribute = $transformer::originalAttribute(request()->sort_by);
			$collection = $collection->sortBy($attribute);
		}
		return $collection;
	}
	protected function filterData(Collection $collection , $transformer){
		foreach (request()->query as $query => $value) {
			$attribute = $transformer::originalAttribute($query);
			if(isset($attribute, $value))
				$collection = $collection->where($attribute, $value);
		}
		return $collection;
	}
	protected function cacheResponse($data){ // it will save data util if you deleted
		$url = response()->url();
		//$queryParams = request()->query();
		//ksort($queryParams);
		//$queryString = http_build_query($queryParams);
		//$fullUrl = '{$url}?{$queryString}';
		return Cache::remember($url,30/60,function() use($data){
			return $data;
		});
	}
}