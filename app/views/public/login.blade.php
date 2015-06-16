@extends('tmpl.public')

@section('__header') 
@stop  

@section('content')   
<div class="band page">
    <nav class=" subnav subnav--centre" data-tab data-options="deep_linking:true; scroll_to_content: false">
        <h2 class="content__title--main"><a class="plain__header__link" href="/">Login</a></h2>
    </nav>
    <!-- <h2 class="content__title content__title--main"><a class="content__title--link" href="/profile">Login</a></h2> -->
    <div class="container row section__login"> <!--Sign up section-->
        <section class="content__page--sub"> 
            <section class="columns small-12 medium-8 medium-push-2 large-8 large-push-2 xlarge-6 xlarge-push-3">
                <div class="section section--form" >
                    {{ Form::open(array('action' => 'AuthController@postLogin', 'class' => 'form-horizontal')) }}  
                    	<h2 class="content__title--login">Please Login</h2>    
                        <div class="form__input--side--login">
                            {{ Form::label('email', 'Email: ', array('class' => 'content-title--sub')) }}
                            {{ Form::email('email', '', array('placeholder' => ($errors->has('email'))? $errors->first('email') : '', 'class'=>'input__text input__text--login' ) ) }}
                        </div>
                        <div class="form__input--side--login">
                          {{ Form::label('password', 'Password: ', array('class' => 'content-title--sub')) }}
                          {{ Form::password('password', array('placeholder' => ($errors->has('password'))? $errors->first('password') : '', 'class'=>'input__text input__text--login' ) ) }}
                        </div>
                        <a href="/">
                            {{ Form::button('Cancel' ,array('class' => 'form__button--cancel')) }}
                        </a>
                        {{ Form::submit('Login', array('class' => 'form__button--login')) }}

                    {{ Form::close() }}
                </div>
            </section>
        </section>
    </div>
</div>

@stop 