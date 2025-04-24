import React, { useState } from 'react';

const HomeViewModel = () => {
  const [values, setValues] = useState({
    correo: '',
    contraseña: '',
  });

  const onChange = (property: string, value: any) => {
    setValues({
      ...values,
      [property]: value,
    });
  };

  return {
    ...values,
    onChange,
  };
};

export default HomeViewModel;
