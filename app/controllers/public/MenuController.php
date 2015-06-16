<?php

class MenuController  extends BaseController {

	public function getMenu(){
		$savData = MenuRecipes::orderBy(DB::raw('RAND()'))->where('fedup_active', '=', 1)->where('savoury', '=', 1)
			->with(array('MenuCategories' => function($query)
			{
				$query->where('menu_categories.active', '=', 1);
			}))
			
			->with(array('Images' => function($query){
				$query->where('images.ordering', '=', 0)->where('section', '=', 'RECIPE')->where('active', '=', 1);
			}))
		
		->get();

		$snaData = MenuRecipes::orderBy(DB::raw('RAND()'))->where('fedup_active', '=', 1)->where('snack', '=', 1)
			->with(array('MenuCategories' => function($query)
			{
				$query->where('menu_categories.active', '=', 1);
			}))
			
			->with(array('Images' => function($query){
				$query->where('images.ordering', '=', 0)->where('section', '=', 'RECIPE')->where('active', '=', 1);
			}))
		
		->get();

		$desData = MenuRecipes::orderBy(DB::raw('RAND()'))->where('fedup_active', '=', 1)->where('dessert', '=', 1)
			->with(array('MenuCategories' => function($query)
			{
				$query->where('menu_categories.active', '=', 1);
			}))
			
			->with(array('Images' => function($query){
				$query->where('images.ordering', '=', 0)->where('section', '=', 'RECIPE')->where('active', '=', 1);
			}))
		
		->get();

		$refData = MenuRecipes::orderBy(DB::raw('RAND()'))->where('fedup_active', '=', 1)->where('refreshment', '=', 1)
			->with(array('MenuCategories' => function($query)
			{
				$query->where('menu_categories.active', '=', 1);
			}))
			
			->with(array('Images' => function($query){
				$query->where('images.ordering', '=', 0)->where('section', '=', 'RECIPE')->where('active', '=', 1);
			}))
		
		->get();

		$count = count($savData);
		if($count == 0){
			// echo '<pre>e'; print_r($savData); echo '</pre>'; exit;
			$savCount = 0;
			$savData = 0;
			$sav_image = 0;
		}else{
			$savCount = 1;
			foreach ($savData as $sav) {

				$count = count($sav->MenuCategories);
				if($count > 0){
					$category[$sav->id] = $sav->MenuCategories;
				}else{
					$category[$sav->id] = '';
				}
				$count = count($sav->Images);
				if($count < 1){
					$sav_image[$sav->id] = 'recipe.png';
				}else{
					foreach($sav->Images as $image){
				        if(file_exists('uploads/'.$image->name)){
				            $sav_image[$sav->id] = $image->name;
				        }else{
				           	$sav_image[$sav->id] = 'recipe.png';
				        }
					}
				}
			}
		}

		$count = count($snaData);
		if($count == 0){
			// echo '<pre>e'; print_r($savData); echo '</pre>'; exit;
			$snaCount = 0;
			$snaData = 0;
			$sna_image = 0;
		}else{
			$snaCount = 1;
			foreach ($snaData as $sna) {
				$count = count($sna->MenuCategories);
				if($count > 0){
					$category[$sna->id] = $sna->MenuCategories;
				}else{
					$category[$sna->id] = '';
				}
				$count = count($sna->Images);
				if($count < 1){
					$sna_image[$sna->id] = 'recipe.png';
				}else{
					foreach($sna->Images as $image){
				        if(file_exists('uploads/'.$image->name)){
				            $sna_image[$sna->id] = $image->name;
				        }else{
				           	$sna_image[$sna->id] = 'recipe.png';
				        }
					}
				}
			}
		}

		$count = count($desData);
		if($count == 0){
			// echo '<pre>e'; print_r($savData); echo '</pre>'; exit;
			$desCount = 0;
			$desData = 0;
			$des_image = 0;
		}else{
			$desCount = 1;
			foreach ($desData as $des) {
				$count = count($des->MenuCategories);
				if($count > 0){
					$category[$des->id] = $des->MenuCategories;
				}else{
					$category[$des->id] = '';
				}
				$count = count($des->Images);
				if($count < 1){
					$des_image[$des->id] = 'recipe.png';
				}else{
					foreach($des->Images as $image){
				        if(file_exists('uploads/'.$image->name)){
				            $des_image[$des->id] = $image->name;
				        }else{
				           	$des_image[$des->id] = 'recipe.png';
				        }
					}
				}
			}
		}

		$count = count($refData);
		if($count == 0){
			// echo '<pre>e'; print_r($savData); echo '</pre>'; exit;
			$refCount = 0;
			$refData = 0;
			$ref_image = 0;
		}else{
			$refCount = 1;
			foreach ($refData as $ref) {
				$count = count($ref->MenuCategories);
				if($count > 0){
					$category[$ref->id] = $ref->MenuCategories;
				}else{
					$category[$ref->id] = '';
				}
				$count = count($ref->Images);
				if($count < 1){
					$ref_image[$ref->id] = 'recipe.png';
				}else{
					foreach($ref->Images as $image){
				        if(file_exists('uploads/'.$image->name)){
				            $ref_image[$ref->id] = $image->name;
				        }else{
				           	$ref_image[$ref->id] = 'recipe.png';
				        }
					}
				}
			}
		}

		return View::make('public.menu')->with(array(
			'savData' => $savData,
			'savImage' => $sav_image,
			'snaData' => $snaData,
			'snaImage' => $sna_image,
			'desData' => $desData,
			'desImage' => $des_image,
			'refData' => $refData,
			'refImage' => $ref_image,
			'category' => $category,

			'savCount' => $savCount,
			'snaCount' => $snaCount,
			'desCount' => $desCount,
			'refCount' => $refCount,
			)
		);

	}
}
