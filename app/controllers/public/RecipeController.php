<?php

class RecipeController  extends BaseController {

	public function getRecipes(){
		if(Auth::user()){
			$user = Auth::user();
			if($user->user_type == 'B2B'){
				$rData = MenuRecipes::orderBy(DB::raw('RAND()'))->where('fedup_active', '=', 1)
					->with(array('MenuCategories' => function($query)
					{
						$query->where('menu_categories.active', '=', 1);
					}))
					
					->with(array('Images' => function($query){
						$query->where('images.ordering', '=', 0)->where('section', '=', 'RECIPE')->where('active', '=', 1);
					}))
				
				->get();
			}else{
				$rData = MenuRecipes::orderBy(DB::raw('RAND()'))->where('fedup_active', '=', 1)
					->with(array('MenuCategories' => function($query)
					{
						$query->where('menu_categories.active', '=', 1);
					}))
					
					->with(array('Images' => function($query){
						$query->where('images.ordering', '=', 0)->where('section', '=', 'RECIPE')->where('active', '=', 1);
					}))
				
				->get();
			}
		}else{
			$rData = MenuRecipes::orderBy(DB::raw('RAND()'))->where('fedup_active', '=', 1)
				->with(array('MenuCategories' => function($query)
				{
					$query->where('menu_categories.active', '=', 1);
				}))
				
				->with(array('Images' => function($query){
					$query->where('images.ordering', '=', 0)->where('section', '=', 'RECIPE')->where('active', '=', 1);
				}))
			
			->get();
		}
	

		foreach ($rData as $recipe) {
			$count = count($recipe->MenuCategories);
			if($count > 0){
				$category[$recipe->id] = $recipe->MenuCategories;
			}else{
				$category[$recipe->id] = '';
			}
			$count = count($recipe->Images);
			if($count < 1){
				$recipe_image[$recipe->id] = 'recipe.png';
			}else{
				foreach($recipe->Images as $image){
			        if(file_exists('uploads/'.$image->name)){
			            $recipe_image[$recipe->id] = $image->name;
			        }else{
			           	$recipe_image[$recipe->id] = 'recipe.png';
			        }
				}
			}
		}


		
		if(isset($exrData) && isset($exRecipe_image))
			return View::make('public.recipes')->with(array(
				'rData' => $rData,
				'rImage' => $recipe_image,
				)
			);
		else{
			return View::make('public.recipes')->with(array(
				'rData' => $rData,
				'rImage' => $recipe_image,
				'category' => $category,
				)
			);
		}
	}
}
