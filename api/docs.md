FORMAT: 1A

# PM API 1

# Group User
Modulo de usuarios

## Obtener usuarios [GET /users]


+ Response 200 (application/json)
    + Body

            {
                "id": "int",
                "name": "string",
                "email": "string"
            }

## Crear usuario [POST /users]


+ Request (application/json)
    + Body

            {
                "name": "string",
                "email": "string",
                "password": "string"
            }

+ Response 200 (application/json)
    + Body

            {
                "id": "int",
                "name": "string",
                "email": "string"
            }

+ Response 450 (application/json)
    + Body

            {
                "error": {
                    "message": "Faltan datos"
                }
            }

+ Response 451 (application/json)
    + Body

            {
                "error": {
                    "message": "Error al crear el usuario"
                }
            }

## Obtener usuarios [GET /users/{id}]


+ Parameters
    + id: (integer, required) - ID del usuario

+ Response 200 (application/json)
    + Body

            {
                "id": "int",
                "name": "string",
                "email": "string"
            }

## Editar usuario [PATCH /users/{id}]


+ Parameters
    + id: (integer, required) - ID del usuario

+ Request (application/json)
    + Body

            {
                "name": "string",
                "email": "string",
                "password": "string"
            }

+ Response 200 (application/json)
    + Body

            {
                "id": "int",
                "name": "string",
                "email": "string"
            }

+ Response 450 (application/json)
    + Body

            {
                "error": {
                    "message": "No existe el usuario"
                }
            }

+ Response 451 (application/json)
    + Body

            {
                "error": {
                    "message": "Error al editar el usuario"
                }
            }

+ Response 452 (application/json)
    + Body

            {
                "error": {
                    "message": "No envio ningun parametro para actualizar"
                }
            }

## Elimina un usuario [DELETE /users/{id}]


+ Parameters
    + id: (integer, required) - ID del usuario.

+ Response 204 (application/json)

+ Response 460 (application/json)
    + Body

            {
                "error": {
                    "message": "No existe la imagen que se quiere destruir"
                }
            }

## Obtener usuarios [GET /users/datatables]
Con formato listo para datatables con ajax

# Group Roles
Modulo de roles

## Obtener roles [GET /roles]


+ Response 200 (application/json)
    + Body

            {
                "id": "int",
                "name": "string"
            }