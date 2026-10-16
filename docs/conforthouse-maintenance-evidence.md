# ConfortHouse — API privada de mantenimiento para Red-Byte (REV1)

**Estado:** desarrollo local, rama PR #9. Sin merge, despliegue ni activación en IONOS.

**Responsabilidad:** ConfortHouse expone estadísticas técnicas agregadas. Red-Byte las
recupera por API junto con UptimeRobot e intervenciones documentadas, entrega las
evidencias consolidadas a Dot, y recibe de Dot un borrador para `ReportDraftService`.
**Este JSON es evidencia técnica, no un informe importable.** No incluye SEO/SEM/Growth.

## Contrato común v1

La salida adopta el contrato base también utilizado en Next Level:

- `schema_version: redbyte.maintenance-evidence.v1`
- `client: conforthouse`
- `collected_at_utc`
- `window: {start, end, timezone, inclusive, kind}` (zona `Europe/Madrid`)
- `snapshot`: información observada al ejecutar el recolector; puede variar respecto al cierre.
- `activity`: recuentos agregados que se pueden recuperar de archivos existentes.
- `external_sources`: fuentes que debe consultar por separado Red-Byte.
- `limitations`: límites de cobertura que Dot **debe** respetar.

### Datos exclusivos de ConfortHouse

**Snapshot**: conexión de BD con `SELECT 1`; recuentos de propiedades vigentes,
retiradas lógicamente y destacadas, con distribución por operación; últimos datos
almacenados en caché sobre Inmovilla; tamaño/fecha de actualización del log actual;
espacio del filesystem compartido observado en ese momento (no equivale a cuota IONOS).

**Actividad**: antispam leído de `storage/app/spam_stats.json` por meses *calendario*;
log de Laravel, recuentos de severidad dentro de los días locales de Madrid (conversión desde zona horaria Laravel y ajuste horario de verano), sin
exportar el texto de mensajes. Los logs rotados no se incluyen; un log mayor a
250 MiB **no se escanea**. Ni cuentas IPs personales ni correos ni secretos se
exportan. Los contadores de antispam no incluyen reglas que no registran estadísticas.

**No inferir**: uptime mensual, causa raíz, éxito de respaldos, actividad en Inmovilla
cuando expiró la caché, ni trabajos realizados. UptimeRobot, tickets y despliegues
se recopilan desde Red-Byte por otras fuentes.

## Preparación mensual del ciclo cerrado

ConfortHouse tiene ciclo contractual del 16 al 15. El ciclo queda cerrado
**recién el día 16**, por lo que generar el día 15 un documento periódico para
importación sería prematuro. El informe SEO/SEM `special` es independiente.

El comando existente admite los modos:

```bash
# Solo salida JSON por stdout, sin guardar archivos:
php artisan maintenance:evidence --from=2026-09-16 --to=2026-10-15

# Solo el ciclo contractual más reciente efectivamente cerrado:
php artisan maintenance:evidence --closed-cycle

# Genera (o reemplaza) UN único snapshot en ubicación privada:
php artisan maintenance:evidence --closed-cycle --store
```

`--store` crea o reemplaza exclusivamente
`storage/app/private/report-evidence/conforthouse/latest.json`, permisos de
archivo `0600`, fuera de `public/` y sin modificar registros de la aplicación.
No acumula `snapshot-YYYY*.json` ni archivos por cada mes. Red-Byte aplica su
propia retención de 7 días a JSON **importados exitosamente**; esa política
no debe borrar documentos protegidos como la investigación SEO/SEM original.

Si se activa **expresamente** `REDBYTE_EVIDENCE_SCHEDULE_ENABLED=true`, y existe
un scheduler Laravel real en IONOS, se ejecutará el día **16 a las 08:00,
Europe/Madrid**. Este cambio NO altera la tarea vigente de Inmovilla.
El scheduler está desactivado por defecto.

## API de lectura de la evidencia guardada

```text
GET https://www.rbconforthouse.com/api/internal/maintenance-evidence/v1?from=2026-09-16&to=2026-10-15
X-RedByte-Evidence-Token: <token exclusivo de la fuente>
```

- Disponible **solo después de la activación expresa** en producción.
- HTTPS, token de lectura de longitud mínima 32 caracteres, `throttle:6,1`;
  nunca incluir el token en parámetros URL, Git o logs.
- El endpoint únicamente lee el JSON previamente consolidado. No ejecuta
  Artisan, escaneos de logs ni consultas costosas por solicitud.
- Un rango inválido devuelve 422. Si no existe snapshot o sus fechas son
  distintas a `from` y `to`, devuelve 404: **no mezcla períodos**.
- Respuesta `Cache-Control: private, no-store` y sin valores identificatorios.
- El secreto **no** habilita edición, acceso SSH ni consulta de otras aplicaciones.

```dotenv
REDBYTE_EVIDENCE_ENABLED=false
REDBYTE_EVIDENCE_READ_TOKEN=<generar-secreto-de-minimo-32-caracteres>
REDBYTE_EVIDENCE_SCHEDULE_ENABLED=false
```

En IONOS se debe verificar que el proceso PHP que sirve la API pueda leer
el archivo con permisos seguros; nunca relajar permisos a `777`.
La aplicación todavía no tiene esos valores activos ni snapshots publicados.

## UptimeRobot

La API externa de UptimeRobot se consulta desde **Red-Byte**, no desde IONOS.
El monitor asociado es `https://rbconforthouse.com/health` y durante las
pruebas del 15/10/2026 respondió correctamente la **API v2** con clave de
solo lectura (la v3 no aceptó esa clave). Su acceso se configura de forma
centralizada y separada. Las cifras e incidentes deben corresponder al período
exacto y la causa reportada por UptimeRobot no constituye diagnóstico de origen.

## Validación y pendientes

- Ejecutar en local los tests `ConfortHouseMaintenanceEvidenceTest` con SQLite.
- Verificar que modo normal no crea JSON y `--store` conserva uno solo.
- Verificar 404 sin flag/token, 422 con fecha inválida, 404 por ventana no
  coincidente y respuesta autenticada en fechas correctas.
- QA, aprobación y pruebas en IONOS previos a activar scheduler o endpoint.
- Red-Byte debe ser el único consumidor y transportar evidencias hacia Dot.
- El administrador es el único que autoriza publicar informes.

**No ejecutar merge, deploy, Artisan sobre producción ni cambios comerciales
sin aprobación expresa.**

## REV2 — Historial verificable de Inmovilla (16/10/2026)

La API sigue respondiendo `redbyte.maintenance-evidence.v1`, ahora con un campo
**aditivo** `activity.inmovilla_executions` y, en `snapshot.backups`, un indicador
sobre la procedencia de las copias de IONOS. El endpoint HTTP **sigue siendo
únicamente de lectura** y no ejecuta `inmovilla:update` ni escanea logs.

El comando `maintenance:evidence --closed-cycle --store` (al crear el snapshot
privado) recupera el historial desde dos fuentes que ya existen:

- `storage/app/inmovilla/inmovilla-YYYY-MM-DD-HHMMSS.xml`: solo metadatos del
  archivo (fecha de modificación, cantidad y días); no lee ni divulga XML,
  direcciones, precios ni identificadores de inmuebles.
- `storage/logs/laravel.log`: cuenta exclusivamente entradas fechadas de
  finalización del comando `inmovilla:update`, finalizaciones del scheduler y
  errores de descarga, comando o propiedades, sin exportar mensajes completos.
  El escaneo conserva el límite actual de 250 MiB y no busca fuera del archivo
  actual; si hubo rotación, lo señala como cobertura parcial.

El período se calcula usando **días locales de Madrid** y compara los timestamps
que genera Laravel según `app.timezone`; respeta el horario de verano y utiliza
extremos [inicio, fin siguiente día). El cron declarado en código está a las
03:00 **America/Argentina/Buenos_Aires**: esa declaración **no prueba** la
programación efectiva de IONOS. El horario de los XML refleja la modificación
del archivo, no necesariamente la finalización del trabajo.

`dates_without_a_completion_entry_in_available_log` indica solamente fechas sin
un mensaje observado de finalización. **No significa que hubiera un fallo o que
no se ejecutara la tarea**. Una finalización de comando tampoco certifica que
cada propiedad se haya actualizado sin errores. Los datos actuales del catálogo
(referencias Inmovilla y última fecha de actualización) son una **fotografía
actual**, no estadísticas de actualizaciones del período.

Los respaldos administrados por IONOS aparecen como fuente con historial de
confirmación **no accesible desde Laravel**; no se presume su éxito. El control
real de ejecuciones del proveedor corresponde al panel IONOS. Esta observación
no altera la frecuencia ni los trabajos contratados.

Auditoría inicial read-only realizada con la sesión autorizada de IONOS para el
ciclo 16/09–15/10: 16 archivos XML en 16 días, del 16/09 al 01/10; 16 entradas
de finalización del comando, ninguna entrada de error de las categorías
examinadas en el archivo actual, 180 inmuebles activos con referencia Inmovilla.
Son resultados de las fuentes **observadas**; no equivalen a la certificación
de 30 sincronizaciones ni de 30 días completos de logs.

Este cambio no modifica `inmovilla:update`, el importador, el scheduler vigente,
los endpoints públicos ni la lógica de propiedades. No exige migraciones ni
nuevos paquetes. Conservar las modificaciones locales deliberadas de IONOS.
