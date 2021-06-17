<style>
	#contenedor-download {
		margin: 20px;
		padding: 15px;
	}
	div.uk-card {
		padding-top: 10px;
		padding-bottom: 10px;
		text-align: center;
	}
	input#reason {
		width: 75%;
		border-bottom: 1px solid rgb(130, 130, 130);
	}
	#download-dato, #comment-dato, .uk-modal-close {
		margin-top: 10px;
		padding: 10px;
	}
	#accept, #idproject, #title-confirm, #notification, #project, #leave, #success {
		display: none;
	}
	div.button-group {
		display: flex;
		flex-direction: row;
		justify-content: center;
		align-items: center;
	}
	
	.continue, #accept, #leave {
		margin-top: 10px;
		padding: 10px;
	}

</style>
<div class="uk-card uk-card" style="margin: 5px;">

    <div id="contenedor-download">
    	<!-- Formulario para cargar la razon por la que se elimina el dato -->
    	<form id="form-reason" method="POST" action="{{ url('projects/delete') }}">
	    	<h4 class="uk-modal-title">{{ __('general.reason') }}</h4>
	    	{{ csrf_field() }}
    		<div class="md-input-wrapper">	
            	<input type="number" class="md-input" id="idproject" name="id" value="{{$project->id}}">
	    		<input type="text" name="reason" id="reason" min="5" placeholder="porque estas eliminando">
	    		<!-- <textarea class="uk-textarea" cols="40" rows="4" name="reason" id="reason" min="4" placeholder="{{ __('general.reason_action') }}"></textarea> -->
            	<span class="md-input-bar"></span>
            </div>
    	</form>
 
    	<!-- Formulario para descargar el backup.zip del project -->
    	<h4 id="title-confirm" class="uk-modal-title">{{ __('general.confirm') }}</h4>
    	<p id="notification">{{ __('general.message') }}</p>

	    <form id="form-download" method="POST" action="{{ url('projects/download') }}">
	    	{{ csrf_field() }}
	    	<input type="number" name="id" id="project" max="25" value="{{$project->id}}">
	    	
	    </form>

	    <h3 id="success">{{ __('general.success') }}</h3>
	    <!-- Botones para hacer envio de datos -->
		    <div class="button-group">
		    	<button type="button" class="js-modal-confirm-cancel md-btn md-btn-flat uk-modal-close">{{ __('general.cancel') }}</button>
		    	<button type="button" class="md-btn md-btn-flat continue" disabled>{{ __('general.continue') }}</button> <!-- boton para continuar -->
		    	<button type="button" id="accept" class="md-btn md-btn-flat">{{ __('general.accept') }}</button>
		    	<button type="button" id="leave" class=" md-btn md-btn-flat">{{ __('general.leave') }}</button><!-- Boton enviar datos -->
		    	
		    </div>
	    
    </div>  
</div>

	<script>

	$(document).ready(function(){
       	$('.uk-modal-footer').hide();
		//Obteniendo la razon y validar que tenga un minimo de caractares de 25
		$('#reason').keypress(function(event){
			
			var input = $('#reason').val();
			if(input.length > 25) {
				$('.continue').attr('disabled', false); // habilita el boton continuar

				$('button.continue').click(function(){
					$(this).hide();
					$('#form-reason').hide();
					$('#title-confirm, #notification, #accept').show();
				});

				// Enviar el formulario downloar para descargar el archivo backup.zip
				$('#accept').click(function(){
					$('#form-download').submit(); // Envio de formulario para descargar zip 
					if('{{ $project->status }}' == 'Closing') { // Validacion del dato si esta activo o no para proceder a
						$('#title-confirm, #notification, #accept, .uk-modal-close').hide();
						$('#success, #leave').show();
					}
				});
				// 
		        $('#leave').click(function(){
		            $('#form-reason').submit();
		        });

			}else{
				$('.continue').attr('disabled', true);
			}
		});

	});	

	</script>
