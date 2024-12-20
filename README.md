# TPEspecialEntrega3
**Alumnes:**
+ Saffarano, Tomas Alfredo.
+ Lopez Vilaclara, Milagros.

# Listado de supermercado
Aquí se presenta un listado de productos con sus correspondientes categorías, la cual se renderiza del lado del servidor.

### Importante
Desde la última entrega, se modificó la DB al agregar un nuevo campo en la tabla `productos` llamado `oferta`. La razón de esto se debe a la intención de permitir un filtro como se sugiere en el TPE 3.

## Tabla de ruteo (endpoints):
+ `./productos`: Utiliza el verbo 'GET', para invocar a todos los productos sin filtros.
+ `./productos/:id`: Utiliza el verbo 'GET'. Invoca un producto específico por su ID.
+ `./productos/categoria/:id_cat`: Utiliza el verbo 'GET'. Invoca los productos pertenecientes a la categoria solicitada por ID.
+ `./categorias`: Utiliza el verbo 'GET'. Invoca a todas las categorias.
+ `./categorias/:id`: Utiliza el verbo 'GET'. Invoca una categoria epecífica por su ID.
+ `./productos/:id`: Utiliza el verbo 'DELETE'. Elimina un producto específico por su ID.
+ `./productos`: Utiliza el verbo 'POST'. Crea un producto nuevo.
    + JSON
    {
        "id_producto":12,
        "nombre_producto":"Prueba 2 API",
        "precio_producto":99,
        "oferta":1,
        "id_categoria":1
    }    
+ `./productos/:id`: Utiliza el verbo 'PUT'. Modifica un producto específico por su ID.
    + JSON
    {
        "nombre_producto":"Prueba 3.1 API",
        "precio_producto":99,
        "oferta":1,
        "id_categoria":1
    }

**Query Params (filtros y orden)**
+ `./productos?ofertas=false`: Utiliza el verbo 'GET', para invocar a todos los productos que no estén en oferta. 
+ `./productos?ofertas=false`: Invoca todos los productos que estén en oferta. 
+ `./productos?orderBy=categoria`: Utiliza el verbo 'GET', para invocar a todos los productos sin filtro, pero cambia el orden del view. Ordena de manera ascendente según el id de la categoría a la que pertenece.
+ `./productos?orderBy=categoria_desc`: Ordena de manera descendente según el id de la categoría a la que pertenece.
+ `./productos?orderBy=precio`: Ordena de manera ascendente según el precio del producto.
+ `./productos?orderBy=precio_desc`: Ordena de manera descendente según el precio del producto.