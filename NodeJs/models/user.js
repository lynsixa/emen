const User = require('../models/user');
const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const keys = require('../config/keys'); // Asegúrate que aquí esté tu JWT_SECRET

module.exports = {
  async register(req, res) {
    try {
      const {
        Documento,
        tipoDocumento,
        Nombres,
        Apellidos,
        Correo,
        Contraseña,
        FechaDeNacimiento
      } = req.body;

      if (!Documento || !Nombres || !Apellidos || !Correo || !Contraseña || !FechaDeNacimiento || !tipoDocumento) {
        return res.status(400).json({ success: false, message: 'Todos los campos son obligatorios' });
      }

      const existingUser = await User.findByDocumento(Documento);
      if (existingUser) {
        return res.status(409).json({ success: false, message: 'El documento ya está registrado' });
      }

      const hashedPassword = await bcrypt.hash(Contraseña, 10);

      const newUser = {
        Documento,
        Nombres,
        Apellidos,
        Correo,
        Contraseña: hashedPassword,
        FechaDeNacimiento,
        'Tipo de documento_idTipodedocumento': tipoDocumento === 'CC' ? 1 : 2,
        Roles_idRoles: 4,
        CodigoNis_idCodigoNis: null
      };

      const savedUser = await User.create(newUser);

      return res.status(201).json({
        success: true,
        message: 'Usuario registrado correctamente',
        data: savedUser
      });
    } catch (error) {
      return res.status(500).json({ success: false, message: 'Error en el servidor', error });
    }
  },

  async login(req, res) {
    try {
      const { Correo, Contraseña } = req.body;

      if (!Correo || !Contraseña) {
        return res.status(400).json({ success: false, message: 'Correo y contraseña son requeridos' });
      }

      const user = await User.findByCorreo(Correo);
      if (!user) {
        return res.status(401).json({ success: false, message: 'Correo no encontrado' });
      }

      const isPasswordValid = await bcrypt.compare(Contraseña, user.Contraseña);
      if (!isPasswordValid) {
        return res.status(401).json({ success: false, message: 'Contraseña incorrecta' });
      }

      const token = jwt.sign(
        { id: user.Documento, correo: user.Correo },
        keys.secretOrKey,
        { expiresIn: '2h' }
      );

      return res.status(200).json({
        success: true,
        message: 'Inicio de sesión exitoso',
        token,
        data: user
      });
    } catch (error) {
      return res.status(500).json({ success: false, message: 'Error al iniciar sesión', error });
    }
  }
};

