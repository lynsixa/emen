const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');
const app = express();
const port = 3000;

app.use(cors());
app.use(express.json());

// Conexión a MySQL
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '', // pon tu contraseña si tienes
  database: 'emendsrtv',
});

// Ruta para obtener los tipos de documento
app.get('/api/tipos-documento', (req, res) => {
  db.query('SELECT * FROM `Tipo de documento`', (err, results) => {
    if (err) return res.status(500).json({ error: err });
    res.json(results);
  });
});

// Ruta para registrar usuario
app.post('/api/registro', (req, res) => {
  const {
    nombres,
    apellidos,
    documento,
    correo,
    contraseña,
    fechaNacimiento,
    tipoDocumentoId,
  } = req.body;

  const usuario = {
    Nombres: nombres,
    Apellidos: apellidos,
    Documento: documento,
    Correo: correo,
    Contraseña: Buffer.from(contraseña), // guardar como VARBINARY
    FechaDeNacimiento: fechaNacimiento,
    token: 'tok_' + Math.random().toString(36).substring(2, 12),
    password_request: 0,
    'Tipo de documento_idTipodedocumento': tipoDocumentoId,
    Roles_idRoles: 1, // rol automático
  };

  db.query('INSERT INTO Usuario SET ?', usuario, (err, result) => {
    if (err) {
      console.error(err);
      return res.status(500).json({ message: 'Error al registrar' });
    }
    res.json({ message: 'Usuario registrado correctamente' });
  });
});

// Iniciar servidor
app.listen(port, () => {
  console.log(`Servidor corriendo en http://localhost:${port}`);
});
