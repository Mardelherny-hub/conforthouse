# ConfortHouse — recolector de evidencias de mantenimiento (REV0)

**Alcance:** SOLO mantenimiento técnico. NO genera un informe comercial, NO ejecuta
actualizaciones ni modifica datos de la aplicación. Esta REV0 es una fuente de
**evidencia parcial**, NO el JSON que admite `ReportDraftService` de Red-Byte.

## Qué hace

- Consulta la conexión de base de datos con `SELECT 1` y estadísticas agregadas de
  propiedades activas, destacadas, eliminadas lógicamente y por operación.
- Lee la caché existente de sincronización Inmovilla (`last_run` y contadores).
  La caché puede expirar: la ausencia no prueba que haya fallado la sincronización.
- Lee `storage/app/spam_stats.json` por meses **calendario**; incluye los
  contadores almacenados y la cantidad de IPs de la muestra, nunca sus valores.
  Las campañas bloqueadas por reglas que no invocan `recordSpamAttempt` no están
  incluidas. El volumen de IPs muestreadas está limitado por la aplicación.
- Lee el tamaño del log Laravel y cuenta eventos de severidad del archivo actual
  dentro de la ventana solicitada, **sin exportar mensajes ni identificadores**.
  Los logs rotados no se incluyen: los totales son potencialmente incompletos.
  Si el log supera 250 MiB, omite el escaneo y lo indica.
- Obtiene una observación puntual del espacio en el filesystem (NO la cuota IONOS).
- Marca UptimeRobot y las intervenciones del equipo como **fuentes externas pendientes**:
  no inventa uptime, causas raíz, cron ejecutados ni trabajos realizados.

## Ejecución local o manual (no requiere Artisan heredado)

Estos comandos NO hacen escrituras en DB ni modifican los servicios:

```bash
# Por defecto: JSON a stdout, sin guardar nada. Ventana rodante de 30 días.
php artisan maintenance:evidence

# Ventana explícita, ambos extremos incluidos. NO modifica datos ni guarda archivo.
php artisan maintenance:evidence --from=2026-09-16 --to=2026-10-15

# Solo si se desea un snapshot privado: crea archivos JSON fuera de public/.
php artisan maintenance:evidence --from=2026-09-16 --to=2026-10-15 --store
```

`--store` conserva snapshots únicos y actualiza atómicamente
`storage/app/private/report-evidence/conforthouse/latest.json`; archivos
con permisos 0600. El directorio NO está enlazado por `storage:link`.

La ventana predeterminada del scheduler es una **observación rodante de 30
días**; no se considera automáticamente el ciclo contractual. Para preparar
un informe, contrastar el período real acordado con UptimeRobot y tickets.

## Acceso de consulta para Red-Byte / Dot

Ruta GET de solo lectura:
`https://rbconforthouse.com/api/internal/maintenance-evidence/conforthouse`.

**Desactivado por defecto.** Una vez validado el deploy, la prueba de
compatibilidad y las restricciones del alojamiento, configurar en el entorno
del servidor (nunca en Git o en chats):

```dotenv
REDBYTE_EVIDENCE_ENABLED=true
REDBYTE_EVIDENCE_READ_TOKEN=<clave-larga-aleatoria-de-32-o-mas-caracteres>
# Activar recién después de comprobar la recopilación mensual:
REDBYTE_EVIDENCE_SCHEDULE_ENABLED=false
```

La solicitud debe enviarse por HTTPS con el encabezado
`X-RedByte-Evidence-Token`. Nunca incluir el token en la URL ni en logs.

Sin flag, con token corto/ausente/inválido o sin snapshot, responde 404.
Tiene límite de 6 solicitudes/minuto y encabezado `Cache-Control: no-store`.
Es imprescindible verificar en IONOS que el usuario que ejecuta PHP puede
leer los archivos privados; **no relajar permisos hasta 777**.

**Esto no otorga acceso SSH ni acceso a base de datos a Dot.** El objetivo
es que un proceso central autorizado consulte el snapshot previamente
generado. No importar ni publicar ningún informe automáticamente.

## Programación mensual (opt-in)

Solo al configurar `REDBYTE_EVIDENCE_SCHEDULE_ENABLED=true`, y si ya
funciona el scheduler de Laravel en IONOS, queda una ejecución el **día 15
a las 08:00 hora Europe/Madrid**. Genera evidencia privada; no genera PDFs,
no envía correos y no publica.

Antes de habilitar:
1. Ejecutar tests locales y verificar `--store` en entorno de prueba.
2. Desplegar únicamente después de aprobación; verificar configuración,
   permisos de carpetas y logs en IONOS.
3. Verificar 404 con feature desactivada; activar y comprobar la petición
   autenticada. Mantener la credencial fuera del repositorio.
4. Comprobar la ejecución programada y comparar el snapshot con los datos
   originales sin convertir observaciones puntuales en históricos.

## Integración UptimeRobot (fuente separada)

Obtener estadísticas e incidentes desde la API **oficial v3**, con una clave
**read-only** resguardada en el recolector central Red-Byte, no en este
hosting compartido. El monitor de ConfortHouse es:
`https://rbconforthouse.com/health`.

El integrador debe aportar: rango exacto, zona horaria, uptime,
eventos, duración y motivo reportado por el proveedor; conciliar
totales y cantidad de eventos antes de redactar. Los motivos de monitor
no prueban por sí mismos que IONOS sea la causa.

**Flujo final previsto:** snapshot técnico + UptimeRobot + cambios y tickets
verificados → Dot → borrador compatible con `ReportDraftService` →
validación → aprobación humana. Este commit implementa solamente la
primera fuente y su mecanismo de consulta protegida.
