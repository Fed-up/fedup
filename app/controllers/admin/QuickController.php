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
				'data_check' => 0,
			));	
	}
	
	public function postAddQuick(){
		
		//echo '<pre>'; print_r($_POST); echo '</pre>'; exit;
		
		$input = Input::all();
		

		$rules = array(
			'ingredients_p' => 'required',
			// 'ingredients_b' => 'required',
			// 'ingredients_s' => 'required',
			// 'ingredients_t' => 'required',
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
				$metric = $input['metric_p'];
				$grams = $input['grams_p'];
				$i_sales_grams = $input['i_sales_grams_p'];
				
				if(isset($input['ip_grams'])){$ip_grams = $input['ip_grams'];}else{$ip_grams = 0;};
				if(isset($input['ip_price'])){$ip_price = $input['ip_price'];}else{$ip_price = 0;}

				$tip_cost = 0;
				$tip_grams = 0;


				$array_count = count($ingredient);
				for($i=0; $i<$array_count; $i++){
				  
					$xx = array_keys($ingredient[$i]);
					$input_ingredient_id = $ingredient[$i][$xx[0]];
					$input_amount = $amount[$i][$xx[0]];
					$input_metric_id = $metric[$i][$xx[0]];
					$input_i_sales_grams = $i_sales_grams[$i][$xx[0]];
					$input_grams = $grams[$i][$xx[0]];

					// echo '<pre>'; print_r($input_amount); echo '</pre>'; exit;

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
								$piGrams = $pivot_data->pivot->metric_grams * $input_i_sales_grams;                            //Recipe Ingredient Grams
								// echo '<pre>'; print_r($piGrams); echo '</pre>';exit;
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
						$r_i->project_amount = $input_amount;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $input_grams;
						$r_i->project_sales_grams = $input_i_sales_grams;
						$r_i->project_active = 1;
					}else{
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_protein = 1;
						$r_i->project_amount = $input_amount;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $input_grams;
						$r_i->project_sales_grams = $input_i_sales_grams;
						$r_i->project_active = 1;
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

					
					foreach($dds as $_delete){
						
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
			return Redirect::action('Admin_QuickController@getEditQuick'); 
		}
	}
	
	public function getEditQuick(){
		$ingredients = MenuIngredients::orderBy('name','ASC')->where('active', '!=', '9')->get();
		$metrics = Metric::orderBy('name','ASC')->get();
		// $sales_data = SalesData::where('menu_recipe_id', '=', $data->id)->get();
		// $sales_data_ingredients = SalesDataIngredients::where('menu_recipe_id', '=', $data->id)->get();

		//put ingredients into an array oof each stage, then pull it into the view

		$mIng = array();
			$mIng[0]	= '- Select Ingredients -';
			$data_check = 0;
			foreach ($ingredients as $ingredient) {
				$mIng[$ingredient->id]	= $ingredient->name;
				if($ingredient->project_protein == 1){
					$data_check = 1;
				}
				if($ingredient->project_base == 1){
					$data_check = 1;
				}
				if($ingredient->project_side == 1){
					$data_check = 1;
				}
				if($ingredient->project_topping == 1){
					$data_check = 1;
				}
				// $mIng[] = array(
				// 	'name' => $ingredient->name, 
				// 	'project_amount' => $ingredient->project_amount, 
				// 	'project_metric_id' => $ingredient->project_metric_id, 
				// 	'project_grams' => $ingredient->project_grams,
				// 	'project_sales_grams' => $ingredient->project_sales_grams, 
				// 	'grams' => $ingredient->grams, 
				// 	'price' => $ingredient->price
				// );
			};
		// echo '<pre>'; print_r( $mIng ); echo '</pre>';exit;

		$p_array = array();
		$pIng = array();
		$pIng[0]	= '- Select Ingredients -';	
		foreach ($ingredients as $ingredient) {
			if($ingredient->project_protein == 1){
				$p_array[$ingredient->id] = array(
					'name' => $ingredient->name, 
					'project_amount' => $ingredient->project_amount, 
					'project_metric_id' => $ingredient->project_metric_id, 
					'project_grams' => $ingredient->project_grams,
					'project_sales_grams' => $ingredient->project_sales_grams, 
					'grams' => $ingredient->grams, 
					'price' => $ingredient->price
				);
			}		
		};
		$out = array_values($p_array);
		$json_p = json_encode($p_array);

		$b_array = array();
		$bIng = array();
		$bIng[0]	= '- Select Ingredients -';	
		foreach ($ingredients as $ingredient) {
			if($ingredient->project_base == 1){
				$b_array[$ingredient->id] = array(
					'name' => $ingredient->name, 
					'project_amount' => $ingredient->project_amount, 
					'project_metric_id' => $ingredient->project_metric_id, 
					'project_grams' => $ingredient->project_grams,
					'project_sales_grams' => $ingredient->project_sales_grams, 
					'grams' => $ingredient->grams, 
					'price' => $ingredient->price
				);
			}		
		};
		$out = array_values($b_array);
		$json_b = json_encode($b_array);

		$s_array = array();
		$sIng = array();
		$sIng[0]	= '- Select Ingredients -';	
		foreach ($ingredients as $ingredient) {
			if($ingredient->project_side == 1){
				$s_array[$ingredient->id] = array(
					'name' => $ingredient->name, 
					'project_amount' => $ingredient->project_amount, 
					'project_metric_id' => $ingredient->project_metric_id, 
					'project_grams' => $ingredient->project_grams,
					'project_sales_grams' => $ingredient->project_sales_grams, 
					'grams' => $ingredient->grams, 
					'price' => $ingredient->price
				);
			}		
		};
		$out = array_values($s_array);
		$json_s = json_encode($s_array);

		$t_array = array();
		$tIng = array();
		$tIng[0]	= '- Select Ingredients -';	
		foreach ($ingredients as $ingredient) {
			if($ingredient->project_topping == 1){
				$t_array[$ingredient->id] = array(
					'name' => $ingredient->name, 
					'project_amount' => $ingredient->project_amount, 
					'project_metric_id' => $ingredient->project_metric_id, 
					'project_grams' => $ingredient->project_grams,
					'project_sales_grams' => $ingredient->project_sales_grams, 
					'grams' => $ingredient->grams, 
					'price' => $ingredient->price
				);
			}		
		};
		$out = array_values($t_array);
		$json_t = json_encode($t_array);

		
		$mMetric = array();
		$mMetric[0]	= '- Select Metric -';
		foreach ($metrics as $metric) {
			$mMetric[$metric->id]	= $metric->name;
		};
		
		// $sales_data_ingredients = array();
		// $s_ingredients = $ingredients;
		

		

		// foreach($sales_data as $i => $in){
		// 	echo '<pre>'; print_r( $i); echo '</pre>'; 
		// 	echo '<pre>'; print_r( $in ); echo '</pre>'; 
		// // 	echo '<br/';
		// }
		// exit;

		//$data from the load function above holds all the data for facts to go into the form
		$calculated = 0;


		// <select name="ingredients[][{{ $p_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--ingredient"/>
	 //        @foreach($base as $i=>$v)
	 //        	<option value="{{ $i }}" @if ($b_ingredient->menu_ingredients_id == $i) selected="selected" @endif >{{ $v }}</option>
	 //        @endforeach
	 //    </select>

		// echo '<pre>'; print_r( $json_p ); echo '</pre>';

		// foreach ($p_array as $key => $p_ingredient) { 
		// 	echo '<pre>'; print_r( $p_ingredient ); echo '</pre>'; 

		
		// }
		// exit;



		return View::make('admin.quick.form')
			->with(array(
				'ingredients' => $mIng,
				'ingredients_p' => $pIng,
				'json_p' => $json_p,
				'p_array' => $p_array,

				'ingredients_b' => $bIng,
				'json_b' => $json_b,
				'b_array' => $b_array,

				'ingredients_s' => $sIng,
				'json_s' => $json_s,
				's_array' => $s_array,

				'ingredients_t' => $tIng,
				'json_t' => $json_t,
				't_array' => $t_array,

				'metric' => $mMetric,
				'data_check' => $data_check,
				// 'sales_data_ingredients' => $sales_data_ingredients,
				'title'		=> 'Edit Fed Up Projects:',
				'calculated' => 0,
			));	
		
	}
	
	public function postUpdateQuick(){
		//echo '<pre>'; print_r($_POST); echo '</pre>'; exit;		
		$input = Input::all();	
		$rules = array(
			// 'ingredients_p' => 'required',
			// 'ingredients_b' => 'required',
			// 'ingredients_s' => 'required',
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
				$metric = $input['metric_p'];
				$grams = $input['grams_p'];
				$i_sales_grams = $input['i_sales_grams_p'];				
				if(isset($input['ip_grams'])){$ip_grams = $input['ip_grams'];}else{$ip_grams = 0;};
				if(isset($input['ip_price'])){$ip_price = $input['ip_price'];}else{$ip_price = 0;}
				$tip_cost = 0;
				$tip_grams = 0;








				$array_count = count($ingredient);
				for($i=0; $i<$array_count; $i++){			  
					$xx = array_keys($ingredient[$i]);
					$vv = array_values($ingredient[$i]);
					$input_ingredient_id = $ingredient[$i][$xx[0]];

					
					
					$input_amount = $amount[$i][$xx[0]];
					$input_metric_id = $metric[$i][$xx[0]];
					$input_i_sales_grams = $i_sales_grams[$i][$xx[0]];
					$input_grams = $grams[$i][$xx[0]];
					// echo '<pre>'; print_r($input_grams); echo '</pre>'; exit;
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
								$input_i_sales_grams = $pivot_data->pivot->metric_grams * $input_grams; 
							}else{
								$piGrams = 0;
							}
						}
					}
					// echo '<pre>'; print_r($vv[0]); echo '</pre>'; exit;
					// exit;
					if($xx[0] == 'x'){
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_protein = 1;
						$r_i->project_base = 0;
						$r_i->project_side = 0;
						$r_i->project_topping = 0;
						$r_i->project_amount = $input_amount;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $input_grams;
						$r_i->project_sales_grams = $input_i_sales_grams;
						$r_i->project_active = 1;

					}else{
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_protein = 1;
						$r_i->project_amount = $input_amount;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $input_grams;
						$r_i->project_sales_grams = $input_i_sales_grams;
						$r_i->project_active = 1;
						
					}
					// echo '<pre>'; print_r($vv[0]); echo '</pre>';
					// // echo '<pre>'; print_r($xx[]); echo '</pre>';
					// echo '<pre>'; print_r($input_ingredient_id); echo '</pre>';
					// echo '<pre>'; print_r($xx[0]); echo '</pre>';


					if ($xx[0] != $input_ingredient_id){
						$d_i = MenuIngredients::find($xx[0]);
						$d_i->project_protein = 0;
						$d_i->project_amount = 0;
						$d_i->project_metric_id = 0;
						$d_i->project_grams = 0;
						$d_i->project_sales_grams = 0;
						$d_i->project_active = 0;
						$d_i->save();
					}

				  	$r_i->save();
			  		
				};
				// exit;
				if(isset($input['ddp'])){
					$ddp = $input['ddp'];
					// echo '<pre>'; print_r($input); echo '</pre>';exit;			
					foreach($ddp as $_delete){					
						$di = MenuIngredients::find($_delete);
						$di->project_active = 0;
						$di->project_protein = 0;
						$di->save();
						// $di->delete();
					};
				};		
			};
			
			// echo '<pre>'; print_r($input); echo '</pre>';exit;	

			if(isset($input['ingredients_b']) && isset($input['amount_b']) && isset($input['metric_b'])){
				$ingredient = $input['ingredients_b'];
				$amount = $input['amount_b'];
				$metric = $input['metric_b'];
				$grams = $input['grams_b'];
				$i_sales_grams = $input['i_sales_grams_b'];			
				if(isset($input['ib_grams'])){$ib_grams = $input['ib_grams'];}else{$ib_grams = 0;};
				if(isset($input['ib_price'])){$ib_price = $input['ib_price'];}else{$ib_price = 0;}
				$tib_cost = 0;
				$tib_grams = 0;
				$array_count = count($ingredient);
				for($i=0; $i<$array_count; $i++){			  
					$xx = array_keys($ingredient[$i]);
					$input_ingredient_id = $ingredient[$i][$xx[0]];
					$input_amount = $amount[$i][$xx[0]];
					$input_metric_id = $metric[$i][$xx[0]];
					$input_i_sales_grams = $i_sales_grams[$i][$xx[0]];
					$input_grams = $grams[$i][$xx[0]];
					// echo '<pre>'; print_r($input_amount); echo '</pre>'; exit;
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
								$input_i_sales_grams = $pivot_data->pivot->metric_grams * $input_grams;                    //Recipe Ingredient Grams
								// echo '<pre>'; print_r($pivot_data->pivot->metric_grams); echo '</pre>';
								// echo '<pre>'; print_r($input_grams); echo '</pre>';
								// echo '<pre>'; print_r($input_i_sales_grams); echo '</pre>';
							}else{
								$biGrams = 0;
							}
						}
					}
					// echo '<pre>'; print_r($vv[0]); echo '</pre>';
					// echo '<pre>'; print_r($input_ingredient_id); echo '</pre>';
					// echo '<pre>'; print_r($xx[0]); echo '</pre>';
					
					if($xx[0] == 'x'){
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_protein = 0;
						$r_i->project_base = 1;
						$r_i->project_side = 0;
						$r_i->project_topping = 0;
						$r_i->project_amount = $input_amount;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $input_grams;
						$r_i->project_sales_grams = $input_i_sales_grams;
						$r_i->project_active = 1;
					}else{
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_base = 1;
						$r_i->project_amount = $input_amount;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $input_grams;
						$r_i->project_sales_grams = $input_i_sales_grams;
						$r_i->project_active = 1;
						$r_i->project_active = 1;
					}			

					if ($xx[0] != $input_ingredient_id){
						$d_i = MenuIngredients::find($xx[0]);
						
						$d_i->project_base = 0;
						$d_i->project_amount = 0;
						$d_i->project_metric_id = 0;
						$d_i->project_grams = 0;
						$d_i->project_sales_grams = 0;
						$d_i->project_active = 0;
						$d_i->project_active = 0;
						$d_i->save();
					}

				  	$r_i->save();
			  		// echo '<pre>'; print_r($r_i); echo '</pre>';exit;
				};
				// exit;
				// echo '<pre>'; print_r($input); echo '</pre>';exit;			
				if(isset($input['ddb'])){
					$ddb = $input['ddb'];
					// echo '<pre>'; print_r($input); echo '</pre>';exit;					
					foreach($ddb as $_delete){
						$di = MenuIngredients::find($_delete);
						$di->project_active = 0;
						$di->project_base = 0;
						$di->save();
						// $di->delete();
					};
				};		
			};

			if(isset($input['ingredients_s']) && isset($input['amount_s']) && isset($input['metric_s'])){
				$ingredient = $input['ingredients_s'];
				$amount = $input['amount_s'];
				$metric = $input['metric_s'];
				$grams = $input['grams_s'];
				$i_sales_grams = $input['i_sales_grams_s'];			
				if(isset($input['is_grams'])){$is_grams = $input['is_grams'];}else{$is_grams = 0;};
				if(isset($input['is_price'])){$is_price = $input['is_price'];}else{$is_price = 0;}
				$tis_cost = 0;
				$tis_grams = 0;
				$array_count = count($ingredient);
				for($i=0; $i<$array_count; $i++){			  
					$xx = array_keys($ingredient[$i]);
					$input_ingredient_id = $ingredient[$i][$xx[0]];
					$input_amount = $amount[$i][$xx[0]];
					$input_metric_id = $metric[$i][$xx[0]];
					$input_i_sales_grams = $i_sales_grams[$i][$xx[0]];
					$input_grams = $grams[$i][$xx[0]];
					// echo '<pre>'; print_r($input_amount); echo '</pre>'; exit;
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
								$input_i_sales_grams = $pivot_data->pivot->metric_grams * $input_grams;                    //Recipe Ingredient Grams
								// echo '<pre>'; print_r($pivot_data->pivot->metric_grams); echo '</pre>';
								// echo '<pre>'; print_r($input_grams); echo '</pre>';
								// echo '<pre>'; print_r($input_i_sales_grams); echo '</pre>';
							}else{
								$siGrams = 0;
							}
						}
					}
					// exit;
					if($xx[0] == 'x'){
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_protein = 0;
						$r_i->project_base = 0;
						$r_i->project_side = 1;
						$r_i->project_topping = 0;
						$r_i->project_amount = $input_amount;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $input_grams;
						$r_i->project_sales_grams = $input_i_sales_grams;
						$r_i->project_active = 1;
					}else{
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_side = 1;
						$r_i->project_amount = $input_amount;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $input_grams;
						$r_i->project_sales_grams = $input_i_sales_grams;
						$r_i->project_active = 1;
						$r_i->project_active = 1;
					}		

					if ($xx[0] != $input_ingredient_id){
						$d_i = MenuIngredients::find($xx[0]);
						
						$d_i->project_side = 0;
						$d_i->project_amount = 0;
						$d_i->project_metric_id = 0;
						$d_i->project_grams = 0;
						$d_i->project_sales_grams = 0;
						$d_i->project_active = 0;
						$d_i->project_active = 0;
						$d_i->save();
					}

				  	$r_i->save();
			  		// echo '<pre>'; print_r($r_i); echo '</pre>';exit;
				};
				// echo '<pre>'; print_r($input); echo '</pre>';exit;			
				if(isset($input['dds'])){
					$dds = $input['dds'];
					// echo '<pre>'; print_r($input); echo '</pre>';exit;					
					foreach($dds as $_delete){
						$di = MenuIngredients::find($_delete);
						$di->project_active = 0;
						$di->project_side = 0;
						$di->save();
						// $di->delete();
					};
				};		
			};

			if(isset($input['ingredients_t']) && isset($input['amount_t']) && isset($input['metric_t'])){
				$ingredient = $input['ingredients_t'];
				$amount = $input['amount_t'];
				$metric = $input['metric_t'];
				$grams = $input['grams_t'];
				$i_sales_grams = $input['i_sales_grams_t'];			
				if(isset($input['it_grams'])){$it_grams = $input['it_grams'];}else{$it_grams = 0;};
				if(isset($input['it_price'])){$it_price = $input['it_price'];}else{$it_price = 0;}
				$tit_cost = 0;
				$tit_grams = 0;
				$array_count = count($ingredient);
				for($i=0; $i<$array_count; $i++){			  
					$xx = array_keys($ingredient[$i]);
					$input_ingredient_id = $ingredient[$i][$xx[0]];
					$input_amount = $amount[$i][$xx[0]];
					$input_metric_id = $metric[$i][$xx[0]];
					$input_i_sales_grams = $i_sales_grams[$i][$xx[0]];
					$input_grams = $grams[$i][$xx[0]];
					// echo '<pre>'; print_r($input_amount); echo '</pre>'; exit;
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
								$input_i_sales_grams = $pivot_data->pivot->metric_grams * $input_grams;                    //Recipe Ingredient Grams
								// echo '<pre>'; print_r($pivot_data->pivot->metric_grams); echo '</pre>';
								// echo '<pre>'; print_r($input_grams); echo '</pre>';
								// echo '<pre>'; print_r($input_i_sales_grams); echo '</pre>';
							}else{
								$tiGrams = 0;
							}
						}
					}
					// exit;
					if($xx[0] == 'x'){
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_protein = 0;
						$r_i->project_base = 0;
						$r_i->project_side = 0;
						$r_i->project_topping = 1;
						$r_i->project_amount = $input_amount;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $input_grams;
						$r_i->project_sales_grams = $input_i_sales_grams;
						$r_i->project_active = 1;
					}else{
						$r_i = MenuIngredients::find($input_ingredient_id);
						$r_i->project_topping = 1;
						$r_i->project_amount = $input_amount;
						$r_i->project_metric_id = $input_metric_id;
						$r_i->project_grams = $input_grams;
						$r_i->project_sales_grams = $input_i_sales_grams;
						$r_i->project_active = 1;
						$r_i->project_active = 1;
					}		

					if ($xx[0] != $input_ingredient_id){
						$d_i = MenuIngredients::find($xx[0]);
						
						$d_i->project_topping = 0;
						$d_i->project_amount = 0;
						$d_i->project_metric_id = 0;
						$d_i->project_grams = 0;
						$d_i->project_sales_grams = 0;
						$d_i->project_active = 0;
						$d_i->project_active = 0;
						$d_i->save();
					}

				  	$r_i->save();
			  		// echo '<pre>'; print_r($r_i); echo '</pre>';exit;
				};
				// echo '<pre>'; print_r($input); echo '</pre>';exit;			
				if(isset($input['ddt'])){
					$ddt = $input['ddt'];
					// echo '<pre>'; print_r($input); echo '</pre>';exit;					
					foreach($ddt as $_delete){
						$di = MenuIngredients::find($_delete);
						$di->project_active = 0;
						$di->project_topping = 0;
						$di->save();
						// $di->delete();
					};
				};		
			};

			if(isset($input['calc'])){

				$ingredients = MenuIngredients::orderBy('name','ASC')->where('active', '!=', '9')->get();
				$metrics = Metric::orderBy('name','ASC')->get();



				foreach ($ingredients as $ingredient) {
					if($ingredient->project_protein == 1){
						$p_array[$ingredient->id] = array(
							'name' => $ingredient->name, 
							'project_amount' => $ingredient->project_amount, 
							'project_metric_id' => $ingredient->project_metric_id, 
							'project_grams' => $ingredient->project_grams,
							'project_sales_grams' => $ingredient->project_sales_grams, 
							'grams' => $ingredient->grams, 
							'price' => $ingredient->price
						);
					}		
				};

				foreach ($ingredients as $ingredient) {
					if($ingredient->project_base == 1){
						$b_array[$ingredient->id] = array(
							'name' => $ingredient->name, 
							'project_amount' => $ingredient->project_amount, 
							'project_metric_id' => $ingredient->project_metric_id, 
							'project_grams' => $ingredient->project_grams,
							'project_sales_grams' => $ingredient->project_sales_grams, 
							'grams' => $ingredient->grams, 
							'price' => $ingredient->price
						);
					}		
				};

				foreach ($ingredients as $ingredient) {
					if($ingredient->project_side == 1){
						$s_array[$ingredient->id] = array(
							'name' => $ingredient->name, 
							'project_amount' => $ingredient->project_amount, 
							'project_metric_id' => $ingredient->project_metric_id, 
							'project_grams' => $ingredient->project_grams,
							'project_sales_grams' => $ingredient->project_sales_grams, 
							'grams' => $ingredient->grams, 
							'price' => $ingredient->price
						);
					}		
				};

				foreach ($ingredients as $ingredient) {
					if($ingredient->project_side == 1){
						$ss_array[$ingredient->id] = array(
							'name' => $ingredient->name, 
							'project_amount' => $ingredient->project_amount, 
							'project_metric_id' => $ingredient->project_metric_id, 
							'project_grams' => $ingredient->project_grams,
							'project_sales_grams' => $ingredient->project_sales_grams, 
							'grams' => $ingredient->grams, 
							'price' => $ingredient->price
						);
					}		
				};

				foreach ($ingredients as $ingredient) {
					if($ingredient->project_side == 1){
						$t_array[$ingredient->id] = array(
							'name' => $ingredient->name, 
							'project_amount' => $ingredient->project_amount, 
							'project_metric_id' => $ingredient->project_metric_id, 
							'project_grams' => $ingredient->project_grams,
							'project_sales_grams' => $ingredient->project_sales_grams, 
							'grams' => $ingredient->grams, 
							'price' => $ingredient->price
						);
					}		
				};



				foreach ($p_array as $pk => $pv){
					$p_name = $pv['name'];
					$p_grams = $pv['project_grams'];
					$p_sales_grams = $pv['project_sales_grams'];
					$p_price = $pv['price'];
					foreach ($b_array as $bk => $bv) {
						$b_name = $bv['name'];
						$b_grams = $bv['project_grams'];
						$b_sales_grams = $pv['project_sales_grams'];
						$b_price = $bv['price'];
						foreach ($s_array as $sk => $sv){
							$s_name = $sv['name'];
							$s_grams = $sv['project_grams'];
							$s_sales_grams = $sv['project_sales_grams'];
							$s_price = $sv['price'];
							foreach ($ss_array as $ssk => $ssv){
								$ss_name = $ssv['name'];
								$ss_grams = $ssv['project_grams'];
								$ss_sales_grams = $ssv['project_sales_grams'];
								$ss_price = $ssv['price'];
								foreach ($t_array as $tk => $tv){
									$t_name = $tv['name'];
									$t_grams = $tv['project_grams'];
									$t_sales_grams = $tv['project_sales_grams'];
									$t_price = $tv['price'];


								$fprice = $p_price + $b_price + $s_price + $ss_price + $t_price;


echo '<pre>'; print_r($p_price); echo ' + '; print_r($b_price); echo ' + '; print_r($s_price); echo ' + '; print_r($ss_price); echo ' + '; print_r($t_price); echo ' = '; print_r($fprice); echo '</pre>';


		echo '<pre>'; print_r($p_name); echo ' + '; print_r($b_name); echo ' + '; print_r($s_name); echo ' + '; print_r($ss_name); echo ' + '; print_r($t_name); echo ' = '; print_r($fprice); echo '</pre>';	
		echo "<hr>";
								}
							}	
						}
					}
				}
				exit;	















				echo '<pre>'; print_r($input); echo '</pre>';exit;
			}		



			// exit;

			if(isset($input['sc'])){
				return Redirect::action('Admin_QuickController@getQuick');
			}else{
				return Redirect::action('Admin_QuickController@getEditQuick');

				$ingredients = MenuIngredients::orderBy('name','ASC')->where('active', '!=', '9')->get();
				$metrics = Metric::orderBy('name','ASC')->get();
				// $sales_data = SalesData::where('menu_recipe_id', '=', $data->id)->get();
				// $sales_data_ingredients = SalesDataIngredients::where('menu_recipe_id', '=', $data->id)->get();

				//put ingredients into an array oof each stage, then pull it into the view

				$mIng = array();
				$mIng[0]	= '- Select Ingredients -';
				$data_check = 0;
				foreach ($ingredients as $ingredient) {
					$mIng[$ingredient->id]	= $ingredient->name;
					if($ingredient->project_protein == 1){
						$data_check = 1;
					}
					if($ingredient->project_base == 1){
						$data_check = 1;
					}
					if($ingredient->project_side == 1){
						$data_check = 1;
					}
					if($ingredient->project_topping == 1){
						$data_check = 1;
					}
					$mIng[] = array(
						'name' => $ingredient->name, 
						'project_amount' => $ingredient->project_amount, 
						'project_metric_id' => $ingredient->project_metric_id, 
						'project_grams' => $ingredient->project_grams,
						'project_sales_grams' => $ingredient->project_sales_grams, 
						'grams' => $ingredient->grams, 
						'price' => $ingredient->price
					);
				};
				echo '<pre>'; print_r( $mIng ); echo '</pre>';exit;


				$p_array = array();
				$pIng = array();
				$pIng[0]	= '- Select Ingredients -';	
				foreach ($ingredients as $ingredient) {
					if($ingredient->project_protein == 1){
						$p_array[$ingredient->id] = array(
							'name' => $ingredient->name, 
							'project_amount' => $ingredient->project_amount, 
							'project_metric_id' => $ingredient->project_metric_id, 
							'project_grams' => $ingredient->project_grams,
							'project_sales_grams' => $ingredient->project_sales_grams, 
							'grams' => $ingredient->grams, 
							'price' => $ingredient->price
						);
					}		
				};
				$out = array_values($p_array);
				$json_p = json_encode($p_array);

				$b_array = array();
				$bIng = array();
				$bIng[0]	= '- Select Ingredients -';	
				foreach ($ingredients as $ingredient) {
					if($ingredient->project_base == 1){
						$b_array[$ingredient->id] = array(
							'name' => $ingredient->name, 
							'project_amount' => $ingredient->project_amount, 
							'project_metric_id' => $ingredient->project_metric_id, 
							'project_grams' => $ingredient->project_grams,
							'project_sales_grams' => $ingredient->project_sales_grams, 
							'grams' => $ingredient->grams, 
							'price' => $ingredient->price
						);
					}		
				};
				$out = array_values($b_array);
				$json_b = json_encode($b_array);

				$s_array = array();
				$sIng = array();
				$sIng[0]	= '- Select Ingredients -';	
				foreach ($ingredients as $ingredient) {
					if($ingredient->project_side == 1){
						$s_array[$ingredient->id] = array(
							'name' => $ingredient->name, 
							'project_amount' => $ingredient->project_amount, 
							'project_metric_id' => $ingredient->project_metric_id, 
							'project_grams' => $ingredient->project_grams,
							'project_sales_grams' => $ingredient->project_sales_grams, 
							'grams' => $ingredient->grams, 
							'price' => $ingredient->price
						);
					}		
				};
				$out = array_values($s_array);
				$json_s = json_encode($s_array);

				$t_array = array();
				$tIng = array();
				$tIng[0]	= '- Select Ingredients -';	
				foreach ($ingredients as $ingredient) {
					if($ingredient->project_topping == 1){
						$t_array[$ingredient->id] = array(
							'name' => $ingredient->name, 
							'project_amount' => $ingredient->project_amount, 
							'project_metric_id' => $ingredient->project_metric_id, 
							'project_grams' => $ingredient->project_grams,
							'project_sales_grams' => $ingredient->project_sales_grams, 
							'grams' => $ingredient->grams, 
							'price' => $ingredient->price
						);
					}		
				};
				$out = array_values($t_array);
				$json_t = json_encode($t_array);

				
				$mMetric = array();
				$mMetric[0]	= '- Select Metric -';
				foreach ($metrics as $metric) {
					$mMetric[$metric->id]	= $metric->name;
				};
				
				// $sales_data_ingredients = array();
				// $s_ingredients = $ingredients;
				

				

				// foreach($sales_data as $i => $in){
				// 	echo '<pre>'; print_r( $i); echo '</pre>'; 
				// 	echo '<pre>'; print_r( $in ); echo '</pre>'; 
				// // 	echo '<br/';
				// }
				// exit;

				//$data from the load function above holds all the data for facts to go into the form
				$calculated = 0;


		// <select name="ingredients[][{{ $p_ingredient->id }}]" id="ingredients_{{ $x }}" class="form-control input--ingredient"/>
	 //        @foreach($base as $i=>$v)
	 //        	<option value="{{ $i }}" @if ($b_ingredient->menu_ingredients_id == $i) selected="selected" @endif >{{ $v }}</option>
	 //        @endforeach
	 //    </select>

		

		// foreach ($p_array as $key => $p_ingredient) { 
		// 	echo '<pre>'; print_r( $p_ingredient ); echo '</pre>'; 

		
		// }
		



		return View::make('admin.quick.form')
			->with(array(
				'ingredients' => $mIng,
				'ingredients_p' => $pIng,
				'json_p' => $json_p,
				'p_array' => $p_array,

				'ingredients_b' => $bIng,
				'json_b' => $json_b,
				'b_array' => $b_array,

				'ingredients_s' => $sIng,
				'json_s' => $json_s,
				's_array' => $s_array,

				'ingredients_t' => $tIng,
				'json_t' => $json_t,
				't_array' => $t_array,

				'metric' => $mMetric,
				'data_check' => $data_check,
				// 'sales_data_ingredients' => $sales_data_ingredients,
				'title'		=> 'Edit Fed Up Projects:',
				'calculated' => 0,
			));	


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

exit;
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
					  
