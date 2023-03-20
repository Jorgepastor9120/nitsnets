## Prueba NITSNETS

El proyecto consta de dos partes:
- Front: Realizado con Breeze, Blade y TailwindCss (con la biblioteca de componentes de Flowbite).
*Nota del front: Para la lógica de negocio en la reserva de pista he optado por usar selects dinámicos junto con el plugin de JQuery select2 para tener buscadores en los selects. Según la fecha seleccionada se muestran los horarios disponibles para la pista seleccionada.
-
- Api Rest: Documentada con Swagger. La documentación se puede ver en http://127.0.0.1:8000/api/documentation o en storage\api-docs\api-docs.json

## Ejecución del proyecto

Para ejecutar el proyecto se deben seguir los siguientes pasos:

Tener un servidor APACHE levantado en el puerto 80 junto con el servicio de MySQL en el puerto 3306 (http://localhost/phpmyadmin).

1. Ejecutar los siguientes comandos en la ruta del proyecto:

```php run serve``` para levantar el servidor.

```npm run dev``` para compilar el front.

2. Acceder a http://127.0.0.1:8000/api/documentation y registrarte desde la sección Auth.

3. Ingresar los datos de registro mas el cliente UUID para autenticarte.

Cliente UUID:

ID: 98af4be4-c5f9-441a-b2c9-8b85f688894f

Secret: 8wuym6zIsoUYZdQZSW4GNedDpr09L0Eyb6t2QHxH
