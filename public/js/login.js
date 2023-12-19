document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Realizar la solicitud al servidor
    fetch('http://localhost:8000/api/auth/logino', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Usuario no autorizado');
        }
        return response.json();
    })
    .then(data => {
        // Almacenar información en localStorage
        localStorage.setItem('access_token', data.access_token);
        localStorage.setItem('token_type', data.token_type);
        localStorage.setItem('expires_in', data.expires_in);

        // Redirigir a otra página o realizar alguna acción adicional
        window.location.href = '/books';  // Cambia a la ruta deseada
    })
    .catch(error => {
        // Mostrar mensaje de error
        document.getElementById('errorMessage').innerText = error.message;
    });
});
