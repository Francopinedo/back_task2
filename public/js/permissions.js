var permission = (function() {
	'use strict';

	var permission = {
		init: function(){
			var self = this;

			$('.permission-checkbox').on('click', function(){
				var permission_id = $(this).data('permission_id');
				var role_id = $(this).data('role_id');
                var type = $(this).data('type');

				if ($(this).data('state') == 'checked') {
					$(this).data('state', '');
					self.deletePermissionRole(permission_id, role_id, type);
				}
				else{
					$(this).data('state', 'checked');
					self.addPermissionRole(permission_id, role_id, type);
				}

				self.showSpinner(permission_id, role_id);
			});


            $('.directory-checkbox').on('click', function(){
                var directory_id = $(this).data('directory_id');
                var role_id = $(this).data('role_id');
                var type = $(this).data('type');

                if ($(this).is(':checked')) {

                	console.log('checked');
                    self.addDirectoryRole(directory_id, role_id, type);
                }
                else{
                    console.log(' no checked');
                    self.deleteDirectoryRole(directory_id, role_id, type);
                }

            });

		},
		addPermissionRole: function(permission_id, role_id){
			var self = this;
			var data = {permission_id: permission_id, role_id: role_id};

			$.ajax({
		        url: API_PATH + 'permission_roles',
		        type: 'POST',
		        dataType: 'json',
		        data: data,
			    success : function ( json )
			    {
			        self.hideSpinner(permission_id, role_id);
			    },
			    error: function( json )
			    {
			        console.log('fallo');
			    }
		    });
		},
		deletePermissionRole: function(permission_id, role_id){
			var self = this;
			$.ajax({
		        url: API_PATH + 'permission_roles/' + permission_id + '/' + role_id,
		        type: 'DELETE',
		        dataType: 'json',
			    success : function ( json )
			    {
			        self.hideSpinner(permission_id, role_id);
			    },
			    error: function( json )
			    {
			        console.log('fallo');
			    }
		    });
		},

        addDirectoryRole: function(permission_id, role_id, type){
            var self = this;
            var data = {permission_id: permission_id, role_id: role_id, type:type};

            $.ajax({
                url: API_PATH + 'directory_roles',
                type: 'POST',
                dataType: 'json',
                data: data,
                success : function ( json )
                {
                    self.hideSpinner(permission_id, role_id);
                },
                error: function( json )
                {
                    console.log('fallo');
                }
            });
        },

        deleteDirectoryRole: function(permission_id, role_id, type){
            var self = this;
            $.ajax({
                url: API_PATH + 'directory_roles/' + permission_id + '/' + role_id+'/'+type,
                type: 'PATCH',
                dataType: 'json',
                success : function ( json )
                {
                    self.hideSpinner(permission_id, role_id);
                },
                error: function( json )
                {
                    console.log('fallo');
                }
            });
        },
		showSpinner: function(permission_id, role_id){
			$("*[data-permission_id='"+permission_id+"'][data-role_id='"+role_id+"']").show();
		},
		hideSpinner: function(permission_id, role_id){
			$("*[data-permission_id='"+permission_id+"'][data-role_id='"+role_id+"']").hide();
		}
	};

	return permission;
}());