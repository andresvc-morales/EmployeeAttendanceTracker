<!DOCTYPE html>
<html>

<head>

    <title>Register</title>
</head>

<Body>
    <form>
        <input type="text" id='name' placeholder='Nombre'>
        <input type='email' id='email' placeholder='Correo'>
        <input type='password' id='password' placeholder='Contraseña'>
        <select id="role">
            <option value="employee">Empleado</option>
            <option value="admin">Administrador</option>
        </select>

        <button type='button' onclick='register()'>Registrar</button>

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
        function register() {
        
        }
    </script>
</Body>

</html>