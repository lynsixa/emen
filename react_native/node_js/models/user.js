const db = require('../config/config');

const User = {
  create: (user, result) => {
    const sql = `INSERT INTO usuario (
                    Correo,
                    Nombres,
                    Apellidos,
                    Documento,
                    Contraseña,
                    FechaDeNacimiento,
                    token,
                    token_password,
                    password_request,
                    Tipo_de_documento_idTipodedocumento,
                    Roles_idRoles,
                  ) VALUES (?,?,?,?,?,?,?,?,?,?,?)`;

    db.query(
      sql,
      [
        user.Correo,  // Asegúrate de que 'Correo' esté en el formato correcto
        user.Nombres,
        user.Apellidos,
        user.Documento,
        user.Contraseña,  // La contraseña debe estar encriptada
        user.FechaDeNacimiento,
        user.token || '',  // Si no se envía un token, asigna uno vacío
        user.token_password || '',  // Si no hay token de password, asigna vacío
        user.password_request || 0,  // Si no se envía, asigna 0 por defecto
        user.Tipo_de_documento_idTipodedocumento || null,  // Tipo de documento
        user.Roles_idRoles || 1,  // Rol por defecto
        user.CodigoNis_idCodigoNis || null  // Código Nis
      ],
      (err, res) => {
        if (err) {
          console.log('Error al crear usuario: ', err);
          result(err, null);
        } else {
          console.log('ID del nuevo usuario: ', res.insertId);
          result(null, res.insertId);
        }
      }
    );
  }
};

module.exports = User;
