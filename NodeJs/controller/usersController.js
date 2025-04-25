const User = require('../models/user');
const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const keys = require('../config/keys');
const crypto = require('crypto');

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

            const salt = await bcrypt.genSalt(10);
            const hashedPassword = await bcrypt.hash(Contraseña, salt);

            const userToken = crypto.randomBytes(20).toString('hex');

            const newUser = {
                Documento,
                Nombres,
                Apellidos,
                Correo,
                Contraseña: hashedPassword,
                FechaDeNacimiento,
                token: userToken,
                password_request: 0,
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

        } catch (err) {
            console.error(err);
            return res.status(500).json({ success: false, message: 'Error en el registro', error: err });
        }
    },

    async login(req, res) {
        try {
            const { Documento, Contraseña } = req.body;

            if (!Documento || !Contraseña) {
                return res.status(400).json({ success: false, message: 'Documento y contraseña son obligatorios' });
            }

            const user = await User.findByDocumento(Documento);
            if (!user) {
                return res.status(404).json({ success: false, message: 'Usuario no encontrado' });
            }

            const isMatch = await bcrypt.compare(Contraseña, user.Contraseña);
            if (!isMatch) {
                return res.status(401).json({ success: false, message: 'Contraseña incorrecta' });
            }

            const payload = {
                id: user.id,
                Documento: user.Documento,
                Nombres: user.Nombres,
                Correo: user.Correo,
                Roles_idRoles: user.Roles_idRoles
            };

            const token = jwt.sign(payload, keys.secretOrKey, { expiresIn: '1d' });

            return res.status(200).json({
                success: true,
                message: 'Inicio de sesión exitoso',
                token: `Bearer ${token}`,
                data: payload
            });

        } catch (err) {
            console.error(err);
            return res.status(500).json({ success: false, message: 'Error en el inicio de sesión', error: err });
        }
    },

    logout(req, res) {
        // En JWT no hay forma real de invalidar el token sin una blacklist
        // Solo se elimina del lado cliente (en React Native o Web)
        return res.status(200).json({
            success: true,
            message: 'Sesión cerrada correctamente'
        });
    }
};
