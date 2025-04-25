const express = require('express');
const router = express.Router();

// Asegúrate de que esta ruta apunta correctamente al archivo donde están tus métodos
const UserController = require('../controller/usersController');

// Ruta para registrar un nuevo usuario
router.post('/register', UserController.register);

// Ruta para iniciar sesión
router.post('/login', UserController.login);

module.exports = router;
