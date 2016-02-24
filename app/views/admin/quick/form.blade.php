@extends('tmpl.admin')

@section('title')
    {{ $title }}
@stop

@section('_head') 
	<script type="text/javascript" src="/packages/jquery-1.11.1.min/vendor/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
	<script type="text/javascript" src="/packages/plupload-2.1.2/js/plupload.full.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/packages/jquery-1.11.1.min/vendor/jquery-ui-1.10.4.custom/css/no-theme/jquery-ui-1.10.4.custom.min.css"/> 
    
    <script>
      


	$(function() {
		  
		$( "._mySortable" ).sortable({ 
			axis: "y", 
			opacity: 0.3,
			placeholder: "sortable-placeholder",
			// callback function
			update: function( event, ui ) {
				ui.item.css({'background':'#DBEEC9'})
			},
		});
		$( "._mySortable" ).disableSelection();




		//Start Delete Protein
		$('#counterProtein').val( $('#_ListProtein li').length );

		$('.deleteProtein').click(function(e) {
			e.preventDefault();
			
			//var currentID = 0;	
					
			var currentID = (this.id);
			
			if($("#ddp" + currentID).length == 0) {
				$('#_ListProtein')
					
						.append( $('<input>',{
							'type':'hidden',
							'name':'ddp[]',
							'id':'ddi'+currentID, /*ddi = delete data ingredient*/
							'class':'form-control',
							'value':''+currentID,
						}) )
				;
				$(this).parent('li').hide().unbind('click');
				
			} else {
			//alert('this record already exists');
				$("#ddp" + currentID).closest('input').remove().unbind('click');
			}
			
			
			
		});


		//Start Ingredients
		$('#counterProtein').val( $('#_ListProtein li').length );
		$('#btnActionAddProtein').click(function(e) {
			e.preventDefault();
			
			var currentID = $('#counterProtein').val();
					
			$ix = 0;
			var ingredientsArray = [];
			<?php
			
			$ix = 0;
			foreach ($ingredients as $i=>$v) {
				echo 'ingredientsArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectList	= $('<select>',{
						'name':'ingredients_p[][x]',
						'id':'ingredients_p_'+currentID,
						'class':'form-control input--ingredient',
					});
			
			$.each(ingredientsArray, function(key,value) {
				SelectList
					.append($('<option></option>')
					.attr('value',value[0])
					.text(value[1])); 
			});
			
			var metricArray = [];
			<?php
			
			$ix = 0;
			foreach ($metric as $i=>$v) {
				echo 'metricArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectListM	= $('<select>',{
						'name':'metric_p[][x]',
						'id':'metric_p_'+currentID,
						'class':'form-control input--metric',
					});
			
			$.each(metricArray, function(key,value) {
				SelectListM
					.append($('<option></option>')
					.attr('value',value[0])//Returns first element in the array
					.text(value[1])); //Returns second element in the array
			});
			
			var deleteButton	= $('<button>',{
										'class':'glyphicon glyphicon-remove btn btn-danger'
									});
			deleteButton.bind('click', function(e){
				e.preventDefault();
				$(this).parent('li').remove().unbind('click');
			});
			
			$('#_ListProtein')
				.append( $('<li>') 
				
					.append( SelectList )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'amount_p[][x]',
						'id':'amount_p_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'amount',
					}) )
					.append( '&nbsp;' )
					.append( SelectListM )
					.append( '&nbsp;' )
					
					.append( $('<input>',{
						'name':'grams_p[][x]',
						'id':'grams_p_'+currentID,
						'class':'form-control input--grams',
						'placeholder':'grams',
					}) )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'i_sales_grams_p[][x]',
						'id':'i_sales_grams_p_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'0.00',
					}) )
					.append( '&nbsp;' )

					.append( deleteButton )
					.append( '&nbsp;' )
					.append( $('<span>',{
						'class':'glyphicon glyphicon-sort btn btn-default disabled'
					}) )
					
				)
			;
			
			$('#counterProtein').val( parseInt(currentID, 10) + 1 );
			
		});






		

		//Start Delete Ingredient Base
		$('#counterBase').val( $('#_ListBase li').length );

		$('.deleteBase').click(function(e) {
			e.preventDefault();
			
			//var currentID = 0;	
					
			var currentID = (this.id);
			
			if($("#ddb" + currentID).length == 0) {
				$('#_ListBase')
					
						.append( $('<input>',{
							'type':'hidden',
							'name':'ddb[]',
							'id':'ddi'+currentID, /*ddi = delete data ingredient*/
							'class':'form-control',
							'value':''+currentID,
						}) )
				;
				$(this).parent('li').hide().unbind('click');
				
			} else {
			//alert('this record already exists');
				$("#ddb" + currentID).closest('input').remove().unbind('click');
			}
			
			
			
		});

		
		//Start Ingredients Base
		$('#counterBase').val( $('#_ListBase li').length );
		$('#btnActionAddBase').click(function(e) {
			e.preventDefault();
			
			var currentID = $('#counterBase').val();
					
			$ix = 0;
			var ingredientsArray = [];
			<?php
			
			$ix = 0;
			foreach ($ingredients as $i=>$v) {
				echo 'ingredientsArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectList	= $('<select>',{
						'name':'ingredients_b[][x]',
						'id':'ingredients_b_'+currentID,
						'class':'form-control input--ingredient',
					});
			
			$.each(ingredientsArray, function(key,value) {
				SelectList
					.append($('<option></option>')
					.attr('value',value[0])
					.text(value[1])); 
			});
			
			var metricArray = [];
			<?php
			
			$ix = 0;
			foreach ($metric as $i=>$v) {
				echo 'metricArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectListM	= $('<select>',{
						'name':'metric_b[][x]',
						'id':'metric_b_'+currentID,
						'class':'form-control input--metric',
					});
			
			$.each(metricArray, function(key,value) {
				SelectListM
					.append($('<option></option>')
					.attr('value',value[0])//Returns first element in the array
					.text(value[1])); //Returns second element in the array
			});
			
			var deleteButton	= $('<button>',{
										'class':'glyphicon glyphicon-remove btn btn-danger'
									});
			deleteButton.bind('click', function(e){
				e.preventDefault();
				$(this).parent('li').remove().unbind('click');
			});
			
			$('#_ListBase')
				.append( $('<li>') 
				
					.append( SelectList )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'amount_b[][x]',
						'id':'amount_b_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'amount',
					}) )
					.append( '&nbsp;' )
					.append( SelectListM )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'grams_b[][x]',
						'id':'grams_b_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'0.00',
					}) )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'i_sales_grams_b[][x]',
						'id':'i_sales_grams_b_'+currentID,
						'class':'form-control input--grams',
						'placeholder':'grams',
					}) )
					.append( '&nbsp;' )

					.append( deleteButton )
					.append( '&nbsp;' )
					.append( $('<span>',{
						'class':'glyphicon glyphicon-sort btn btn-default disabled'
					}) )
					
				)
			;
			
			$('#counterBase').val( parseInt(currentID, 10) + 1 );
			
		});



		// //Start Delete Side
		$('#counterSide').val( $('#_ListSide li').length );

		$('.deleteSide').click(function(e) {
			e.preventDefault();
			
			//var currentID = 0;	
					
			var currentID = (this.id);
			
			if($("#dds" + currentID).length == 0) {
				$('#_ListSide')
					
						.append( $('<input>',{
							'type':'hidden',
							'name':'dds[]',
							'id':'dds'+currentID, /*ddi = delete data ingredient*/
							'class':'form-control',
							'value':''+currentID,
						}) )
				;
				$(this).parent('li').hide().unbind('click');
				
			} else {
			//alert('this record already exists');
				$("#dds" + currentID).closest('input').remove().unbind('click');
			}

		});

		
		// //Start Ingredients Side 
		$('#counterSide').val( $('#_ListSide li').length );
		$('#btnActionAddSide').click(function(e) {
			e.preventDefault();
			
			var currentID = $('#counterSide').val();
					
			$ix = 0;
			var ingredientsArray = [];
			<?php
			
			$ix = 0;
			foreach ($ingredients as $i=>$v) {
				echo 'ingredientsArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectList	= $('<select>',{
						'name':'ingredients_s[][x]',
						'id':'ingredients_s_'+currentID,
						'class':'form-control input--ingredient',
					});
			
			$.each(ingredientsArray, function(key,value) {
				SelectList
					.append($('<option></option>')
					.attr('value',value[0])
					.text(value[1])); 
			});
			
			var metricArray = [];
			<?php
			
			$ix = 0;
			foreach ($metric as $i=>$v) {
				echo 'metricArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectListM	= $('<select>',{
						'name':'metric_s[][x]',
						'id':'metric_s_'+currentID,
						'class':'form-control input--metric',
					});
			
			$.each(metricArray, function(key,value) {
				SelectListM
					.append($('<option></option>')
					.attr('value',value[0])//Returns first element in the array
					.text(value[1])); //Returns second element in the array
			});
			
			var deleteButton	= $('<button>',{
										'class':'glyphicon glyphicon-remove btn btn-danger'
									});
			deleteButton.bind('click', function(e){
				e.preventDefault();
				$(this).parent('li').remove().unbind('click');
			});
			
			$('#_ListSide')
				.append( $('<li>') 
				
					.append( SelectList )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'amount_s[][x]',
						'id':'amount_s_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'amount',
					}) )
					.append( '&nbsp;' )
					.append( SelectListM )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'grams_s[][x]',
						'id':'grams_s_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'0.00',
					}) )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'i_sales_grams_s[][x]',
						'id':'i_sales_grams_s_'+currentID,
						'class':'form-control input--grams',
						'placeholder':'grams',
					}) )
					.append( '&nbsp;' )

					.append( deleteButton )
					.append( '&nbsp;' )
					.append( $('<span>',{
						'class':'glyphicon glyphicon-sort btn btn-default disabled'
					}) )
					
				)
			;
			
			$('#counterSide').val( parseInt(currentID, 10) + 1 );
			
		});
		

		// //Start Delete Topping
		$('#counterTopping').val( $('#_ListTopping li').length );

		$('.deleteTopping').click(function(e) {
			e.preventDefault();
			
			//var currentID = 0;	
					
			var currentID = (this.id);
			
			if($("#dds" + currentID).length == 0) {
				$('#_ListTopping')
					
						.append( $('<input>',{
							'type':'hidden',
							'name':'ddt[]',
							'id':'ddt'+currentID, /*ddi = delete data ingredient*/
							'class':'form-control',
							'value':''+currentID,
						}) )
				;
				$(this).parent('li').hide().unbind('click');
				
			} else {
			//alert('this record already exists');
				$("#ddt" + currentID).closest('input').remove().unbind('click');
			}

		});

		
		// //Start Ingredients Topping
		$('#counterTopping').val( $('#_ListTopping li').length );
		$('#btnActionAddTopping').click(function(e) {
			e.preventDefault();
			
			var currentID = $('#counterTopping').val();
					
			$ix = 0;
			var ingredientsArray = [];
			<?php
			
			$ix = 0;
			foreach ($ingredients as $i=>$v) {
				echo 'ingredientsArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectList	= $('<select>',{
						'name':'ingredients_t[][x]',
						'id':'ingredients_t_'+currentID,
						'class':'form-control input--ingredient',
					});
			
			$.each(ingredientsArray, function(key,value) {
				SelectList
					.append($('<option></option>')
					.attr('value',value[0])
					.text(value[1])); 
			});
			
			var metricArray = [];
			<?php
			
			$ix = 0;
			foreach ($metric as $i=>$v) {
				echo 'metricArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
				$ix++;
			}; 

			?>
			
			var SelectListM	= $('<select>',{
						'name':'metric_t[][x]',
						'id':'metric_t_'+currentID,
						'class':'form-control input--metric',
					});
			
			$.each(metricArray, function(key,value) {
				SelectListM
					.append($('<option></option>')
					.attr('value',value[0])//Returns first element in the array
					.text(value[1])); //Returns second element in the array
			});
			
			var deleteButton	= $('<button>',{
										'class':'glyphicon glyphicon-remove btn btn-danger'
									});
			deleteButton.bind('click', function(e){
				e.preventDefault();
				$(this).parent('li').remove().unbind('click');
			});
			
			$('#_ListTopping')
				.append( $('<li>') 
				
					.append( SelectList )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'amount_t[][x]',
						'id':'amount_t_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'amount',
					}) )
					.append( '&nbsp;' )
					.append( SelectListM )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'grams_t[][x]',
						'id':'grams_t_'+currentID,
						'class':'form-control input--amount',
						'placeholder':'0.00',
					}) )
					.append( '&nbsp;' )
					.append( $('<input>',{
						'name':'i_sales_grams_t[][x]',
						'id':'i_sales_grams_t_'+currentID,
						'class':'form-control input--grams',
						'placeholder':'grams',
					}) )
					.append( '&nbsp;' )

					.append( deleteButton )
					.append( '&nbsp;' )
					.append( $('<span>',{
						'class':'glyphicon glyphicon-sort btn btn-default disabled'
					}) )
					
				)
			;
			
			$('#counterTopping').val( parseInt(currentID, 10) + 1 );
			
		});


	}) ;


	</script>
@stop

@section('content')

	<?php //echo '<pre>'; print_r($json_calc); echo '</pre>'; exit; ?>
  
  <div class="row">
  	<h1 class="page-header">@yield('title')</h1>

  	@if ($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
	@endif


    @if($data_check == 1)
    	{{ Form::open(array('action' => 'Admin_QuickController@postUpdateQuick', 'class' => 'form-horizontal')) }} 
   	@else
  		{{ Form::open(array('action' => 'Admin_QuickController@postAddQuick', 'class' => 'form-horizontal')) }} 
    @endif
    
    <ul id="myTab" class="nav nav-tabs">
      	<li class="@if($calculated != 1)active@endif"><a href="#protein" data-toggle="tab">Protein</a></li>
      	<li><a href="#base" data-toggle="tab">Base</a></li>
      	<li><a href="#side" data-toggle="tab">Sides</a></li>
      	<li><a href="#topping" data-toggle="tab">Topping</a></li>
      <li class="@if($calculated == 1)active@endif"><a href="#sales" data-toggle="tab">Sales Data</a></li>
    </ul>
    
    <div id="myTabContent" class="tab-content ">
    	<div class="tab-pane fade in @if($calculated != 1)active@endif" id="protein">
    		<div class="col-sm-1">
	          	{{-- Form::button('+ Add', array('id' => 'btnActionAddProtein','class' => 'btn btn-primary')) --}}
	          	<a href="#" id="btnActionAddProtein" class="btn btn-primary">+ Add</a>
	          	{{ Form::hidden('counterProtein',null,array('id'=>'counterProtein')) }} 
	        </div>
			<hr/>
			 <div class="form-group {{ ($errors->has('protein')) ? 'has-error' : '' ; }}">
	           	{{ ($errors->has('protein'))? '<p>'. $errors->first('protein') .'</p>' : '' }}
	          	<ul id="_ListProtein" class="_mySortable">
	            	<?php $x = 0; ?>
	                @if(isset($p_array))
	                	@foreach($p_array as $ingredient_id => $p_ingredient)
	                    	<li>
	                            <select name="ingredients_p[][{{ $ingredient_id }}]" id="ingredients_p_{{ $x }}" class="form-control input--ingredient"/>
	                                @foreach($ingredients as $i=>$v)
	                                	<option value="{{ $i }}" @if ($ingredient_id == $i) selected="selected" @endif >{{ $v }}</option>
	                                @endforeach
	                            </select>
	                            <input name="amount_p[][{{ $ingredient_id}}]" id="ingredients_p_{{ $x }}" class="form-control input--amount " value="{{ $p_ingredient['project_amount'] }}" />
	                            <select name="metric_p[][{{ $ingredient_id }}]" id="ingredients_p_{{ $x }}" class="form-control input--metric"/>
	                                @foreach($metric as $in=>$val)
	                                	<option value="{{ $in }}" @if ($p_ingredient['project_metric_id'] == $in) selected="selected" @endif >{{ $val }}</option>
	                                @endforeach
	                            </select>
	                            <input name="grams_p[][{{ $ingredient_id }}]" id="ingredients_p_{{ $x }}" class="form-control input--amount " value="{{ $p_ingredient['project_grams'] }}" />
	                            <input name="i_sales_grams_p[][{{ $ingredient_id }}]" id="ingredients_p_{{ $x }}" class="form-control input--grams " value="{{ $p_ingredient['project_sales_grams'] }}" />

	                            @foreach($p_array as $i => $in)
	                            	@if($i == $ingredient_id)
	                            		<input type="hidden" name="ip_grams[{{$i}}]" value="{{ $in['grams'] }}" />
	                            		<input type="hidden" name="ip_price[{{$i}}]" value="{{ $in['price'] }}" />
		                        	@endif
		                        @endforeach

	                            <button id="{{ $ingredient_id }}" class="deleteProtein glyphicon glyphicon-remove btn btn-danger"></button>
	                            <span class="glyphicon glyphicon-sort btn btn-default disabled"></span>
	                            
	                   		</li>
		                 	<?php $x++; ?>                    
	                   	@endforeach
	                @endif
	         	</ul>
			</div>

		</div>
		<div class="tab-pane fade in" id="base">
    		<div class="col-sm-1">
	          	{{-- Form::button('+ Add', array('id' => 'btnActionAddBase','class' => 'btn btn-primary')) --}}
	          	<a href="#" id="btnActionAddBase" class="btn btn-primary">+ Add</a>
	          	{{ Form::hidden('counterBase',null,array('id'=>'counterBase')) }} 
	        </div>
			<hr/>
			<div class="form-group {{ ($errors->has('base')) ? 'has-error' : '' ; }}">
	           	{{ ($errors->has('base'))? '<p>'. $errors->first('base') .'</p>' : '' }}
	          	<ul id="_ListBase" class="_mySortable">
	            	<?php $x = 0; ?>
	                @if(isset($b_array))
	                	@foreach($b_array as $ingredient_id => $b_ingredient)
	                    	<li>
	                            <select name="ingredients_b[][{{ $ingredient_id }}]" id="ingredients_b_{{ $x }}" class="form-control input--ingredient"/>
	                                @foreach($ingredients as $i=>$v)
	                                	<option value="{{ $i }}" @if ($ingredient_id == $i) selected="selected" @endif >{{ $v }}</option>
	                                @endforeach
	                            </select>
	                            <input name="amount_b[][{{ $ingredient_id}}]" id="ingredients_b_{{ $x }}" class="form-control input--amount " value="{{ $b_ingredient['project_amount'] }}" />
	                            <select name="metric_b[][{{ $ingredient_id }}]" id="ingredients_b_{{ $x }}" class="form-control input--metric"/>
	                                @foreach($metric as $in=>$val)
	                                	<option value="{{ $in }}" @if ($b_ingredient['project_metric_id'] == $in) selected="selected" @endif >{{ $val }}</option>
	                                @endforeach
	                            </select>
	                            <input name="grams_b[][{{ $ingredient_id }}]" id="ingredients_b_{{ $x }}" class="form-control input--amount " value="{{ $b_ingredient['project_grams'] }}" />
	                            <input name="i_sales_grams_b[][{{ $ingredient_id }}]" id="ingredients_b_{{ $x }}" class="form-control input--grams " value="{{ $b_ingredient['project_sales_grams'] }}" />

	                            @foreach($b_array as $i => $in)
	                            	@if($i == $ingredient_id)
	                            		<input type="hidden" name="ib_grams[{{$i}}]" value="{{ $in['grams'] }}" />
	                            		<input type="hidden" name="ib_price[{{$i}}]" value="{{ $in['price'] }}" />
		                        	@endif
		                        @endforeach

	                            <button id="{{ $ingredient_id }}" class="deleteBase glyphicon glyphicon-remove btn btn-danger"></button>
	                            <span class="glyphicon glyphicon-sort btn btn-default disabled"></span>
	                            
	                   		</li>
		                 	<?php $x++; ?>                    
	                   	@endforeach
	                @endif
	         	</ul>
			</div>
		</div>
		<div class="tab-pane fade in" id="side">
			<div class="col-sm-1">
	          	{{-- Form::button('+ Add', array('id' => 'btnActionAddSide','class' => 'btn btn-primary')) --}}
	          	<a href="#" id="btnActionAddSide" class="btn btn-primary">+ Add</a>
	          	{{ Form::hidden('counterSide',null,array('id'=>'counterSide')) }} 
	        </div>
			<hr/>
			<div class="form-group {{ ($errors->has('side')) ? 'has-error' : '' ; }}">
	           	{{ ($errors->has('side'))? '<p>'. $errors->first('side') .'</p>' : '' }}
	          	<ul id="_ListSide" class="_mySortable">
	            	<?php $x = 0; ?>
	                @if(isset($s_array))
	                	@foreach($s_array as $ingredient_id => $s_ingredient)
	                    	<li>
	                            <select name="ingredients_s[][{{ $ingredient_id }}]" id="ingredients_s_{{ $x }}" class="form-control input--ingredient"/>
	                                @foreach($ingredients as $i=>$v)
	                                	<option value="{{ $i }}" @if ($ingredient_id == $i) selected="selected" @endif >{{ $v }}</option>
	                                @endforeach
	                            </select>
	                            <input name="amount_s[][{{ $ingredient_id}}]" id="ingredients_s_{{ $x }}" class="form-control input--amount " value="{{ $s_ingredient['project_amount'] }}" />
	                            <select name="metric_s[][{{ $ingredient_id }}]" id="ingredients_s_{{ $x }}" class="form-control input--metric"/>
	                                @foreach($metric as $in=>$val)
	                                	<option value="{{ $in }}" @if ($s_ingredient['project_metric_id'] == $in) selected="selected" @endif >{{ $val }}</option>
	                                @endforeach
	                            </select>
	                            <input name="grams_s[][{{ $ingredient_id }}]" id="ingredients_s_{{ $x }}" class="form-control input--amount " value="{{ $s_ingredient['project_grams'] }}" />
	                            <input name="i_sales_grams_s[][{{ $ingredient_id }}]" id="ingredients_s_{{ $x }}" class="form-control input--grams " value="{{ $s_ingredient['project_sales_grams'] }}" />

	                            @foreach($s_array as $i => $in)
	                            	@if($i == $ingredient_id)
	                            		<input type="hidden" name="is_grams[{{$i}}]" value="{{ $in['grams'] }}" />
	                            		<input type="hidden" name="is_price[{{$i}}]" value="{{ $in['price'] }}" />
		                        	@endif
		                        @endforeach

	                            <button id="{{ $ingredient_id }}" class="deleteSide glyphicon glyphicon-remove btn btn-danger"></button>
	                            <span class="glyphicon glyphicon-sort btn btn-default disabled"></span>
	                            
	                   		</li>
		                 	<?php $x++; ?>                    
	                   	@endforeach
	                @endif
	         	</ul>
			</div>
		</div>

      	<div class="tab-pane fade in" id="topping">
      		<div class="col-sm-1">
	          	{{-- Form::button('+ Add', array('id' => 'btnActionAddTopping','class' => 'btn btn-primary')) --}}
	          	<a href="#" id="btnActionAddTopping" class="btn btn-primary">+ Add</a>
	          	{{ Form::hidden('counterTopping',null,array('id'=>'counterTopping')) }} 
	        </div>
			<hr/>
			<div class="form-group {{ ($errors->has('Topping')) ? 'has-error' : '' ; }}">
	           	{{ ($errors->has('Topping'))? '<p>'. $errors->first('Topping') .'</p>' : '' }}
	          	<ul id="_ListTopping" class="_mySortable">
	            	<?php $x = 0; ?>
	                @if(isset($t_array))
	                	@foreach($t_array as $ingredient_id => $t_ingredient)
	                    	<li>
	                            <select name="ingredients_t[][{{ $ingredient_id }}]" id="ingredients_t_{{ $x }}" class="form-control input--ingredient"/>
	                            	@foreach($ingredients as $i=>$v)
	                                	<option value="{{ $i }}" @if ($ingredient_id == $i) selected="selected" @endif >{{ $v }}</option>
	                                @endforeach
	                            </select>
	                            <input name="amount_t[][{{ $ingredient_id}}]" id="ingredients_t_{{ $x }}" class="form-control input--amount " value="{{ $t_ingredient['project_amount'] }}" />
	                            <select name="metric_t[][{{ $ingredient_id }}]" id="ingredients_t_{{ $x }}" class="form-control input--metric"/>
	                                @foreach($metric as $in=>$val)
	                                	<option value="{{ $in }}" @if ($t_ingredient['project_metric_id'] == $in) selected="selected" @endif >{{ $val }}</option>
	                                @endforeach
	                            </select>
	                            <input name="grams_t[][{{ $ingredient_id }}]" id="ingredients_t_{{ $x }}" class="form-control input--amount " value="{{ $t_ingredient['project_grams'] }}" />
	                            <input name="i_sales_grams_t[][{{ $ingredient_id }}]" id="ingredients_t_{{ $x }}" class="form-control input--grams " value="{{ $t_ingredient['project_sales_grams'] }}" />

	                            @foreach($t_array as $i => $in)
	                            	@if($i == $ingredient_id)
	                            		<input type="hidden" name="it_grams[{{$i}}]" value="{{ $in['grams'] }}" />
	                            		<input type="hidden" name="it_price[{{$i}}]" value="{{ $in['price'] }}" />
		                        	@endif
		                        @endforeach

	                            <button id="{{ $ingredient_id }}" class="deleteTopping glyphicon glyphicon-remove btn btn-danger"></button>
	                            <span class="glyphicon glyphicon-sort btn btn-default disabled"></span>
	                            
	                   		</li>
		                 	<?php $x++; ?>                    
	                   	@endforeach
	                @endif
	         	</ul>
			</div>
		</div>
      	<div class="tab-pane fade in @if($calculated == 1)active@endif" id="sales">
      		<div class="row">

		            <div class="col-sm-2">
		            	{{ Form::submit('+ Calc', array('id' => 'btnActionCalculate','name' => 'calc','class' => 'btn btn-primary')) }}
		            </div>
		            <div class="col-sm-3">
		            	 {{ Form::label('staff_cost_per_hour', 'Staff Cost: ', array('class' => 'control-label')) }}
			            {{ Form::text('staff_cost_per_hour', (isset($input['staff_cost_per_hour'])? Input::old('staff_cost_per_hour') : (isset($staff_cost_per_hour)? $staff_cost_per_hour : '' )), array('class' => 'form-control')) }}	
		            </div>
		            <div class="col-sm-3">
		            	{{ Form::label('desired_total_markup', 'Desired Markup: ', array('class' => 'control-label')) }}
			             {{ Form::text('desired_total_markup', (isset($input['desired_total_markup'])? Input::old('desired_total_markup') : (isset($desired_total_markup)? $desired_total_markup : '' )), array('class' => 'form-control', 'placeholder' => '350')) }}
		            </div>

		    </div>
            <hr/> 
            <div class="row">
            	
	            <div class="col-sm-3">
	            	<p class="input_title">Protein</p>
	                {{ Form::select('calc_p', (isset($calc_p)? $calc_p : 0 ), (isset($input['calc_p'])? Input::old('calc_p') : (isset($calc_p_set)? $calc_p_set : 0 )), array('class'=>'form-control')) }} 
	            </div>

	            <div class="col-sm-3">
	            	<p class="input_title">Base</p>
	                {{ Form::select('calc_b', (isset($calc_b)? $calc_b : 0 ), (isset($input['calc_b'])? Input::old('calc_b') : (isset($calc_b_set)? $calc_b_set : 0 )), array('class'=>'form-control')) }} 
	            </div>

	            <div class="col-sm-3">
	            	<p class="input_title">Side 1</p>
	                {{ Form::select('calc_s', (isset($calc_s)? $calc_s : 0 ), (isset($input['calc_s'])? Input::old('calc_s') : (isset($calc_s_set)? $calc_s_set : 0 )), array('class'=>'form-control')) }} 
	            </div>

	            <div class="col-sm-3">
	            	<p class="input_title">Topping</p>
	                {{ Form::select('calc_t', (isset($calc_t)? $calc_t : 0 ), (isset($input['calc_t'])? Input::old('calc_t') : (isset($calc_t_set)? $calc_t_set : 0 )), array('class'=>'form-control')) }} 
	            </div>
		    </div>   

		    <hr/>         	

	        <div class="row">

	        	<div class="col-sm-offset-1 col-sm-10">
			       	<table class="table table-striped">
			            <thead>
			            	<tr>
			                    <th>Protein</td>
			                    <th>Base</th>
			                    <th>Side 1</th>
			                    <th>Side 2</th>
			                    <th>Topping </th>
			                    <th>Cost</th>
			                    <th>Price</th>
			                    <th>Profit</th>
			                </tr>
			            </thead>


			            @if(isset($combos))
			            	@if($combos != 0)
		            			@foreach($combos as $combo)

						            <tbody>
							            <tr>
							                <td> {{ $combo[0] }} </td>
							                <td> {{ $combo[1] }} </td>
							                <td> {{ $combo[2] }} </td>
							                <td> {{ $combo[3] }} </td>
							                <td> {{ $combo[4] }} </td>

							                <td> {{ $combo[5] }} </td>
							                <td> {{ $combo[6] }} </td>
							                <td> {{ $combo[7] }} </td>
							            </tr>
						            </tbody>

					            @endforeach
					        @endif
			            @endif
			            <tfoot>
			            	<tr>
			                	<td colspan="20">
			                    	
			                    </td>
			               	</tr>
			            </tfoot>
			       	</table>
		        </div>	
			</div>
	        </div>
      </div>
            
            <div class="form-group {{ ($errors->has('extra')) ? 'has-error' : '' ; }}">
	           	{{ ($errors->has('extra'))? '<p>'. $errors->first('extra') .'</p>' : '' }}
            </div>
      </div>
      
    </div>
        
        	{{ Form::hidden('id', (isset($input['id'])? Input::old('id') : (isset($data->id)? $data->id : '' ))) }}
        	{{-- Form::hidden('sc', ( '10' )) --}}
            
            <hr/>
            
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
              {{ Form::submit('Save & Close', array('name' => 'sc','class' => 'btn btn-success')) }}
              <!-- <input type="submit" name="sc" id="1" value="Save & Close" class="btn btn-success"> -->
            <a href="/admin/menu/recipes/">
                {{ Form::button('Cancel' ,array('class' => 'btn btn-danger')) }}
            </a>
            </div>
        </div>
    {{ Form::close() }}
    	        	
  </div>

@stop


@section('_tail')

@stop