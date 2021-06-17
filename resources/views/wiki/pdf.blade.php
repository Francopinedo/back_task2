<!DOCTYPE html>
<html>
<head>
	<style>
		body {
      font-family: Helvetica;
      font-size: 14px;
  	}

    p {
    	font-size: 13px !important;
    	margin-top: 8px;
    }

    ul {
    	padding-left: 0px;
    	list-style: none;
    }
    
    li.item{
    	padding-top: 10px;
    	width: 100%;
    }
    header{width: 100%;}
    article img { width: 95%; height: 95%; padding-top: 14px; }
    header li { list-style: none; }
    footer, hr { clear: both; }

    section {
    	width: 100%;
    	height: 350px;
    }
    section aside {
    	float: left;
    	width: 50%;
    	height: auto;
    }

    section article {
    	float: right;
    	width: 50%;
    	height: auto;
    }
    
	</style>
</head>
	<body>
		
		<!-- Encabezado -->
		<header>
			<h3>{{ __('wiki.wiki_data') }}</h3>
		</header>

		<hr>
		<!-- Datos -->
		<section>
			<aside>
				<ul>
					<li class="item">
						<strong>{{__('wiki.customer_code')}}</strong><br>
						<span>{{ $customer->name }}</span>
					</li>
					<li class="item">
						<strong>{{ __('wiki.project_code') }}</strong><br>
						<span>{{ $project->name }}</span>
					</li>

					<li class="item">
						<strong>{{ __('wiki.project_manager') }}</strong><br>
						<span>{{ $project_manager->name }}</span>
					</li>
					<li class="item">
						<strong>{{ __('wiki.project_mail') }}</strong><br>
						<span>{{ $project_manager->email }}</span>
					</li>
					<li class="item">
						<strong>{{ __('wiki.office_phone') }}</strong><br>
						<span>{{ $project_manager->office_phone }}</span>
					</li>

					<li class="item">
						<strong>{{ __('wiki.process_group_code') }}</strong><br>
						<span>{{ $wiki->process_group_code }}</span>
					</li>
					<li class="item">
						<strong>{{ __('wiki.knowledge_code') }}</strong><br>
						<span>{{ $wiki->knowledge_code }}</span>
					</li>
					<li class="item">
						<strong>{{ __('wiki.swot_code') }}</strong><br>
						<span>{{ $wiki->swot_code }}</span>
					</li>
				</ul>
			</aside>
			<!-- Imagen Agregada si no lo hay mostrara una por defecto -->
			<article>
				@if (empty($wiki->attached_file) || $wiki->attached_file=='')
					<img alt="logo" id="attached_file" src="{{ URL::to('/') }}/assets/img/avatardefault.png">
				@else
					<img src="{{ URL::to('/') .'/assets/img/wiki/'. $wiki->id .'/'. $wiki->attached_file }}" alt="" >
				@endif
			</article>
		</section>
	
		<hr>
		<!-- Detalles de Informacion -->
		<footer>
			<ul>
				<li class="item">
					<strong>{{ __('wiki.explanation') }}</strong>
					<p>{{ $wiki->explanation }}</p>
				</li>
				<li class="item">
					<strong>{{ __('wiki.action_taken') }}</strong><br>
					<p>{{ $wiki->action_taken }}</p>
				</li>
				<li class="item">
					<strong>{{ __('wiki.additionals_comments') }}</strong><br>
					<p>{{ $wiki->additionals_comments }}</p>
				</li>
			</ul>
		</footer>

	</body>
</html>