<?php
session_start();
include('db.php');

/**
 * Inicializaciones
 */
// Iniciar puntuación en 1 si no existe
if (!isset($_SESSION['aciertos'])) {
    $_SESSION['aciertos'] = 1;
}

// Función para crear una nueva pregunta y guardarla en sesión
function nueva_pregunta($conn) {
    // Obtener el hiragana correcto
    $sql = "SELECT HCCharater, HCromaji FROM HiraganaCharater ORDER BY RAND() LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    if (!$row) return false;

    $correct_char = $row['HCCharater'];
    $correct_romaji = $row['HCromaji'];

    // Obtener 2 romaji aleatorios distintos al correcto
    $sql2 = "SELECT HCromaji FROM HiraganaCharater WHERE HCromaji <> ? ORDER BY RAND() LIMIT 2";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param('s', $correct_romaji);
    $stmt2->execute();
    $res2 = $stmt2->get_result();

    $wrong = [];
    while ($r = $res2->fetch_assoc()) {
        $wrong[] = $r['HCromaji'];
    }

    // Si por alguna razon no obtuvimos 2 equivocadas (tabla pequeña), rellenamos con valores por defecto
    while (count($wrong) < 2) {
        $wrong[] = 'xa'; // filler, improbable
    }

    // Crear arreglo de opciones y mezclar
    $options = [$correct_romaji, $wrong[0], $wrong[1]];
    shuffle($options);

    // Guardar en sesión
    $_SESSION['hiragana'] = $correct_char;
    $_SESSION['romaji'] = $correct_romaji;
    $_SESSION['options'] = $options;
    $_SESSION['answered'] = false;
    $_SESSION['last_choice'] = null;
    $_SESSION['last_result'] = null;

    return true;
}

// Si no hay pregunta en sesión, generar una
if (!isset($_SESSION['hiragana']) || !isset($_SESSION['romaji']) || !isset($_SESSION['options'])) {
    nueva_pregunta($conn);
}

// Procesar acciones: Responder, Siguiente o Reiniciar
$notification = null;
$game_over = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Reiniciar juego (opcional)
    if (isset($_POST['reset'])) {
        // Limpiar sesión y reiniciar
        $_SESSION = [];
        session_destroy();
        session_start();
        $_SESSION['aciertos'] = 1;
        nueva_pregunta($conn);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Siguiente pregunta (se presiona tras haber respondido)
    if (isset($_POST['next'])) {
        // Generar nueva pregunta
        nueva_pregunta($conn);
    }

    // Usuario respondió seleccionando una opción
    if (isset($_POST['choice']) && !$_SESSION['answered']) {
        $user_choice = trim($_POST['choice']);
        $_SESSION['last_choice'] = $user_choice;
        $correct = $_SESSION['romaji'];

        if (strtolower($user_choice) === strtolower($correct)) {
            // Correcto
            $_SESSION['aciertos'] = $_SESSION['aciertos'] + 1;
            $_SESSION['last_result'] = 'correct';
        } else {
            // Incorrecto
            $_SESSION['aciertos'] = $_SESSION['aciertos'] - 1;
            $_SESSION['last_result'] = 'incorrect';
        }

        $_SESSION['answered'] = true;

        // Comprobar condiciones de fin
        if ($_SESSION['aciertos'] >= 10) {
            $notification = "¡Felicidades — Ganaste! Llegaste a 10 puntos.";
            $game_over = true;
        } elseif ($_SESSION['aciertos'] <= 0) {
            $notification = "Has perdido — Llegaste a 0 puntos.";
            $game_over = true;
        }
    }
}

// Valores para render
$hiragana = htmlspecialchars($_SESSION['hiragana'] ?? '');
$options = $_SESSION['options'] ?? [];
$aciertos = $_SESSION['aciertos'] ?? 1;
$answered = $_SESSION['answered'] ?? false;
$last_choice = $_SESSION['last_choice'] ?? null;
$correct_romaji = $_SESSION['romaji'] ?? null;
$last_result = $_SESSION['last_result'] ?? null;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Practicar Hiragana - Múltiple</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .choice-btn { width: 100%; margin-bottom: 0.75rem; font-size: 1.15rem; }
        .hiragana-char { font-size: 5rem; line-height: 1; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card mx-auto shadow" style="max-width:640px;">
            <div class="card-body">
                <h1 class="card-title text-center mb-4">Adivina el Hiragana</h1>

                <!-- Score y notificaciones -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div><strong>Puntos:</strong> <?php echo $aciertos; ?></div>
                    <div>
                        <?php if ($game_over): ?>
                            <form method="POST" class="d-inline">
                                <button name="reset" class="btn btn-outline-secondary btn-sm">Reiniciar</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($notification): ?>
                    <div class="alert <?php echo ($last_result === 'correct' && !$game_over) ? 'alert-success' : 'alert-warning'; ?>">
                        <?php echo htmlspecialchars($notification); ?>
                    </div>
                <?php endif; ?>

                <!-- Hiragana a adivinar -->
                <div class="text-center mb-4">
                    <div class="hiragana-char"><?php echo $hiragana; ?></div>
                </div>

                <!-- Opciones como botones -->
                <form method="POST">
                    <?php foreach ($options as $opt): 
                        $opt_esc = htmlspecialchars($opt);
                        $btn_class = 'btn btn-outline-primary choice-btn';
                        $disabled = '';
                        // Si ya respondimos, coloreamos: correcto = verde; el elegido e incorrecto = rojo; otros neutrales
                        if ($answered) {
                            $disabled = 'disabled';
                            if (strtolower($opt) === strtolower($correct_romaji)) {
                                $btn_class = 'btn btn-success choice-btn';
                            } elseif ($last_choice !== null && strtolower($opt) === strtolower($last_choice)) {
                                // Fue la opción elegida y es incorrecta
                                $btn_class = 'btn btn-danger choice-btn';
                            } else {
                                $btn_class = 'btn btn-outline-secondary choice-btn';
                            }
                        }
                    ?>
                        <button type="submit" name="choice" value="<?php echo $opt_esc; ?>" class="<?php echo $btn_class; ?>" <?php echo $disabled; ?>>
                            <?php echo $opt_esc; ?>
                        </button>
                    <?php endforeach; ?>

                    <!-- Si ya respondimos, mostramos botón Siguiente -->
                    <?php if ($answered && !$game_over): ?>
                        <div class="d-grid mt-2">
                            <button type="submit" name="next" class="btn btn-primary">Siguiente</button>
                        </div>
                    <?php endif; ?>
                </form>

                <!-- Mensaje de resultado (opcional) -->
                <?php if ($answered): ?>
                    <div class="mt-3">
                        <?php if ($last_result === 'correct'): ?>
                            <div class="alert alert-success mb-0">¡Correcto! +1 punto.</div>
                        <?php else: ?>
                            <div class="alert alert-danger mb-0">Incorrecto. -1 punto. La respuesta correcta es: <strong><?php echo htmlspecialchars($correct_romaji); ?></strong></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Indicador de progreso simple -->
                <div class="mt-3 text-center text-muted small">
                    Responde hasta llegar a 10 puntos para ganar. Si llegas a 0, pierdes.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
