## Problema actual
- En `resources/views/pacientes/index.blade.php:159` el atributo `data-searchable` usa variables de mascota, lo que impide filtrar correctamente en la tabla de personas.

## Cambio propuesto
- Actualizar el `data-searchable` de cada fila para concatenar los campos del paciente relevantes al filtro: `dui`, `nombre`, `apellido`, `edad`, `sexo`, `celular`, `correo`, `direccion`.

## Modificación exacta
- Reemplazar la línea en `resources/views/pacientes/index.blade.php:159` por:
```
<tr class="table-row hover:bg-blue-50" data-searchable="{{ $paciente->dui }} {{ $paciente->nombre }} {{ $paciente->apellido }} {{ $paciente->edad }} {{ $paciente->sexo }} {{ $paciente->celular }} {{ $paciente->correo }} {{ $paciente->direccion }}">
```

## Verificación
- Escribir términos como `12345678-9` (DUI), nombre, apellido, `masculino`/`femenino`, teléfono, correo o parte de la dirección y confirmar que las filas se muestran/ocultan correctamente.
- Probar limpiar con el botón y con `Escape` y verificar que reaparecen todas las filas.
- Introducir un término inexistente y confirmar la fila de “No se encontraron resultados”.

## Alcance
- No se tocan los scripts (`filterTable`, `clearSearch`) ni el marcado adicional; solo se corrige el `data-searchable` para que el filtro funcione sobre personas.