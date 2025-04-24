const User = require('../models/user');
const bcrypt = require('bcryptjs');  // Asegúrate de instalarlo con npm install bcryptjs

module.exports = {
  async register(req, res) {
    console.log(req.body);  // Verifica que los datos estén llegando correctamente

    const user = req.body;

    if (!user.Correo || !user.Contraseña) {
      return res.status(400).json({
        success: false,
        message: 'Faltan campos obligatorios (Correo o Contraseña)',
      })}
    

    try {
      // Encriptar la contraseña
      const hashedPassword = await bcrypt.hash(user.Contraseña, 10);
      user.Contraseña = hashedPassword; // La contraseña encriptada será almacenada en la base de datos

      // Otros valores opcionales, se asignan por defecto si no existen
      user.token = ''; 
      user.token_password = '';
      user.password_request = 0;
      user.Tipo_de_documento_idTipodedocumento = user.Tipo_de_documento_idTipodedocumento || null;
      user.Roles_idRoles = user.Roles_idRoles || 1;  // Asignar rol por defecto si no se envía
      user.CodigoNis_idCodigoNis = user.CodigoNis_idCodigoNis || null;

      // Crear el usuario en la base de datos
      User.create(user, (err, data) => {
        if (err) {
          return res.status(501).json({
            success: false,
            message: 'Error al crear al usuario',
            error: err,
          });
        } else {
          return res.status(201).json({
            success: true,
            message: 'Usuario creado con éxito',
            data: data,
          });
        }
      });

    } catch (err) {
      return res.status(500).json({
        success: false,
        message: 'Error al procesar la contraseña',
        error: err,
      });
    }
  }
};
