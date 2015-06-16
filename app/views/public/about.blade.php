@extends('tmpl.public')

@section('__header') 
@stop  

@section('content')   
<div class="band page">
	<nav class=" subnav subnav--centre">
	    <h2 class="content__title--main"><a class="plain__header__link" href="/">Introducing Tom & Sarah</a></h2>
	</nav>
	<div class="container row"> <!--Sign up section--> 
		<section class="content__page--sub"> 
			<section class="columns columns small-12 medium-12 large-6 large xlarge-8">
				<section class="section__box section__box--content">
                    <div class="fluid-wrapper">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/KCiBIMu6-Mw" frameborder="0" allowfullscreen></iframe>
                    </div>
                </section>
				<div class="section section--form" >
					<h3 class="content__title--main">Welcome to Fed Up Project</h3>
					<p class="content__sub__heading">We are passionate about health education, we aim to use the Fed Up Project cafe as a platform to inspire and feed you with delicious health based food</p>
					<ul class="promo__list__ul">
						<li class="promo__list">Join today for free!! </li>
						<li class="promo__list">Be the first to know when Fed Up Project launches!</li>
						<li class="promo__list">Receive the latest news and updates about Fed Up Project</li>
						<li class="promo__list">Get early bird discounts to all future events & cafe dishes</li>
						<li class="promo__list">Access free eBooks & get involved in our health discussions</li>
					</ul>
					<div class="about__join">
						<a href="/signup"><img src="/images/selection/join.png" alt="Today's Menu"/></a>
					</div>
					
				</div>
			</section>
			<section class="columns small-12 medium-12 large-6 large-pull-0 xlarge-4">
				<div class="section section--form" >
				  	<h2><b>Who are we</b></h2>
				  	<p>Owners Sarah & Tom are from the Gippsland, they are aspiring to share their love for food & passion for health with the community.</p>
				  	<br/>
				  	<p>Sarah has recently finished a Prep to Year 12 Bachelor of Education degree. While in her first year of teaching Sarah observed that 
				  	the students were either falling asleep after lunch or bouncing off the tables. This pushed Sarah away from teaching
				  	to uncover the root cause of this issue. Having grown up around food & understanding the vital role it plays 
				  	on our emotions. Sarah soon discovered the importance of nutritents needed in our childrens lives, & began developing 
				  	recipes to meet the needs of her students nutrition & cognitive needs.</p>
				  	<br/>
				  	<p>Tom has just finished his Integrated Marketing degree, brought about by his passion to unite health & fitness education. 
				  	Ever since Tom started doing personal training, he has had a thirst to explore new ways of educating more people at one time.
				  	During university Tom taught himself programming to engage with online media and increase his message awareness.</p>
				  	<br/>
				  	<p>It was about this time that Tom & Sarah met, Sarah was designing delicious treats for students & Tom was building online 
				  	platforms to share health & fitness education. Thus gave way to <a href="http://www.sonaughtybutnice.com">SoNaughtyButNice.com</a>,
				  	an online plaform jammed pack full of Delicious Healthy Dessert recipes built on the foundation of education about th benefits of each ingredient.</p>
				  	<p>This quickly turned into a business & a year later they have out grown their current kitchen & now have settled into Selection Cafe</p>

				</div>
			</section>
			
			<div class="footer__push"></div>
		</section>
	</div>
</div> 

@stop