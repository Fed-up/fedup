@extends('tmpl.admin')

@section('title'){{ $title }} @stop

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
    
 
    
    
    
     //Start all Recipes 
      
    //Start Delete Recipe
    $('#counterRecipes').val( $('#_PackageRecipes li').length );

    $('.deleteRecipe').click(function(e) {
      e.preventDefault();
      var currentID = (this.id);
      if($("#ddi" + currentID).length == 0) {
        $('#_PackageRecipes')
            .append( $('<input>',{
              'type':'hidden',
              'name':'ddi[]',
              'id':'ddi'+currentID, /*ddi = delete data recipe*/
              'class':'form-control',
              'value':''+currentID,
            }) )
        ;
        $(this).parent('li').hide().unbind('click');       
      } else {
      //alert('this record already exists');
        $("#ddi" + currentID).closest('input').remove().unbind('click');
      }
    });
    
    //Start Recipes
    $('#counterRecipes').val( $('#_PackageRecipes li').length );
    $('#btnActionAddRecipes').click(function(e) {
      e.preventDefault();
      
      var currentID = $('#counterRecipes').val();
      
      var recipesArray = [];
      <?php
      
      $ix = 0;
      foreach ($recipes as $i=>$v) {
        echo 'recipesArray['.$ix.'] = ["'.$i.'","'.$v.'"]'."\n";
        $ix++;
      }; 

      ?>
      
      var SelectList  = $('<select>',{
            'name':'recipes[][x]',
            'id':'recipes_'+currentID,
            'class':'form-control',
          });
      
      $.each(recipesArray, function(key,value) {
        SelectList
          .append($('<option></option>')
          .attr('value',value[0])
          .text(value[1])); 
      });
      
      
      
      var deleteButton  = $('<button>',{
                    'class':'glyphicon glyphicon-remove btn btn-danger'
                  });
      deleteButton.bind('click', function(e){
        e.preventDefault();
        $(this).parent('li').remove().unbind('click');
      });
      
      $('#_PackageRecipes')
        .append( $('<li>') 
        
          .append( SelectList )
          .append( '&nbsp;' )
          .append( $('<input>',{
            'name':'amount[][x]',
            'id':'amount_'+currentID,
            'class':'form-control-amount form-control',
          }) )

          .append( deleteButton )
          .append( '&nbsp;' )
          .append( $('<span>',{
            'class':'glyphicon glyphicon-sort btn btn-default disabled'
          }) )
          
        )
      ;
      
      $('#counterRecipes').val( parseInt(currentID, 10) + 1 );
      
    });
    
    






    
    
    
      //Start Images
    $('#counterImages').val( $('#_ListImages li').length );
    //Delete extra
    $('.deleteImage').click(function(e) {
      e.preventDefault();
      
      var currentID = (this.id);
      
      //var currentID = 0;  
          
      var currentID = (this.id);
          
      if($("#ddp" + currentID).length == 0) {
        $('#_ListImages')
          
            .append( $('<input>',{
              'type':'hidden',
              'name':'ddp[]',
              'id':'ddp'+currentID, /*ddi = delete data ingredient*/
              'class':'form-control',
              'value':''+currentID,
            }) )
        ;
        $(this).closest('li').hide().unbind('click');
        
      } else {
      //alert('this record already exists');
        $("#ddp" + currentID).closest('input').remove().unbind('click');
      }
      
      
      
    });
   // Initialize the widget when the DOM is ready
   var uploader = new plupload.Uploader({
      runtimes : 'html5,flash,silverlight,html4',
      browse_button : 'pickfiles', // you can pass in id...
      container: document.getElementById('container'), // ... or DOM Element itself
      url : '/admin/upload',
      flash_swf_url : '/packages/jquery-1.11.1.min/vendor/jquery-ui-1.10.4.custom/js/Moxie.swf',
      silverlight_xap_url : '/packages/jquery-1.11.1.min/vendor/jquery-ui-1.10.4.custom/js/Moxie.xap',
      
      filters : {
        max_file_size : '200mb',
        mime_types: [
          {title : "Image files", extensions : "jpg,jpeg"},
        ]
      },
      //chunk_size: '200kb',
      resize: {
        width: 500,
        height: 500,
        quality: 90,
        crop: true,
      },
      multiple_queues: true,
      unique_names: true,
      
      init: {
        PostInit: function() {
          $('#console').hide();
          $('#filelist').html('');//Injecting an empty string
          $('#uploadfiles').click(function() {
            uploader.start();
            return false;
          });
        },
        FilesAdded: function(up, files) {
          var _files = '';
          plupload.each(files, function(file) {
            _files += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
            });
          $('#filelist').html( _files );
        },
        UploadProgress: function(up, file) {
          $('#'+file.id+' b').html('<span>' + file.percent + '%</span>');
        },
        UploadComplete: function(up, files) {
          var upload_files = '';
          var fullLength = files.length;
          var setcount = 0;
          plupload.each(files, function(upload){
            var deleteButtonImages  = $('<a>',{
              'class':'glyphicon glyphicon-remove btn btn-danger'
            });
            deleteButtonImages.bind('click', function(e){
              e.preventDefault();
              alert('delete');
              $(this).closest('li').remove().unbind('click');
            });
          
            
            $('#_ListImages')
              .append ( $('<li>', {
                'class': 'row'                
                })
                  .append( $('<img>', {
                    'class':'col-sm-1',
                    'src': '/uploads/' + upload.target_name 
                  }))
                  .append( $('<div>', {
                    'class':'col-sm-8'
                  })
                    .append( $('<input>', {
                      'class':'form-control',
                      'type':'hidden',
                      'name':'images[][x]',
                      'value':'' + upload.target_name 
                    }))
                    .append( $('<input>', {
                      'class':'form-control',
                      'type':'text',
                      'name':'img_des[][x]',
                      'value':'',
                    }))
                    .append( '&nbsp;' )
    
                    .append( deleteButtonImages )
                    
                    .append( '&nbsp;' )
                    .append( $('<span>',{
                      'class':'glyphicon glyphicon-sort btn btn-default disabled'
                    }) )
                  )
                )
              ;
              
            
              
              
          });
          
          for(setcount=0; setcount<fullLength; setcount++){
            console.log(files);
            uploader.splice(setcount, 1);
            console.log(files);
          }
          
          
          //uploader.splice(); 
          
        },
        
      

        Error: function(up, err) {
          $('#console').html("Error #" + err.code + ": " + err.message+"\n").show();
        },
      }
    });
    uploader.init(
      
    );
    

    
  });

    </script>
@stop

@section('content')
  <div class="row">
    <h1 class="page-header">@yield('title')</h1>
    @if(isset($data->id))
      {{ Form::open(array('action' => 'Admin_PackagesController@postUpdatePackages', 'class' => 'form-horizontal')) }} 
    @else
      {{ Form::open(array('action' => 'Admin_PackagesController@postAddPackages', 'class' => 'form-horizontal')) }} 
    @endif
    <ul id="myTab" class="nav nav-tabs">
      <li class="active"><a href="#info" data-toggle="tab">Info</a></li>
      <li><a href="#recipes" data-toggle="tab">Recipes</a></li>
      <li><a href="#image" data-toggle="tab">Images</a></li>
    </ul>
    
    <div id="myTabContent" class="tab-content">
    
      <div class="tab-pane fade in active" id="info"> 
        <div class="form-group {{ ($errors->has('name')) ? ' has-error' : '' ; }}">
            {{ Form::label('name', 'Name: ', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-sm-10">
               {{($errors->has('name')) ? '<p>'. $errors->first('name'). '</p>' : '' }}
               {{ Form::text('name', (isset($input['name'])? Input::old('name') : (isset($data->name)? $data->name : '' )), array('class' => 'form-control')) }}
             
            </div>
        </div>
        <div class="form-group {{ ($errors->has('summary')) ? ' has-error' : '' ; }}">
            {{ Form::label('summary', 'Summary: ', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-sm-10">
               {{($errors->has('summary')) ? '<p>'. $errors->first('summary'). '</p>' : '' }}
               {{ Form::textarea('summary', (isset($input['summary'])? Input::old('summary') : (isset($data->summary)? $data->summary : '' )), array('class' => 'form-control', 'rows' => '2')) }}
            </div>
        </div>
        <div class="form-group }}">
          {{ Form::label('user_type', 'Package Type: ', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-sm-3">

                {{ Form::select('package_type', 
                    array('CORPORATE' => 'Corporate',
                        'EVENT' => 'Event',
                        'FUNCTION' => 'Function', 
                        'PARTY' => 'Party'), (isset($input['package_type'])? Input::old('package_type') : (isset($data->package_type)? $data->package_type : null )), array('class'=>'form-control')) }} 
            </div>
        </div>
        <div class="form-group {{ ($errors->has('quantity')) ? ' has-error' : '' ; }}">
            {{ Form::label('quantity', 'Quantity: ', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-sm-3">
               {{($errors->has('quantity')) ? '<p>'. $errors->first('quantity'). '</p>' : '' }}
               {{ Form::text('quantity', (isset($input['quantity'])? Input::old('quantity') : (isset($data->quantity)? $data->quantity : '' )), array('class' => 'form-control', 'placeholder' => 'Calculated Automatically')) }}
             
            </div>
        </div>
        <div class="form-group {{ ($errors->has('price')) ? ' has-error' : '' ; }}">
            {{ Form::label('price', 'Price: ', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-sm-3">
               {{($errors->has('price')) ? '<p>'. $errors->first('price'). '</p>' : '' }}
               {{ Form::text('price', (isset($input['price'])? Input::old('price') : (isset($data->price)? $data->price : '' )), array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('active', 'Active: ', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-sm-10">
               {{ Form::checkbox('active', 1, (isset($input['active']) ? Input::old('active') : (isset($data->active)? $data->active : '' )), array('class' => '')) }}
            </div>
        </div>
           {{ Form::hidden('id', (isset($input['id'])? Input::old('id') : (isset($data->id)? $data->id : '' ))) }}
       </div>

       <div class="tab-pane fade in" id="recipes">
          <div class="col-sm-1">
              {{-- Form::button('+ Add', array('id' => 'btnActionAddRecipes','class' => 'btn btn-primary')) --}}
              <a href="#" id="btnActionAddRecipes" class="btn btn-primary">+ Add</a>
              {{ Form::hidden('counterRecipes',null,array('id'=>'counterRecipes')) }} 

          </div>
          <hr/>
          <div class="form-group {{ ($errors->has('recipes')) ? 'has-error' : '' ; }}">
              {{ ($errors->has('recipes'))? '<p>'. $errors->first('recipes') .'</p>' : '' }}
              <ul id="_PackageRecipes" class="_mySortable">
                <?php $x = 0; ?>
                  @if(isset($catering_recipes))
                    @foreach($catering_recipes as $c_recipe)
                         <li>
                                <select name="recipes[][{{ $c_recipe->pivot->id }}]" id="recipes_{{ $x }}" class="form-control"/>
                                    @foreach($recipes as $i=>$v)                                    
                                    <option value="{{ $i }}" @if ($c_recipe->pivot->menu_recipes_id == $i) selected="selected" @endif >{{ $v }}</option>
                                    @endforeach
                                    
                                </select>
                                
                                  <input name="amount[][{{ $c_recipe->pivot->id }}]" id="recipes_{{ $x }}" class="form-control-amount form-control" value="{{ $c_recipe->pivot->amount }}" />
                              
                                <input type="hidden" name="catering_recipe_pivot_id" value="{{($c_recipe->pivot->id);}}" />
                                <button id="{{ $c_recipe->pivot->id  }}" class="deleteRecipe glyphicon glyphicon-remove btn btn-danger"></button>
                                <span class="glyphicon glyphicon-sort btn btn-default disabled"></span>
                                
                          </li>
                      <?php $x++; ?>  
                     
                    @endforeach
                  @endif
            </ul>
          </div>
      </div>

      <div class="tab-pane fade in" id="image">
        <br/>
          <div id="filelist">
          Your browser doesn't have Flash, Silverlight or HTML5 support.

          </div>
          <div id="container">
            <a id="pickfiles" href="javascript:;">[Select files]</a> 
            <a id="uploadfiles" href="javascript:;">[Upload files]</a>
          </div>
        <hr><br/>
          <div id="database_list">
            <ul id="_ListImages" class="_mySortable">
            <?php $x = 0; ?>
              @if(isset($c_images))                 
                @foreach($c_images as $image)
                  <li class="row">
                      <img class="col-sm-1" src="/uploads/{{ $image->name }}">
                      <div class="col-sm-8">
                          <input type="hidden" name="images[][{{ $image->id }}]" id="images_{{ $x }}" class="form-control" value="{{ $image->name }}" />
                          <input name="img_des[][{{ $image->id }}]" id="images_{{ $x }}" class="form-control" value="{{ $image->summary }}" />
                          <button id="{{ $image->id }}" class="deleteImage glyphicon glyphicon-remove btn btn-danger"></button>&nbsp;
                          <span class="glyphicon glyphicon-sort btn btn-default disabled"></span>
                      </div>
                  </li>
                <?php $x++; ?>                       
                @endforeach
              @endif
            </ul>
          </div>
          <br />
          <pre id="console"></pre>
        </div>
        <hr/>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              {{ Form::submit('Save', array('class' => 'btn btn-success')) }}
            <a href="/admin/products/catering/packages">
                {{ Form::button('Cancel' ,array('class' => 'btn btn-danger')) }}
            </a>
            </div>
        </div>        
      </div>

@stop

@section('_tail')
@stop