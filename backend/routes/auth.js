const express = require("express");
const router = express.Router();
const mysql = require("mysql2");
const db = require("../db"); // Asegúrate de que db.js tenga la conexión

// Ruta de login
router.post("/login", (req, res) => {
  const { correo, contraseña } = req.body;

  const query = "SELECT * FROM Usuario WHERE Correo = ? AND Contraseña = ?";
  db.query(query, [correo, contraseña], (err, results) => {
    if (err) {
      console.error("Error al consultar la base de datos:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }

    if (results.length > 0) {
      res.json({ mensaje: "Login exitoso", usuario: results[0] });
    } else {
      res.status(401).json({ mensaje: "Correo o contraseña incorrectos" });
    }
  });
});

module.exports = router;
