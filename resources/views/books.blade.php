<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Books CRUD</title>
  <!-- Agrega los enlaces a Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <a class="navbar-brand" href="#">AppSolati</a>
          <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              {{-- <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
              </li> --}}
              <li class="nav-item">
                <a class="dropdown-item" href="#" onclick="logout()">
                    {{ __('Logout') }}
                </a>
              </li>
            </ul>
            {{-- <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form> --}}
          </div>
        </div>
      </nav>
  <div class="container mt-5">
    <h2>Books CRUD</h2>
    <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addBookModal">Agregar Libro</button>

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Título</th>
          <th>Descripción</th>
          <th>Fecha de Creación</th>
          <th>Fecha de Actualización</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="bookTableBody"></tbody>
    </table>
  </div>

  <!-- Modal para agregar libro -->
  <div class="modal fade" id="addBookModal" tabindex="-1" role="dialog" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addBookModalLabel">Agregar Libro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addBookForm">
            <div class="form-group">
              <label for="title">Título:</label>
              <input type="text" class="form-control" id="title" required>
            </div>
            <div class="form-group">
              <label for="description">Descripción:</label>
              <textarea class="form-control" id="description" required></textarea>
            </div>
            <button type="button" class="btn btn-primary" onclick="addBook()">Agregar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal para editar libro -->
<div class="modal fade" id="editBookModal" tabindex="-1" role="dialog" aria-labelledby="editBookModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editBookModalLabel">Editar Libro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeEditModal()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editBookForm">
            <input type="hidden" id="editBookId">
            <div class="form-group">
              <label for="editTitle">Título:</label>
              <input type="text" class="form-control" id="editTitle" required>
            </div>
            <div class="form-group">
              <label for="editDescription">Descripción:</label>
              <textarea class="form-control" id="editDescription" required></textarea>
            </div>
            <button type="button" class="btn btn-primary" onclick="updateBook()">Guardar Cambios</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Agrega los enlaces a Bootstrap JS y Popper.js -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    // Verifica la existencia de token en el localStorage
    var accessToken = localStorage.getItem('access_token');
    if (!accessToken) {
      // Redirige a la página de login si no hay token
      window.location.href = '{{ url("login") }}';
    }

    function logout() {
        fetch(`http://localhost:8000/api/auth/logout`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Authorization': `${localStorage.getItem('token_type')} ${accessToken}`

            },
            credentials: 'same-origin' // incluir cookies en la solicitud
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud al servidor');
            }
            return response.json(); // Si el servidor responde con JSON
        })
        .then(data => {
            // Manejar la respuesta exitosa si es necesario
            console.log(data);
            // Redirigir o realizar otras acciones según sea necesario
            window.location.href = '{{ url("login") }}';
        })
        .catch(error => {
            console.error(error.message);
            // Manejar el error, redirigir o realizar otras acciones según sea necesario
        });
    }
// Variable para almacenar el libro actualmente editado
var currentEditBookId = null;

// Función para abrir el modal de edición
function openEditModal(book) {
  currentEditBookId = book.id;
  document.getElementById('editBookId').value = book.id;
  document.getElementById('editTitle').value = book.title;
  document.getElementById('editDescription').value = book.description;
  document.getElementById('editBookModal').classList.add('show');
  document.getElementById('editBookModal').style.display = 'block';
  document.body.classList.add('modal-open');
}

// Función para cerrar el modal de edición
function closeEditModal() {
  currentEditBookId = null;
  document.getElementById('editBookForm').reset();
  document.getElementById('editBookModal').classList.remove('show');
  document.getElementById('editBookModal').style.display = 'none';
  document.body.classList.remove('modal-open');
}

// Función para actualizar un libro
function updateBook() {
  var id = document.getElementById('editBookId').value;
  var title = document.getElementById('editTitle').value;
  var description = document.getElementById('editDescription').value;

  fetchData(`http://localhost:8000/api/books-ws/${id}`, 'PUT', { title, description })
    .then(() => {
      // Actualiza la fila de la tabla con los nuevos datos
      var row = document.getElementById(`bookRow${id}`);
      row.cells[1].innerHTML = title;
      row.cells[2].innerHTML = description;

      // Cierra el modal de edición
      closeEditModal();
    })
    .catch(error => {
      console.error(error.message);
    });
}

    // Función para realizar la solicitud al servidor
    function fetchData(url, method, body = {}) {
        let info = {

        };

        if(method != "GET") {
            info = {
                method: method,
                headers: {
                'Content-Type': 'application/json',
                'Authorization': `${localStorage.getItem('token_type')} ${accessToken}`
                },
                body: JSON.stringify(body)
            }
        }
        else
        {
            info = {
                method: method,
                headers: {
                'Content-Type': 'application/json',
                'Authorization': `${localStorage.getItem('token_type')} ${accessToken}`
                }
            }
        }

      return fetch(url, info)
      .then(response => {
        if (!response.ok) {
          throw new Error('Error en la solicitud al servidor');
        }
        return response.json();
      });
    }

    // Función para cargar los libros desde el servidor
    function loadBooks() {
      fetchData('http://localhost:8000/api/books-ws', 'GET')
        .then(data => {
          // Limpia la tabla antes de agregar nuevos datos
          document.getElementById('bookTableBody').innerHTML = '';

          console.log("data");
          console.log(data);
          // Itera sobre los libros y los agrega a la tabla
          data.data.forEach(book => {
            console.log("book");
          console.log(book);

            appendBookToTable(book);
          });
        })
        .catch(error => {
          console.error(error.message);
        });
    }

    // Función para agregar un libro
    function addBook() {
      var title = document.getElementById('title').value;
      var description = document.getElementById('description').value;

      fetchData('http://localhost:8000/api/books-ws', 'POST', { title, description })
        .then(data => {
          // Agrega el nuevo libro a la tabla
          appendBookToTable(data);

          // Limpia el formulario
          document.getElementById('addBookForm').reset();

          // Cierra el modal
          $('#addBookModal').modal('hide');
        })
        .catch(error => {
          console.error(error.message);
        });
    }

    // Función para eliminar un libro
    function deleteBook(id) {
      fetchData(`http://localhost:8000/api/books-ws/${id}`, 'DELETE')
        .then(() => {
          // Elimina la fila de la tabla
          document.getElementById(`bookRow${id}`).remove();
        })
        .catch(error => {
          console.error(error.message);
        });
    }

    // Función para agregar un libro a la tabla
    function appendBookToTable(book) {
      var tableBody = document.getElementById('bookTableBody');
      var row = tableBody.insertRow();

      row.id = `bookRow${book.id}`;

      var cellId = row.insertCell(0);
      var cellTitle = row.insertCell(1);
      var cellDescription = row.insertCell(2);
      var cellCreatedAt = row.insertCell(3);
      var cellUpdatedAt = row.insertCell(4);
      var cellActions = row.insertCell(5);

      cellId.innerHTML = book.id;
      cellTitle.innerHTML = book.title;
      cellDescription.innerHTML = book.description;
      cellCreatedAt.innerHTML = book.created_at;
      cellUpdatedAt.innerHTML = book.updated_at;
    // Agrega el botón de "Editar"
    var editButton = document.createElement('button');
    editButton.className = 'btn btn-primary btn-sm mr-2';
    editButton.innerHTML = 'Editar';
    editButton.onclick = function () {
      openEditModal(book);
    };
    cellActions.appendChild(editButton);

      var deleteButton = document.createElement('button');
      deleteButton.className = 'btn btn-danger btn-sm';
      deleteButton.innerHTML = 'Eliminar';
      deleteButton.onclick = function () {
        deleteBook(book.id);
      };

      cellActions.appendChild(deleteButton);
    }

    // Carga los libros al cargar la página
    loadBooks();

  </script>
</body>
</html>
