<!DOCTYPE html>
<html>

<head>

    <title>Login</title>
</head>

<Body>
    <form>
        <input type="email" id="email" placeholder="Correo">
        <input type="password" id="password" placeholder="Contraseña">
        <button type="button" onclick="login()">Iniciar Sesión</button>
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
        function login() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            firebase.auth().signInWithEmailAndPassword(email, password)
                .then((userCredential) => {

                    const user = userCredential.user;
                    window.location.href = "dashboard.php";
                })
                .catch((error) => {

                  //  const errorCode = error.code;
                  //  const errorMessage = error.message;
                    alert('Email o contraseña incorrectos, por favor intente de nuevo.');
                });
        }
    </script>
</Body>

</html>