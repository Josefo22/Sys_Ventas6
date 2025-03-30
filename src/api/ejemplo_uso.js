/**
 * Ejemplo de uso de la API de autenticación con JavaScript
 * Este archivo muestra cómo interactuar con las APIs de autenticación
 * desde una aplicación cliente
 */

// URL base para las APIs - ajustar según tu entorno
const API_BASE_URL = 'http://localhost/Sysventas';

/**
 * Función para iniciar sesión
 * @param {string} usuario - Nombre de usuario
 * @param {string} clave - Contraseña del usuario
 * @returns {Promise} - Promesa con los datos de la respuesta
 */
async function login(usuario, clave) {
    try {
        const response = await fetch(`${API_BASE_URL}/src/api/auth.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ usuario, clave })
        });
        
        const data = await response.json();
        
        if (response.ok) {
            // Guardar el token en localStorage para usarlo en futuras peticiones
            localStorage.setItem('authToken', data.token);
            localStorage.setItem('userData', JSON.stringify(data.usuario));
        }
        
        return { 
            success: response.ok, 
            data,
            status: response.status 
        };
    } catch (error) {
        return { 
            success: false, 
            error: error.message,
            status: 500
        };
    }
}

/**
 * Función para verificar si hay una sesión activa
 * @returns {Promise} - Promesa con los datos de la respuesta
 */
async function verificarSesion() {
    try {
        const token = localStorage.getItem('authToken');
        
        const response = await fetch(`${API_BASE_URL}/src/api/auth.php`, {
            method: 'GET',
            headers: {
                'Authorization': token ? `Bearer ${token}` : ''
            }
        });
        
        const data = await response.json();
        return { 
            success: response.ok, 
            data,
            status: response.status 
        };
    } catch (error) {
        return { 
            success: false, 
            error: error.message,
            status: 500
        };
    }
}

/**
 * Función para cerrar sesión
 * @returns {Promise} - Promesa con los datos de la respuesta
 */
async function logout() {
    try {
        const response = await fetch(`${API_BASE_URL}/src/api/logout.php`, {
            method: 'POST'
        });
        
        const data = await response.json();
        
        if (response.ok) {
            // Eliminar token y datos de usuario del localStorage
            localStorage.removeItem('authToken');
            localStorage.removeItem('userData');
        }
        
        return { 
            success: response.ok, 
            data,
            status: response.status 
        };
    } catch (error) {
        return { 
            success: false, 
            error: error.message,
            status: 500
        };
    }
}

/**
 * Función para solicitar recuperación de contraseña
 * @param {string} email - Correo electrónico del usuario
 * @returns {Promise} - Promesa con los datos de la respuesta
 */
async function recuperarPassword(email) {
    try {
        const response = await fetch(`${API_BASE_URL}/src/api/recuperar.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email })
        });
        
        const data = await response.json();
        return { 
            success: response.ok, 
            data,
            status: response.status 
        };
    } catch (error) {
        return { 
            success: false, 
            error: error.message,
            status: 500
        };
    }
}

/**
 * Función para obtener datos del perfil del usuario
 * Requiere autenticación previa
 * @returns {Promise} - Promesa con los datos del perfil
 */
async function obtenerPerfil() {
    try {
        const token = localStorage.getItem('authToken');
        
        if (!token) {
            return {
                success: false,
                error: 'No hay sesión activa',
                status: 401
            };
        }
        
        const response = await fetch(`${API_BASE_URL}/src/api/perfil.php`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
        
        const data = await response.json();
        return { 
            success: response.ok, 
            data,
            status: response.status 
        };
    } catch (error) {
        return { 
            success: false, 
            error: error.message,
            status: 500
        };
    }
}

/**
 * Función de utilidad para realizar solicitudes autenticadas
 * @param {string} url - URL de la API a llamar
 * @param {string} method - Método HTTP (GET, POST, PUT, DELETE)
 * @param {object} body - Datos a enviar en el cuerpo de la solicitud (solo para POST, PUT)
 * @returns {Promise} - Promesa con los datos de la respuesta
 */
async function fetchWithAuth(url, method = 'GET', body = null) {
    try {
        const token = localStorage.getItem('authToken');
        
        if (!token) {
            return {
                success: false,
                error: 'No hay sesión activa',
                status: 401
            };
        }
        
        const options = {
            method,
            headers: {
                'Authorization': `Bearer ${token}`
            }
        };
        
        if (body && (method === 'POST' || method === 'PUT')) {
            options.headers['Content-Type'] = 'application/json';
            options.body = JSON.stringify(body);
        }
        
        const response = await fetch(`${API_BASE_URL}${url}`, options);
        
        // Si la respuesta es 401 (No autorizado), probablemente el token expiró
        if (response.status === 401) {
            // Limpiar datos de autenticación local
            localStorage.removeItem('authToken');
            localStorage.removeItem('userData');
        }
        
        const data = await response.json();
        return { 
            success: response.ok, 
            data,
            status: response.status 
        };
    } catch (error) {
        return { 
            success: false, 
            error: error.message,
            status: 500
        };
    }
}

// Ejemplo de uso:
/*
// Inicio de sesión
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const usuario = document.getElementById('usuario').value;
    const clave = document.getElementById('clave').value;
    
    const resultado = await login(usuario, clave);
    
    if (resultado.success) {
        alert('Inicio de sesión exitoso');
        window.location.href = 'dashboard.html';
    } else {
        alert('Error: ' + (resultado.data?.message || 'No se pudo conectar al servidor'));
    }
});

// Verificar si hay sesión al cargar la página
document.addEventListener('DOMContentLoaded', async () => {
    const resultado = await verificarSesion();
    
    if (!resultado.success || !resultado.data.authenticated) {
        // Redirigir a la página de inicio de sesión si no hay sesión
        window.location.href = 'login.html';
    }
});

// Botón de cierre de sesión
document.getElementById('logoutBtn').addEventListener('click', async () => {
    const resultado = await logout();
    if (resultado.success) {
        window.location.href = 'login.html';
    }
});

// Uso de la utilidad fetchWithAuth para obtener datos protegidos
async function cargarDatosUsuario() {
    const resultado = await fetchWithAuth('/src/api/perfil.php');
    
    if (resultado.success) {
        const usuario = resultado.data.usuario;
        document.getElementById('nombreUsuario').textContent = usuario.nombre;
        // Mostrar más datos del usuario...
    }
}
*/ 