var favorite = (function() {
	'use strict';

	var favorite = {
		/*============================
		=            init            =
		============================*/
		init: function(){
			var self = this;

			$('#favoriteLink').on('click', function(e){
				e.preventDefault();

				// cambio el icono que tenga por el icono de spinner
				if ($(this).hasClass('fa-star') || $(this).hasClass('fa-star-o')) {
					$('#favoriteLink i').removeClass('fa-star-o');
					$('#favoriteLink i').removeClass('fa-star');
				}else{
					$('#favoriteLink i').addClass('fa-spinner');
					$('#favoriteLink i').addClass('fa-fw');
				}

				// si la estrella esta llena entonces remuevo el favorito al hacer click
				if ($('#favoriteLink i').hasClass('fa-star')) {
					console.log('remove');
					self.removeFavorite($('#favoriteLink').data('favorite-url'), user_id);
				}else{ // si la estrella esta vacia entonces agrego el favorito al hacer click
					console.log('add');
					self.addFavorite($('#favoriteLink').data('favorite-title'), $('#favoriteLink').data('favorite-url'), user_id);
				}

			});

			if ($('#favoriteLink').length) {
				//self.checkFavorite($('#favoriteLink').data('favorite-url'), user_id);
			}
		},
		/*===================================
		=            addFavorite            =
		===================================*/
		addFavorite: function(title, url = 0, user, order = 0){

			var self = this;

			var data = {
				title: title,
				user_id: user
			};

			if (typeof url !== 'undefined') {
				data.url = url;
			}

			if (typeof order !== 'undefined') {
				data.order = order;
			}

			$.ajax({
		        url: API_PATH + 'favorites',
		        type: 'POST',
		        dataType: 'json',
		        data: data
		    }).done(
		        function(data){
		        	self.fillStar();
		        }
		    );
		},
		/*================================
		=            fillStar            =
		================================*/
		fillStar: function(){
			if ($('#favoriteLink').length) {
				$('#favoriteLink i').removeClass('fa-star-o');
				$('#favoriteLink i').removeClass('fa-spinner');
				$('#favoriteLink i').removeClass('fa-fw');
				$('#favoriteLink i').addClass('fa-star');
			}
		},
		/*=================================
		=            emptyStar            =
		=================================*/
		emptyStar: function(){
			if ($('#favoriteLink').length) {
				$('#favoriteLink i').removeClass('fa-star');
				$('#favoriteLink i').removeClass('fa-spinner');
				$('#favoriteLink i').removeClass('fa-fw');
				$('#favoriteLink i').addClass('fa-star-o');
			}
		},
		/*======================================
		=            removeFavorite            =
		======================================*/
		removeFavorite: function(url, user_id){

			var self = this;

			$.ajax({
		        url: API_PATH + 'favorites?url=' + url + '&user_id=' + user_id,
		        type: 'DELETE',
		        dataType: 'json'
		    }).done(
		        function(data){
		        	self.emptyStar();
		        }
		    );
		},
		/*=====================================
		=            checkFavorite            =
		=====================================*/
		checkFavorite: function(url, user){
			var self = this;

			var data = {
				url: url,
				user_id: user
			};

			$.ajax({
		        url: API_PATH + 'favorites/check',
		        type: 'GET',
		        dataType: 'json',
		        data: data
		    }).done(
		        function(data){
		        	self.fillStar();
		        }
		    );
		},
		/*======================================
		=            Reload Sidebar            =
		======================================*/
		reloadSidebar: function(){

		}




	};

	return favorite;
}());