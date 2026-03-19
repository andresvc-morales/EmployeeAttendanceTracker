<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body>
    <form>

        <a href="history.php">Historial de Asistencia</a>
        <p id="estado">Estado: pendiente</p>
        <button type="button" onclick="markEntry()">Marcar Entrada</button>
        <button type="button" onclick="markExit()">Marcar Salida</button>
    </form>
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
                document.getElementById("estado").textContent = "Bienvenido: " + user.email;
            } else {

                window.location.href = "login.php";
            }
        });
        function markEntry() {
            // Aquí irá el código para marcar la entrada en MySQL
            alert('Entrada marcada');
        }
        function markExit() {
            // Aquí irá el código para marcar la salida en MySQL
            alert('Salida marcada');
        }

    </script>
</body>

</html>