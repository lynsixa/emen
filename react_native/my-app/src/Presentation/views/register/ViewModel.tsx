import React, { useState } from 'react';
import { ApiDelivery } from '../../../Data/sources/remote/api/ApiDelivery';

const RegisterViewModel = () => {
  
  // Estado de los valores
  const [values, setValues] = useState({
    Nombres: '',
    Apellidos: '',
    Documento: '',
    Correo: '',
    FechaDeNacimiento: '',
    Contraseña: '',
    Tipo_de_documento_idTipodedocumento: '',  // Este es el estado para el tipo de documento seleccionado
  });

  const onChange = (property: string, value: any) => {
    setValues({ ...values, [property]: value });
  };

  const register = async () => {
    console.log('🟡 Se presionó el botón de registrar');
  
    try {
      console.log('📤 Enviando estos datos:', values);
      const response = await ApiDelivery.post('/usuario/create', values);
      console.log('🟢 RESPUESTA DEL BACKEND:', JSON.stringify(response.data));
    } catch (error: any) {
      console.log('🔴 ERROR:', error?.response?.data || error.message);
    }
  };

  return {
    ...values,
    onChange,
    register
  };
};

export default RegisterViewModel;
