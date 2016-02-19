<?php

class Admin_QuickController extends BaseController{

	public function getQuick(){
		$ingredients = MenuIngredients::orderBy('name','ASC')->where('active', '!=', '9')->where('project_active', '=', '1')->get();
		$active_count = 0;
		$count = count($ingredients);
		if($count >= 1){
			$active_count = 1;	
		}
		// echo '<pre>'; print_r($active_count); echo '</pre>'; exit;

		return View::make('admin.quick.index')
			->with(array(
				'data' => $ingredients,
				'start' => $active_count,
			));
	}
	
	public function getAddQuick(){
		$categories = MenuCategories::orderBy('name','ASC')->where('active', '!=', '9')->get(); // Bring in data that has not been deleted
		$ingredients = MenuIngredients::orderBy('name','ASC')->where('active', '!=', '9')->get();
		$metrics = Metric::orderBy('name','ASC')->get();
		
		$bIng = array();
		$bIng[0]	= '- Select Base Ingredients -';
		foreach ($ingredients as $base) {
			$bIng[$base->id]	= $base->name;
		};
		
		$mIng = array();
		$mIng[0]	= '- Select Ingredients -';
		foreach ($ingredients as $ingredient) {
			$mIng[$ingredient->id]	= $ingredient->name;
		};
		
		$mMetric = array();
		$mMetric[0]	= '- Select Metric -';
		foreach ($metrics as $metric) {
			$mMetric[$metric->id]	= $metric->name;
		};
		
		return View::make('admin.quick.form')
			->with(array(
				'base'	=> $bIng,
				'ingredients'	=> $mIng,
				'metric'	=> $mMetric,
				'title'		=> 'Get Fed Up',
				'calculated' => 0,
			));	
	}
	
	public function postAddQuick(){
		
		//echo '<pre>'; print_r($_POST); echo '</pre>'; exit;
		
		$input = Input::all();
		

		$rules = array(
			'ingredients_p' => 'required',
			'ingredients_b' => 'required',
			'ingredients_s' => 'required',
			'ingredients_t' => 'required',
		);
		$messages = array(
           'required' => 'Please ensure every tab has atleast 1 ingredient',
        );
		$validator = Validator::make($input, $rules, $messages);
		
		if($validator->fails()){
			return Redirect::back()
				->withErrors($validator)
				->withInput($input);
		}else{
			

			if(isset($input['ingredients_p']) && isset($input['amount_p']) && isset($input['metric_p'])){
					
				
				
				$ingredient = $input['ingredients_p'];
				$amount = $input['amount_p'];
				$i_sales_amount = $input['ri_sales_amount_p'];
				$metric = $input['metric_p'];
				$grams = $input['grams_p'];

				// echo '<pre>'; print_r($metric); echo '</pre>'; exit;

				if(isset($input['ip_grams'])){$ip_grams = $input['ip_grams'];}else{$ip_grams = 0;};
				if(isset($input['ip_price'])){$ip_price = $input['ip_price'];}else{$ip_price = 0;}

				$tip_cost = 0;
				$tip_grams = 0;


				$array_count = count($ingredient);
				for($i=0; $i<$array_count; $i++){
				  
					$xx = array_keys($ingredient[$i]);
					$input_ingredient_id = $ingredient[$i][$xx[0]];
					$input_metric_id = $metric[$i][$xx[0]];
					$input_i_sales_amount = $i_sales_amount[$i][$xx[0]];
					$riGrams = $grams[$i][$xx[0]];

					$imData = MenuIngredients::where('id', '=', $input_ingredient_id)
						->with(array('Metric' => function($query) use ($input_ingredient_id){
							$query->where('ingredient_metric.menu_ingredients_id', '=', $input_ingredient_id);
						}))	
					->first();

					if(!empty($imData->Metric)){
						// echo '<pre>'; print_r($imData); echo '</pre>';exit;
						foreach ($imData->Metric as $pivot_data) { //Ingredient Metric Data
							// echo '<pre>'; print_r($data); echo '</pre>';exit;
							if($pivot_data->id == $input_metric_id){
								$piGrams = $pivot_data->pivot->metric_grams * $input_i_sales_amount;                            //Recipe Ingredient Grams
								// echo '<pre>'; print_r($riGrams); echo '</pre>';
							}else{
								$piGrams = 0;
							}
						}
					}

					if($xx[0] == 'x'){
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_protein = 1;
						$r_i->project_base = 0;
						$r_i->project_side = 0;
						$r_i->project_topping = 0;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $piGrams;
						$r_i->project_amount = $input_i_sales_amount;
						$r_i->project_active = 1;
					}else{
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_protein = 1;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $piGrams;
						$r_i->project_amount = $input_i_sales_amount;
						$r_i->project_active = 1;
					}						


				   	

				  	$r_i->save();
			  		// echo '<pre>'; print_r($r_i); echo '</pre>';exit;
				};

				// echo '<pre>'; print_r($ti_grams); echo '</pre>';exit;
				
				if(isset($input['ddp'])){
					$ddi = $input['ddp'];

					
					foreach($ddi as $_delete){
						
						$di = MenuIngredients::find($_delete);
						//$di->active = 9;
						//$di->save();
						$di->delete();
					};
				};		
			};

			if(isset($input['ingredients_b']) && isset($input['amount_b']) && isset($input['metric_b'])){
					
				
				
				$ingredient = $input['ingredients_b'];
				$amount = $input['amount_b'];
				$i_sales_amount = $input['ri_sales_amount_b'];
				$metric = $input['metric_b'];
				$grams = $input['grams_b'];

				

				if(isset($input['ib_grams'])){$ib_grams = $input['ib_grams'];}else{$ib_grams = 0;};
				if(isset($input['ib_price'])){$ib_price = $input['ib_price'];}else{$ib_price = 0;}

				$tib_cost = 0;
				$tib_grams = 0;


				$array_count = count($ingredient);
				for($i=0; $i<$array_count; $i++){
				  
					$xx = array_keys($ingredient[$i]);
					$input_ingredient_id = $ingredient[$i][$xx[0]];
					$input_metric_id = $metric[$i][$xx[0]];
					$input_i_sales_amount = $i_sales_amount[$i][$xx[0]];
					$riGrams = $grams[$i][$xx[0]];

					$imData = MenuIngredients::where('id', '=', $input_ingredient_id)
						->with(array('Metric' => function($query) use ($input_ingredient_id){
							$query->where('ingredient_metric.menu_ingredients_id', '=', $input_ingredient_id);
						}))	
					->first();

					// echo '<pre>'; print_r($imData); echo '</pre>'; exit;

					if(!empty($imData->Metric)){
						// echo '<pre>'; print_r($imData); echo '</pre>';exit;
						foreach ($imData->Metric as $pivot_data) { //Ingredient Metric Data
							// echo '<pre>'; print_r($data); echo '</pre>';exit;
							if($pivot_data->id == $input_metric_id){
								$biGrams = $pivot_data->pivot->metric_grams * $input_i_sales_amount;                            //Recipe Ingredient Grams
								// echo '<pre>'; print_r($riGrams); echo '</pre>';
							}else{
								$biGrams = 0;
							}
						}
					}

					if($xx[0] == 'x'){
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_protein = 0;
						$r_i->project_base = 1;
						$r_i->project_side = 0;
						$r_i->project_topping = 0;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $biGrams;
						$r_i->project_amount = $input_i_sales_amount;
						$r_i->project_active = 1;
					}else{
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_base = 1;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $biGrams;
						$r_i->project_amount = $input_i_sales_amount;
						$r_i->project_active = 1;
					}						


				   	

				  	$r_i->save();
			  		
				};

				// echo '<pre>'; print_r($ti_grams); echo '</pre>';exit;
				if(isset($input['ddb'])){
					$ddi = $input['ddb'];

					
					foreach($ddi as $_delete){
						
						$di = MenuIngredients::find($_delete);
						//$di->active = 9;
						//$di->save();
						$di->delete();
					};
				};		
			};

			if(isset($input['ingredients_s']) && isset($input['amount_s']) && isset($input['metric_s'])){
				$ingredient = $input['ingredients_s'];
				$amount = $input['amount_s'];
				$i_sales_amount = $input['ri_sales_amount_s'];
				$metric = $input['metric_s'];
				$grams = $input['grams_s'];			

				if(isset($input['is_grams'])){$is_grams = $input['is_grams'];}else{$is_grams = 0;};
				if(isset($input['is_price'])){$is_price = $input['is_price'];}else{$is_price = 0;}

				$tsb_cost = 0;
				$tsb_grams = 0;

				$array_count = count($ingredient);
				for($i=0; $i<$array_count; $i++){
					$xx = array_keys($ingredient[$i]);
					$input_ingredient_id = $ingredient[$i][$xx[0]];
					$input_metric_id = $metric[$i][$xx[0]];
					$input_i_sales_amount = $i_sales_amount[$i][$xx[0]];
					$riGrams = $grams[$i][$xx[0]];

					$imData = MenuIngredients::where('id', '=', $input_ingredient_id)
						->with(array('Metric' => function($query) use ($input_ingredient_id){
							$query->where('ingredient_metric.menu_ingredients_id', '=', $input_ingredient_id);
						}))	
					->first();

					if(!empty($imData->Metric)){
						// echo '<pre>'; print_r($imData); echo '</pre>';exit;
						foreach ($imData->Metric as $pivot_data) { //Ingredient Metric Data
							// echo '<pre>'; print_r($data); echo '</pre>';exit;
							if($pivot_data->id == $input_metric_id){
								$siGrams = $pivot_data->pivot->metric_grams * $input_i_sales_amount;                            //Recipe Ingredient Grams
								// echo '<pre>'; print_r($riGrams); echo '</pre>';
							}else{
								$siGrams = 0;
							}
						}
					}

					if($xx[0] == 'x'){
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_protein = 0;
						$r_i->project_base = 0;
						$r_i->project_side = 1;
						$r_i->project_topping = 0;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $siGrams;
						$r_i->project_amount = $input_i_sales_amount;
						$r_i->project_active = 1;
					}else{
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_side = 1;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $siGrams;
						$r_i->project_amount = $input_i_sales_amount;
						$r_i->project_active = 1;
					}						

				   	// echo '<pre>'; print_r($r_i); echo '</pre>'; exit;

				  	$r_i->save();
			  		// echo '<pre>'; print_r($r_i); echo '</pre>'; exit;
				};

				// echo '<pre>'; print_r($ti_grams); echo '</pre>';exit;
				if(isset($input['dds'])){
					$ddi = $input['dds'];

					
					foreach($ddi as $_delete){
						
						$di = MenuIngredients::find($_delete);
						//$di->active = 9;
						//$di->save();
						$di->delete();
					};
				};		
			};

			if(isset($input['ingredients_t']) && isset($input['amount_t']) && isset($input['metric_t'])){
				$ingredient = $input['ingredients_t'];
				$amount = $input['amount_t'];
				$i_sales_amount = $input['ri_sales_amount_t'];
				$metric = $input['metric_t'];
				$grams = $input['grams_t'];			

				if(isset($input['ts_grams'])){$ts_grams = $input['ts_grams'];}else{$ts_grams = 0;};
				if(isset($input['ts_price'])){$ts_price = $input['ts_price'];}else{$ts_price = 0;}

				$tsb_cost = 0;
				$tsb_grams = 0;

				$array_count = count($ingredient);
				for($i=0; $i<$array_count; $i++){
					$xx = array_keys($ingredient[$i]);
					$input_ingredient_id = $ingredient[$i][$xx[0]];
					$input_metric_id = $metric[$i][$xx[0]];
					$input_i_sales_amount = $i_sales_amount[$i][$xx[0]];
					$riGrams = $grams[$i][$xx[0]];

					$imData = MenuIngredients::where('id', '=', $input_ingredient_id)
						->with(array('Metric' => function($query) use ($input_ingredient_id){
							$query->where('ingredient_metric.menu_ingredients_id', '=', $input_ingredient_id);
						}))	
					->first();

					if(!empty($imData->Metric)){
						// echo '<pre>'; print_r($imData); echo '</pre>';exit;
						foreach ($imData->Metric as $pivot_data) { //Ingredient Metric Data
							// echo '<pre>'; print_r($data); echo '</pre>';exit;
							if($pivot_data->id == $input_metric_id){
								$tiGrams = $pivot_data->pivot->metric_grams * $input_i_sales_amount;                            //Recipe Ingredient Grams
								// echo '<pre>'; print_r($riGrams); echo '</pre>';
							}else{
								$tiGrams = 0;
							}
						}
					}

					if($xx[0] == 'x'){
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_protein = 0;
						$r_i->project_base = 0;
						$r_i->project_side = 0;
						$r_i->project_topping = 1;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $tiGrams;
						$r_i->project_amount = $input_i_sales_amount;
						$r_i->project_active = 1;
					}else{
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_topping = 1;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $tiGrams;
						$r_i->project_amount = $input_i_sales_amount;
						$r_i->project_active = 1;
					}						

				   	// echo '<pre>'; print_r($r_i); echo '</pre>'; exit;

				  	$r_i->save();
			  		
				};

				// echo '<pre>'; print_r($ti_grams); echo '</pre>';exit;
				if(isset($input['ddt'])){
					$ddi = $input['ddt'];

					
					foreach($ddi as $_delete){
						
						$di = MenuIngredients::find($_delete);
						//$di->active = 9;
						//$di->save();
						$di->delete();
					};
				};		
			};





			


			
		}

		// echo '<pre>'; print_r($input['sdata_id']); echo '</pre>'; exit;

		

		// if(empty($input['sdata_id'])){
		// 	// echo 'YES!!!'; 	exit;
		// 	$_sales = new SalesData();
		// 	$_sales->menu_recipe_id = $data->id;
		// 	$data->SalesData()->save($_sales);
		// }
		

		if(isset($input['sc'])){
			return Redirect::action('Admin_QuickController@getQuick');
		}else{
			return Redirect::action('Admin_QuickController@getEditQuick', array($data->id)); 
		}
	}
	
	public function getEditQuick(){
		$ingredients = MenuIngredients::orderBy('name','ASC')->where('active', '!=', '9')->get();
		$metrics = Metric::orderBy('name','ASC')->get();
		// $sales_data = SalesData::where('menu_recipe_id', '=', $data->id)->get();
		// $sales_data_ingredients = SalesDataIngredients::where('menu_recipe_id', '=', $data->id)->get();

		//put ingredients into an array oof each stage, then pull it into the view

		$json_array = array();
		$mIng = array();
		$mIng[0]	= '- Select Ingredients -';	
		foreach ($ingredients as $ingredient) {

			// echo '<pre>'; print_r( $ingredient ); echo '</pre>'; 
			$mIng[$ingredient->id]	= $ingredient->name;
			foreach ($recipes_ingredients as $ri) {
				if($ri->menu_ingredients_id == $ingredient->id){
					$json_array[$ingredient->id] = array('grams' => $ingredient->grams, 'price' => $ingredient->price);
				}
			}
		
		};
		// echo '<pre>'; print_r( $sales_data ); echo '</pre>'; 
		// exit;

		$out = array_values($json_array);
		$json_calc = json_encode($json_array);
		
		$mMetric = array();
		$mMetric[0]	= '- Select Metric -';
		foreach ($metrics as $metric) {
			$mMetric[$metric->id]	= $metric->name;
		};
		
		// $sales_data_ingredients = array();
		$s_ingredients = $ingredients;
		

		// echo '<pre>'; print_r( $recipes_ingredients ); echo '</pre>'; 
		// exit;

		// foreach($sales_data as $i => $in){
		// 	echo '<pre>'; print_r( $i); echo '</pre>'; 
		// 	echo '<pre>'; print_r( $in ); echo '</pre>'; 
		// // 	echo '<br/';
		// }
		// exit;

		//$data from the load function above holds all the data for facts to go into the form
		// $calculated = 0;

		return View::make('admin.recipes.form')
			->with(array(
				'categories' => $mCat,
				'ingredients' => $mIng,
				// 'r_sales' => $sales_data,
				'json_calc' => $json_calc,
				'json_array' => $json_array,
				's_ingredients' => $s_ingredients,
				// 'sales_data_ingredients' => $sales_data_ingredients,
				'title'		=> 'Edit Fed Up Projects:'.$data->name,
				'calculated' => 0,
			));	
		
	}
	
	public function postUpdateRecipes(){
		$input = Input::all();
		
		// if(isset($input['sc'])){
		// 	echo '<pre> First exit to check for input '; print_r($input['sc']); echo '</pre>'; 	exit;
		// 	// echo '<pre> First exit to check for input '; print_r('Hi'); echo '</pre>'; 	exit;
		// }
		// echo '<pre> First exit to check for input '; print_r('bye'); echo '</pre>'; 	exit;

		$rules = array(
			'title' => 'required|Max:30|unique:menu_recipes,name,'.Input::get('id'),
			'summary' => 'required',
			'length' => 'required',
			
			'serve' => 'required',
			'categories' => 'required|not_in:0'
		);
		$validator = Validator::make($input, $rules);

		if($validator->fails()){
			return Redirect::back()
				->withErrors($validator)
				->withInput($input);
		}else{
			//die('Hi');
			// echo '<pre>'; print_r($input); echo '</pre>'; 	exit;
			
			$data = MenuRecipes::findOrFail($input['id']);
			$recipe_id = $input['id'];
			$data->name 	= $input['title'];
			$data->summary 	= $input['summary'];
			$data->menu_categories_id 	= $input['categories'];
			$data->fedup_active = (isset($input['fedup_active'])) ? 1 : 0;
			$data->exclusive  = (isset($input['exclusive'])) ? 1 : 0;
			$data->catering  = (isset($input['catering'])) ? 1 : 0;
			$data->length 	= $input['length'];
			$data->difficulty 	= $input['difficulty'];
			$data->serve = $serve_amount = $input['serve'];
			$data->menu_type 	= $input['menu_type'];
			$data->df  = (isset($input['DF'])) ? 1 : 0;
			$data->ds  = (isset($input['DS'])) ? 1 : 0;
			$data->ef  = (isset($input['EF'])) ? 1 : 0;
			$data->fi  = (isset($input['FI'])) ? 1 : 0;
			$data->gf  = (isset($input['GF'])) ? 1 : 0;
			$data->nf  = (isset($input['NF'])) ? 1 : 0;
			$data->sf  = (isset($input['SF'])) ? 1 : 0;
			$data->ve  = (isset($input['VE'])) ? 1 : 0;
			$data->v  = (isset($input['V'])) ? 1 : 0;
			if($data->save()){
				if(isset($input['images'])){
					$image_reset = $input['images'];
					$image_des_reset = $input['img_des'];

					if(isset($input['ddp'])){
						$ddp = $input['ddp'];
						foreach($ddp as $dp_delete){
							foreach($image_reset as $i_image=>$image){
								foreach($image as $i_photo=>$photo){
									if ($dp_delete == $i_photo) {
										unset($image_reset[$i_image]);
										unset($image_des_reset[$i_image]);	
									}
								}
							}
							$dp = Images::find($dp_delete);
							$dp->delete();	
								$image_reset = array_values($image_reset);
								$image_des_reset = array_values($image_des_reset);
						}

					}

					$p_count = count($image_reset);
					$p=0;
					
					foreach($image_reset as $image){
						if($p <= $p_count){
							foreach($image as $i_photo=>$photo){
								if($i_photo == 'x'){
									$_image = new Images();
									$_image->name = $photo;
									$_image->summary = $image_des_reset[$p]['x'];
									$_image->link_id = $input['id'];
									$_image->section = 'RECIPE';
									$_image->ordering = $p;
									$_image->active = 1;
									
								}else{
									$_image = Images::find($i_photo);
									$_image->name = $photo;
									$_image->summary = $image_des_reset[$p][$i_photo];
									$_image->link_id = $input['id'];
									$_image->section = 'RECIPE';
									$_image->ordering = $p;
									$_image->active = 1;
								};
								$data->Images()->save($_image);
							};
						$p++;
						}
					};
				};

				if(isset($input['fact'])){
					//echo '<pre>'; print_r($input['fact']); echo '</pre>'; 	exit;
					$f_count = count($input['fact']);
					$fc = 1;
					foreach($input['fact'] as $fact){
						if($fc <= $f_count){
							//We need the index = $i and $f is the value
							foreach($fact as $i=>$f){
								if ($i == 'x'){
									$_fact = new MenuRecipesFacts();
									$_fact->description = $f;
									$_fact->ordering = $fc;
									$_fact->active = 1;
									// echo '<pre>'; print_r($_fact); echo '</pre>'; 	exit;
								}else {
									$_fact = MenuRecipesFacts::find($i);
									$_fact->description = $f;
									$_fact->ordering = $fc;
								};
								$data->MenuRecipesFacts()->save($_fact);
							};
						$fc++;
						};
					};
					if(isset($input['ddf'])){
						$ddf = $input['ddf'];
						//echo '<pre>'; print_r($ddf); echo '</pre>'; 	exit;
						
						foreach($ddf as $df_delete){
						
							$df = MenuRecipesFacts::find($df_delete);
							$df->delete();
						};
					};
											 
				};

				if(empty($input['sdata_id'])){
					if(!isset($input['sdata_id'])){
						// echo 'YES!!!'; 	exit;
						$_sales = new SalesData();
						$_sales->menu_recipe_id = $input['id'];
						$data->SalesData()->save($_sales);
					}
				}
				
				// echo 'No!'; 	exit;

				if(isset($input['ingredients']) && isset($input['amount']) && isset($input['metric'])){
					
					
					
					$ingredient = $input['ingredients'];
					$amount = $input['amount'];
					$ri_sales_amount = $input['ri_sales_amount'];
					$metric = $input['metric'];
					$grams = $input['grams'];

					if(isset($input['i_grams'])){$i_grams = $input['i_grams'];}else{$i_grams = 0;};
					if(isset($input['i_price'])){$i_price = $input['i_price'];}else{$i_price = 0;}

					$ti_cost = 0;
					$ti_grams = 0;


					$array_count = count($ingredient);
					for($i=0; $i<$array_count; $i++){
					  
						$xx = array_keys($ingredient[$i]);
						$input_ingredient_id = $ingredient[$i][$xx[0]];
						$input_metric_id = $metric[$i][$xx[0]];
						$input_ri_sales_amount = $ri_sales_amount[$i][$xx[0]];
						$riGrams = $grams[$i][$xx[0]];



						$imData = MenuIngredients::where('id', '=', $input_ingredient_id)
							->with(array('Metric' => function($query) use ($input_ingredient_id){
								$query->where('ingredient_metric.menu_ingredients_id', '=', $input_ingredient_id);
							}))	
						->first();

						// $imData = MenuIngredients::with('Metric')->get();

						// echo '<pre>'; print_r($imData); echo '</pre>';exit;
						
						// if(!empty($grams[$i][$xx[0]])){
						// 	$riGrams = $grams[$i][$xx[0]];
						// }else{
							
							if(!empty($imData->Metric)){
								// echo '<pre>'; print_r($imData); echo '</pre>';exit;
								foreach ($imData->Metric as $pivot_data) { //Ingredient Metric Data
									// echo '<pre>'; print_r($data); echo '</pre>';exit;
									if($pivot_data->id == $input_metric_id){
										$riGrams = $pivot_data->pivot->metric_grams * $input_ri_sales_amount;                            //Recipe Ingredient Grams
										// echo '<pre>'; print_r($riGrams); echo '</pre>';
									}
								}
							}
							
						// }

						if($xx[0] == 'x'){
							$r_i = new MenuRecipesIngredients();
							$r_i->menu_ingredients_id = $input_ingredient_id;
							$r_i->amount = $amount[$i][$xx[0]];
							$r_i->ri_sales_amount = $ri_sales_amount[$i][$xx[0]];
							$r_i->metric_id = $input_metric_id;
							$r_i->grams = $riGrams;
							$r_i->ordering = $i;
							$r_i->active = 1;  
						}else{
							$r_i = MenuRecipesIngredients::find($xx[0]);
							$r_i->menu_ingredients_id = $input_ingredient_id;
							$r_i->amount = $amount[$i][$xx[0]];
							$r_i->ri_sales_amount = $ri_sales_amount[$i][$xx[0]];
							$r_i->metric_id = $input_metric_id;
							$r_i->grams = $riGrams;

							if(isset($input['sales_amount'])){
								$sales_amount = $input['sales_amount'];
								$r_i->sales_grams = $sales_grams = $riGrams/$serve_amount * $sales_amount; 
								
								// 

								foreach($i_grams as $id => $i_gram){
								  	if($ingredient[$i][$xx[0]] == $id){
								  		// if(isset($input['calc'])){

								  			if($i_gram > 0){
									  			$packet_grams_percentage = $sales_grams / $i_gram * 100; 
												$r_i->packet_grams_percentage = $packet_grams_percentage;
											}

											$ti_grams = $ti_grams + $sales_grams;
									  		
								  		// }
								  	}
								}
							}

							if(isset($input['sales_price'])){
								foreach($i_price as $id => $ri_price){
								  	if($ingredient[$i][$xx[0]] == $id){
								  		if(isset($packet_grams_percentage)){
									  		$recipe_ingredient_cost = $packet_grams_percentage/100 * $ri_price;
									  		$r_i->recipe_ingredient_cost = $recipe_ingredient_cost;
									  		$ti_cost = $ti_cost + $recipe_ingredient_cost;
								  		}
								  	}
								}
							}
							$r_i->ordering = $i;						
					    };
					   // echo '<pre>'; print_r($data); echo '</pre>';exit;

					   	

					  	$data->MenuRecipesIngredients()->save($r_i);
				  		
					};

					// echo '<pre>'; print_r($ti_grams); echo '</pre>';exit;

					if(isset($input['ddi'])){
						$ddi = $input['ddi'];
	
						
						foreach($ddi as $_delete){
							
							$di = MenuRecipesIngredients::find($_delete);
							//$di->active = 9;
							//$di->save();
							$di->delete();
						};
					};		
				};
				


				if(isset($input['method'])){
					$m_count = count($input['method']);
					$mc = 1;
					foreach($input['method'] as $method){
						if($mc <= $m_count){
							foreach($method as $i=>$m){
								if($i == 'x'){
									$_method = new MenuRecipesMethods();
									$_method->description = $m;
									$_method->ordering = $mc;
									$_method->active = 1;
								}else{
									$_method = MenuRecipesMethods::find($i);
									$_method->description = $m;
									$_method->ordering = $mc;
								}
								$data->MenuRecipesMethods()->save($_method);
							};
						$mc++;
						};
					};
					if(isset($input['ddm'])){
						$ddm = $input['ddm'];
						//echo '<pre>'; print_r($ddm); echo '</pre>'; 	exit;
						
						foreach($ddm as $dm_delete){
						
							$dm = MenuRecipesMethods::find($dm_delete);
							$dm->delete();
						};
					};					
				};
				
				if(isset($input['extra'])){
					$e_count = count($input['extra']);
					$ec = 1;
					foreach($input['extra'] as $_extra){
						if($ec <= $e_count){
							foreach($_extra as $i=>$ex){
								if($i == 'x'){
									$_extra = new MenuRecipesExtras();
									$_extra->description = $ex;
									$_extra->ordering = $ec;
									$_extra->active = 1;
								}else{
									$_extra = MenuRecipesExtras::find($i);
									$_extra->description = $ex;
									$_extra->ordering = $ec;
								}
								$data->MenuRecipesExtras()->save($_extra);
							};
						$ec++;
						};
					};
					if(isset($input['dde'])){
						$dde = $input['dde'];
						//echo '<pre>'; print_r($dde); echo '</pre>'; 	exit;
						
						foreach($dde as $de_delete){
						
							$de = MenuRecipesExtras::find($de_delete);
							$de->delete();
						};
					};						
				};
				
					// echo '<pre>'; print_r($input['sales_time']); echo '</pre>'; 	exit;

				

				if(isset($input['staff_cost_per_hour']) && isset($input['sales_price']) && isset($input['sales_amount']) && isset($input['sales_time']) && isset($input['sdata_id'])){

					// echo '<pre>'; print_r($input); echo '</pre>'; 	exit;

						if(isset($ti_cost)){$ti_cost = $ti_cost;}else{$ti_cost = 0;}
						if(isset($ti_grams)){$ti_grams = $ti_grams;}else{$ti_grams = 0;}
						if(isset($input['B2B_sales_price'])){$B2B_sales_price = $input['B2B_sales_price'];}else{$B2B_sales_price = 0;}
						

						$sdata_id = $input['sdata_id'];
						$staff_cost_per_hour = $input['staff_cost_per_hour'];
						$sales_price = $input['sales_price'];
						$sales_amount = $input['sales_amount'];
						$sales_time = $input['sales_time'];
						$desired_total_markup = $input['desired_total_markup'];

						$total_recipe_revenue = 0;
						$total_ingredient_cost_per_piece = 0;
						$total_cost_per_piece = 0;
						$total_cost_percentage = 0;
						$total_profit = 0;
						$staff_cost_percentage = 0;
						$total_profit_per_piece = 0;
						$ingredient_cost_percentage = 0;
						$total_markup_percentage = 0;
						$total_margin_percentage = 0;
						$desired_sales_price = 0;
						$staff_cost_per_piece = 0;
						$staff_cost_to_make_recipe_batch = 0;
						$total_grams_per_piece = 0;
						$B2B_total_recipe_revenue = 0;
						$B2B_desired_sales_price = 0;
						$B2B_desired_total_markup = 0;
						// $B2B_desired_total_markup

						

						$staff_cost_to_make_recipe_batch = $staff_cost_per_hour/60 * $sales_time;
						$total_recipe_cost = $staff_cost_to_make_recipe_batch + $ti_cost;

						if($sales_amount > 0){
							$total_recipe_revenue = $sales_amount * $sales_price;
							$staff_cost_per_piece = $staff_cost_to_make_recipe_batch/ $sales_amount;
							$total_cost_per_piece = $total_recipe_cost / $sales_amount;
							$total_ingredient_cost_per_piece = $ti_cost/  $sales_amount;
							$total_grams_per_piece = $ti_grams / $sales_amount;

							$total_cost_percentage = $total_recipe_cost/ $total_recipe_revenue * 100;
							$total_profit = $total_recipe_revenue - $total_recipe_cost;
							$staff_cost_percentage = $staff_cost_to_make_recipe_batch/ $total_recipe_revenue * 100;
							$ingredient_cost_percentage = $ti_cost/ $total_recipe_revenue * 100;


							// $total_markup_percentage = $total_recipe_revenue/ $total_profit * 100;

							$total_margin_percentage = $total_profit/ ($sales_amount * $sales_price) * 100;
							$decimal_margin = $total_margin_percentage/100;
							$total_markup_percentage = $decimal_margin/ (1 - $decimal_margin) * 100;
							$total_profit_per_piece = $total_profit/ $sales_amount;

							if($sales_amount >= 100){
								$B2B_total_recipe_revenue = $total_recipe_cost / 0.28566;
							}else{
								$B2B_total_recipe_revenue = $total_recipe_cost / 0.263151;
							}
							$B2B_desired_sales_price = $B2B_total_recipe_revenue/ $sales_amount;
							if($B2B_sales_price == 0){
								$B2B_sales_price = $B2B_desired_sales_price;
							}
							if($B2B_sales_price >= 0){
								$B2B_total_recipe_revenue = $B2B_sales_price * $sales_amount;
							}
							$B2B_pofit = $B2B_total_recipe_revenue - $total_recipe_cost;
							$B2B_desired_total_markup = $B2B_pofit/$total_recipe_cost *100;
							// echo '<pre>'; print_r($B2B_total_recipe_revenue); echo '</pre>'; 	exit;



							if($desired_total_markup == 0){
								$desired_total_markup = 350;
							}

							if($desired_total_markup > 0){

								$projected_total_markup_per_piece = $total_cost_per_piece * ($desired_total_markup / 100);
								// $projected_total_markup_per_piece = $projected_total_markup / $sales_amount;

								// echo '<pre>'; print_r($total_cost_per_piece); echo '</pre>';
								// echo '<pre>'; print_r($projected_total_markup); echo '</pre>'; 	exit;
								
								$projected_recipe_revenue = $projected_total_markup_per_piece + $total_cost_per_piece;

								$desired_sales_price = $projected_recipe_revenue;
								// echo '<pre>'; print_r($desired_sales_price); echo '</pre>'; 	exit;
							}
						}
						
						
						// 
						

						// $_sales = SalesData::find($sdata_id);	
						DB::table('sales_data')
			            ->where('id', $sdata_id)
			            ->update(array(
			            		'staff_cost_per_hour' => $staff_cost_per_hour,
			            		'staff_cost_per_piece' => $staff_cost_per_piece,
			            		'sales_price' => $sales_price,
			            		'sales_amount' => $sales_amount,
			            		'sales_time' => $sales_time,

			            		'total_recipe_grams' => $ti_grams,
			            		'total_grams_per_piece' => $total_grams_per_piece,

			            		'staff_cost_to_make_recipe_batch' => $staff_cost_to_make_recipe_batch,
			            		'total_recipe_cost' => $total_recipe_cost,
			            		'total_ingredient_cost' => $ti_cost,
			            		'total_recipe_revenue' => $total_recipe_revenue,

			            		'total_ingredient_cost_per_piece' => $total_ingredient_cost_per_piece,
			            		'total_cost_percentage' => $total_cost_percentage,
			            		'total_cost_per_piece' => $total_cost_per_piece,
			            		'total_profit' => $total_profit,

			            		'staff_cost_percentage' => $staff_cost_percentage,
			            		'total_profit_per_piece' => $total_profit_per_piece,
			            		'ingredient_cost_percentage' => $ingredient_cost_percentage,
			            		'total_markup_percentage' => $total_markup_percentage,
			            		'total_margin_percentage' => $total_margin_percentage,

			            		'desired_sales_price' => $desired_sales_price,
			            		'desired_total_markup' => $desired_total_markup,

			            		'B2B_total_recipe_revenue' => $B2B_total_recipe_revenue,
			            		'B2B_desired_sales_price' => $B2B_desired_sales_price,
			            		'B2B_sales_price' => $B2B_sales_price,
			            		'B2B_desired_total_markup' => $B2B_desired_total_markup,

			            	)
			            );
						
						// $data->SalesData()->save($_sales);


				}
			};
			//exit;	
			if(isset($input['sc'])){
				return Redirect::action('Admin_RecipesController@getRecipes');
			}else{

				$data = MenuRecipes::findOrFail($input['id']);
				$categories = MenuCategories::orderBy('name','ASC')->where('active', '!=', '9')->get(); // Bring in data that has not been deleted
				$ingredients = MenuIngredients::orderBy('name','ASC')->where('active', '!=', '9')->get();
				$metrics = Metric::orderBy('name','ASC')->get();
				$sales_data = SalesData::where('menu_recipe_id', '=', $data->id)->get();
				$recipes_images = $data->Images()->orderBy('ordering','ASC')->where('section', '=', 'RECIPE')->get();
				$recipes_facts = $data->MenuRecipesFacts()->orderBy('ordering','ASC')->get();
				$recipes_ingredients = $data->MenuRecipesIngredients()->orderBy('ordering','ASC')->get();
				$recipes_methods = $data->MenuRecipesMethods()->orderBy('ordering','ASC')->get();
				$recipes_extras = $data->MenuRecipesExtras()->orderBy('ordering','ASC')->get();
				
				$mCat = array();
				$mCat[0]	= '- Select Category -';
				foreach ($categories as $category) {
					$mCat[$category->id] = $category->name;
				};

				$json_array = array();
				$mIng = array();
				$mIng[0]	= '- Select Ingredients -';	
				foreach ($ingredients as $ingredient) {
					$mIng[$ingredient->id]	= $ingredient->name;
					foreach ($recipes_ingredients as $ri) {
						if($ri->menu_ingredients_id == $ingredient->id){
							$json_array[$ingredient->id] = array('grams' => $ingredient->grams, 'price' => $ingredient->price);
						}
					}
				};
				$out = array_values($json_array);
				$json_calc = json_encode($json_array);
				
				$mMetric = array();
				$mMetric[0]	= '- Select Metric -';
				foreach ($metrics as $metric) {
					$mMetric[$metric->id]	= $metric->name;
				};
				$s_ingredients = $ingredients;
				return View::make('admin.recipes.form')
					->with(array(
						'data' => $data,// This 
						'categories' => $mCat,
						'ingredients' => $mIng,
						'metric' => $mMetric,
						'r_images' => $recipes_images,
						'r_facts' => $recipes_facts,
						'r_ingredients' => $recipes_ingredients,
						'r_methods' => $recipes_methods,
						'r_extras' => $recipes_extras,
						'r_sales' => $sales_data,
						'json_calc' => $json_calc,
						'json_array' => $json_array,
						's_ingredients' => $s_ingredients,
						// 'sales_data_ingredients' => $sales_data_ingredients,
						'title'		=> 'Edit Recipe:'.$data->name,
						'calculated' => 1,
					));


				// return Redirect::action('Admin_RecipesController@getEditRecipes', array($recipe_id)); 
			}
		}
	}

	public function getAllRecipes(){
		$data = MenuRecipes::where('fedup_active','!=', 9)->orderBy('name','ASC')->get();
		return View::make('admin.allrecipes.index')
			->with(array(
				'data' => $data,
			));
	}

	public function getAllActiveRecipes($id){
		$data = MenuRecipes::findOrFail($id);
		$data->fedup_active = ($data->fedup_active == 0)? 1 : ($data->fedup_active == 9)? 1 : 0; //If it is == 0 thats true so change the value to 1, else if its false the value is 1 so change it to 0
		$data->save();
		return Redirect::action('Admin_RecipesController@getAllRecipes');
	}

	public function getMakeRecipesActive(){
		$data = MenuRecipes::where('fedup_active', '!=', 9)->get();
		// $data = MenuRecipes::findOrFail($id);
		foreach ($data as $recipe) {
			$recipe->fedup_active = 1; //If it is == 0 thats true so change the value to 1, else if its false the value is 1 so change it to 0
			$recipe->save();
		}
		
		return Redirect::action('Admin_RecipesController@getAllRecipes');
	}


	
	public function getActiveRecipes($id){
		$data = MenuRecipes::findOrFail($id);
		$data->fedup_active = ($data->fedup_active == 0)? 1 : 0; //If it is == 0 thats true so change the value to 1, else if its false the value is 1 so change it to 0
		$data->save();
		return Redirect::action('Admin_RecipesController@getRecipes');
	}
	
	public function getConfirmDeleteRecipes($id){
		$data = MenuRecipes::findOrFail($id);
		$data->fedup_active = 9;
		$data->save();
		return Redirect::action('Admin_RecipesController@getAllRecipes');
	}

	public function getDeleteRecipes($id){
		$data = MenuRecipes::findOrFail($id);
		$data->fedup_active = 9;
		$data->save();
		return Redirect::action('Admin_RecipesController@getRecipes');
	}

}


					  /*echo '<pre>$xx[0] ... we need the value of the first index => this will give us the ID <br><br><strong>'; 
					  print_r($xx[0]); echo '</strong></pre>';
					  echo '<pre>$ingredient[$i][$xx[0]] ... injecting it into here will produce<br><br>$ingredient[0][10]<br>yielding the VALUE<br><br><strong>'; 
					  print_r($ingredient[$i][$xx[0]]); echo '</strong></pre><br/>';
					  echo '<pre>'; print_r($amount[$i][$xx[0]]); echo '</strong></pre><br/>';
					  echo '<pre>'; print_r($metric[$i][$xx[0]]); echo '</strong></pre><br/>';
					  
					  echo '<hr/>';*/
					  
