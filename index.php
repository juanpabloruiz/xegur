<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/conexion.php'; ?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Xegur</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">


</head>

<body data-bs-theme="dark">

    <div class="container-fluid">
        <div class="row">

            <!-- MAIN -->
            <div class="col-md-9">

                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#diputados">
                            Diputados
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#senadores">
                            Senadores
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#usuarios">
                            Usuarios
                        </button>
                    </li>
                </ul>

                <div class="tab-content">

                    <!-- DIPUTADOS -->
                    <div class="tab-pane fade show active" id="diputados">
                        <div class="row g-3" id="lista-diputados"></div>
                    </div>

                    <!-- SENADORES -->
                    <div class="tab-pane fade" id="senadores">
                        <div class="row g-3" id="lista-senadores"></div>
                    </div>

                    <!-- USUARIOS -->
                    <div class="tab-pane fade" id="usuarios">
                        <div class="row g-3" id="lista-usuarios">
                            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/usuarios/index.php' ?>

                        </div>
                    </div>

                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="col-md-3 sidebar">

                <h5>Observaciones del Día</h5>
                <textarea rows="6" class="form-control mb-3"></textarea>

                <div class="monitor-box">
                    <h6>Fecha & Hora</h6>
                    <div id="clock" class="fs-5"></div>
                </div>

                <div class="monitor-box">
                    <h6>CPU</h6>
                    <div class="progress">
                        <div class="progress-bar" style="width: 42%"></div>
                    </div>
                </div>

                <div class="monitor-box">
                    <h6>RAM</h6>
                    <div class="progress">
                        <div class="progress-bar" style="width: 67%"></div>
                    </div>
                </div>

                <div class="monitor-box">
                    <h6>Uptime</h6>
                    <div>12h 44m</div>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="modalLegislador" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitulo"></h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <ul id="lista-movimientos" class="list-unstyled mb-3"></ul>

                    <div class="d-grid gap-2">
                        <button class="btn btn-success">Registrar Entrada</button>
                        <button class="btn btn-danger">Registrar Salida</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <script>
        /* ---------- Reloj ---------- */
        function updateClock() {
            const now = new Date();
            document.getElementById("clock").textContent =
                now.toLocaleDateString() + " " + now.toLocaleTimeString();
        }
        setInterval(updateClock, 1000);
        updateClock();

        /* ---------- Render tarjetas ---------- */
        function crearCard(nombre, tipo, id, randomImg) {
            return `
    <div class="col-6 col-md-4 col-lg-2 legislador-card">
        <img src="https://picsum.photos/300?random=${randomImg}"
             data-id="${id}"
             data-nombre="${nombre}"
             data-tipo="${tipo}"
             data-bs-toggle="modal"
             data-bs-target="#modalLegislador"
             class="legislador">
        <div class="text-center mt-2">${nombre}</div>
    </div>`;
        }

        // Diputados
        const diputados = document.getElementById('lista-diputados');
        for (let i = 1; i <= 30; i++) {
            diputados.innerHTML += crearCard(`Diputado ${i}`, 'DIPUTADO', i, i);
        }

        // Senadores
        const senadores = document.getElementById('lista-senadores');
        for (let i = 1; i <= 16; i++) {
            senadores.innerHTML += crearCard(`Senador ${i}`, 'SENADOR', i, 100 + i);
        }

        /* ---------- Modal dinámico ---------- */
        document.addEventListener('click', e => {
            if (!e.target.classList.contains('legislador')) return;

            const nombre = e.target.dataset.nombre;
            document.getElementById('modalTitulo').textContent = nombre;

            const ul = document.getElementById('lista-movimientos');
            ul.innerHTML = `
        <li>E 08:34</li>
        <li>S 09:01</li>
        <li>E 10:03</li>
    `;
        });
    </script>

</body>

</html>