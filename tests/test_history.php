<?php
/**
 * Script de prueba para history.php
 * Ejecutar desde el contenedor o con: php test_history.php
 */

$base_url = "http://localhost:8080";

// Colores para la consola
function ok($msg)   { echo "\033[32m✓ $msg\033[0m\n"; }
function fail($msg) { echo "\033[31m✗ $msg\033[0m\n"; }
function info($msg) { echo "\033[33m→ $msg\033[0m\n"; }

echo "\n=== TEST: history.php ===\n\n";

// ─────────────────────────────────────────
// TEST 1: El endpoint responde
// ─────────────────────────────────────────
info("TEST 1: Endpoint responde...");
$response = @file_get_contents("$base_url/api/history.php");

if ($response === false) {
    fail("No se pudo conectar a $base_url/api/history.php");
    exit(1);
}
ok("Endpoint accesible");

// ─────────────────────────────────────────
// TEST 2: Respuesta es JSON válido
// ─────────────────────────────────────────
info("TEST 2: Respuesta es JSON válido...");
$data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    fail("JSON inválido: " . json_last_error_msg());
    fail("Respuesta cruda: $response");
    exit(1);
}
ok("JSON válido");

// ─────────────────────────────────────────
// TEST 3: Es un array
// ─────────────────────────────────────────
info("TEST 3: La respuesta es un array...");
if (!is_array($data)) {
    fail("Se esperaba un array, se recibió: " . gettype($data));
    exit(1);
}
ok("Es un array con " . count($data) . " registros");

// ─────────────────────────────────────────
// TEST 4: Estructura correcta de cada registro
// ─────────────────────────────────────────
info("TEST 4: Estructura de los registros...");
$camposRequeridos = [
    'master', 'esclavo', 'ubicacion',
    'id_sensor', 'sensor', 'tipo',
    'lectura', 'fecha', 'estado_calculado',
    'desviacion', 'nivel_severidad'
];

if (count($data) > 0) {
    $primerRegistro = $data[0];
    $faltantes = [];

    foreach ($camposRequeridos as $campo) {
        if (!array_key_exists($campo, $primerRegistro)) {
            $faltantes[] = $campo;
        }
    }

    if (count($faltantes) > 0) {
        fail("Campos faltantes: " . implode(', ', $faltantes));
    } else {
        ok("Todos los campos presentes");
        echo "\n  Ejemplo del primer registro:\n";
        foreach ($primerRegistro as $k => $v) {
            echo "    $k: $v\n";
        }
    }
} else {
    info("Array vacío — no hay registros en la BD todavía (esto es normal)");
}

// ─────────────────────────────────────────
// TEST 5: Ordenado por fecha DESC
// ─────────────────────────────────────────
info("\nTEST 5: Ordenado por fecha DESC...");
if (count($data) >= 2) {
    $fecha1 = strtotime($data[0]['fecha']);
    $fecha2 = strtotime($data[1]['fecha']);

    if ($fecha1 >= $fecha2) {
        ok("Fechas en orden correcto (DESC)");
    } else {
        fail("Las fechas NO están en orden DESC");
    }
} else {
    info("Menos de 2 registros, no se puede verificar el orden");
}

// ─────────────────────────────────────────
// TEST 6: Máximo 500 registros (LIMIT)
// ─────────────────────────────────────────
info("TEST 6: Respeta el LIMIT 500...");
if (count($data) <= 500) {
    ok("Registros dentro del límite (" . count($data) . "/500)");
} else {
    fail("Se recibieron más de 500 registros: " . count($data));
}

echo "\n=== FIN DE TESTS ===\n\n";