<?php
class RecipePageController  extends BaseController {

	public function getRecipe($id){
		if(Auth::user()){
			$user = Auth::user();
			$user_id = $user->id;
			// if(auth::check()){
				$sales_data = SalesData::where('menu_recipe_id', '=', $id)->get();
				$sales_count = count($sales_data);
				if($sales_count == 0){
					$sales_count = 0;
				}else{
					$sales_count = 1;
					foreach($sales_data as $sd){
						if($sd->sales_amount == 0){
							$sales_count = 0;
							// echo '<pre>'; print_r($sd->sales_amount); echo '</pre>';exit;
						}
						$sd->sales_amount = number_format($sd->sales_amount,0);
						$sd->total_recipe_grams = number_format($sd->total_recipe_grams,2);
						$sd->B2B_total_recipe_revenue = number_format($sd->B2B_total_recipe_revenue,2);
						$sd->total_grams_per_piece = number_format($sd->total_grams_per_piece,2);
						$sd->B2B_sales_price = number_format($sd->B2B_sales_price,2);
					}
				}
				
			// }else{
			// 	$sales_data = 0;
			// 	$sales_count = 0;
			// }
		}else{
			$user_id = 0;
			$sales_count = 0;
			$sales_data = 0;
		}


		$rData = MenuRecipes::where('id', '=', $id) 
			->with(array('MenuRecipesFacts' => function($query){
				$query->orderBy('menu_recipes_facts.ordering','ASC');
			}))
			->with(array('MenuRecipesIngredients' => function($query){
				$query->where('menu_recipes_ingredients.active', '=', 1)
					->with('MenuIngredients')
					->with('Metric');
			}))
			->with(array('MenuRecipesMethods' => function($query){
				$query->orderBy('menu_recipes_methods.ordering','ASC');
			}))
			->with(array('MenuRecipesExtras' => function($query){
				$query->orderBy('menu_recipes_extras.ordering','ASC');
			}))
			->with(array('Images' => function($query){
				$query->orderBy('images.ordering','DESC')->where('section', '=', 'RECIPE');
			}))
			->with(array('User' => function($query) use ($user_id){
				// echo '<pre>'; print_r($user_id); echo '</pre>';exit;
				$query->where('paid.user_id', '=', $user_id)->where('paid.type', '=', 'RECIPE');
			}))
		->orderBy(DB::raw('RAND()'))->where('fedup_active', '=', 1)->take(1)->get();

		
		$count = count($rData);
		$intolerance = array();
			 
		foreach ($rData as $recipe) {	
			$ecount = count($recipe->MenuRecipesExtras);

			// echo '<pre>'; print_r($ecount); echo '</pre>';exit;

			$count = count($recipe->menuRecipesIngredients);
			if($count > 0){
				foreach ($recipe->menuRecipesIngredients as $rIngredient) {
					$mCount = count($rIngredient->metric);
					$iCount = count($rIngredient->MenuIngredients);
					if(($mCount > 0 ) && ($iCount > 0)){
						$rnIngredient[] = $rIngredient;
					}else{
						$rnIngredient[] = '';
					}
				}
			}

			$count = count($recipe->Images);
			if($count > 0){
				$i = 0;
				foreach($recipe->Images as $image){
				        if(file_exists('uploads/'.$image->name)){
				            $recipe_image[$i][$recipe->id] = $image->name;
				            if($i == $count-1){ $header_image = $image->name;}
				        }else{
				           	$recipe_image[$i][$recipe->id] = 'recipe.png';
				           	if($i == $count-1){ $header_image = 'recipe.png';} 
				        }
				    $i++;
				}
			}else{
				$recipe_image[0][$recipe->id] = 'recipe.png';
				$header_image = 'recipe.png';
			}
			switch (true) {
			    case ($recipe->savoury == 1) :
			        $selection = "savoury";
			        $selection_title = "More Savoury Meals";
			    break;
			    case ($recipe->snack == 1) :
			        $selection = "snack";
			        $selection_title = "Other Quick Snacks";
			    break;
			    case ($recipe->dessert == 1) :
			        $selection = "dessert";
			        $selection_title = "Discover More Desserts";
			    break;
			    case ($recipe->refreshment == 1) :
			        $selection = "refreshment";
			        $selection_title = "Fill up on extra Refreshments";
			    break;
			    default :
			    	$selection = 0;
			}

			// $intolerance = $arrayName = array('' => , );
			
		    if ($recipe->df == 1){$intolerance[] = 'DF';};
		    if ($recipe->ds == 1){$intolerance[] = 'DS';};
		    if ($recipe->ef == 1){$intolerance[] = 'EF';};
		    if ($recipe->fi == 1){$intolerance[] = 'FI';};
		    if ($recipe->gf == 1){$intolerance[] = 'GF';};
		    if ($recipe->nf == 1){$intolerance[] = 'NF';};

		    if ($recipe->sf == 1){$intolerance[] = 'RSF';};
		    if ($recipe->v == 1){$intolerance[] = 'V';};
		    if ($recipe->ve == 1){$intolerance[] = 'VE';};
		}
		
		$icount = count($intolerance);
		if($icount == 0){
			// $intolerance = array();
			$intolerance[] = 'NA';
			// echo '<pre>p'; print_r($icount); echo '</pre>';exit;
		}

		// echo '<pre>q'; print_r($intolerance); echo '</pre>';exit;
		if($selection != 0){
			$sData = MenuRecipes::where($selection, '=', 1)
			->with(array('Images' => function($query){
					$query->orderBy('images.ordering','DESC')->where('section', '=', 'RECIPE');
				}))
			->orderBy(DB::raw('RAND()'))->where('fedup_active', '=', 1)->take(6)->get();

			foreach ($sData as $sRecipe) {
				$count = count($sRecipe->Images);
				if($count < 1){
					$sRecipe_image[$sRecipe->id] = 'recipe.png';
				}else{
					foreach($sRecipe->Images as $image){
				        if(file_exists('uploads/'.$image->name)){
				            $sRecipe_image[$sRecipe->id] = $image->name;
				        }else{
				           	$sRecipe_image[$sRecipe->id] = 'recipe.png';
				        }
					}
				}
			}
		}else{
			$selection_title = 0;
			$sData = 0;
			$sRecipe_image = 0;
		}
		// echo '<pre>'; print_r($sales_data); echo '</pre>';exit;

		
		return View::make('public.recipe_page')->with(array(
			'rData' => $rData,
			'hImage' => $header_image,
			'sData' => $sData,
			'rImage' => $recipe_image,
			'sRecipe_image' => $sRecipe_image,
			'rIngredients' => $rnIngredient,
			'sales_data' => $sales_data,
			'sales_count' => $sales_count,
			'selection_title' => $selection_title,
			'intolerance' => $intolerance,
			'iCount' => $iCount,
			'ecount' => $ecount,
			)
		);
	}
}
