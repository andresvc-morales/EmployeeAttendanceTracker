<!DOCTYPE html>
<html>

<head>
    <title>Panel de Administrador</title>
</head>

<body>

    <table>
        <thead>
            <tr>
                <th>Empleado</th>
                <th>Fecha</th>
                <th>Hora de Entrada</th>
                <th>Hora de Salida</th>
            </tr>
        </thead>

        <tbody>
            <?php
            // aquí irá el código para consultar MySQL
            // y mostrar los registros de asistencia
            ?>
        </tbody>

    </table>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-auth-compat.js"></script>
    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyA13I09OPMLm-tMH9zMQgUFH2abe_rfLM8",
            authDomain: "employeeattendancetracke-5c502.firebaseapp.com",
            projectId: "employeeattendancetracke-5c502",
            storageBucket: "employeeattendancetracke-5c502.firebasestorage.app",
            messagingSenderId: "858304795754",
            appId: "1:858304795754:web:9b90d392050a23c783e613"
        };
        firebase.initializeApp(firebaseConfig);
        firebase.auth().onAuthStateChanged((user) => {

            if (user) {
                // usuario autenticado con rol admin
                // aquí irá la consulta al AttendanceController.php
                // para cargar los registros de todos los empleados

            } else {

                window.location.href = "login.php";
            }
        });
    </script>
</body>

</html>