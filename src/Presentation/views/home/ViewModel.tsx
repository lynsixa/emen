import React, { useState, useEffect } from 'react'
import { LoginAuthUseCase } from '../../../Domain/useCases/auth/Login.Auth';
import { SaveUserLocalUseCase } from '../../../Domain/useCases/auth/SaveUserLocal';
import { GetUserLocalUseCase } from '../../../Domain/useCases/auth/GetUserLocal';
import { useUserLocal } from '../../hooks/useUserLocal';

const HomeViewModel = () => {
const [errorMessage, setErrorMessage] = useState('');
const [values, setValues] = useState(
{
correo: '',
contrasena: ''
}
);

const { user, getUserSession } = useUserLocal();

useEffect(() => { //Se ejecuta cuando se instancia el viewModel
    getUserSession();
}, []); 

useEffect(() => {
    if (user) {
        console.log('Usuario: ' + JSON.stringify(user));
        // Aquí se manejará la redirección en el componente
    }
}, [user]);

const onChange = (property: string, value: any) => {
    setValues({ ...values, [property]: value });
};

const login = async () => {
    if (isValidForm()) {
        const response = await LoginAuthUseCase(values.correo, values.contrasena);
        console.log('Respuesta: ' + JSON.stringify(response));
        if(!response.success) {
            setErrorMessage(response.message);
            return false;
        }
        else {
            await SaveUserLocalUseCase(response.data);
            getUserSession();
            return true;
        }
    }
    return false;
};

const isValidForm = () => {
if (values.correo === '') {
setErrorMessage('El correo es requerido');
return false;
}
if (values.contrasena === '') {
setErrorMessage('La contraseña es requerida');
return false;
}return true;
}
return {
    ...values,
    user,
    onChange,
    login,
    errorMessage
    }
}
export default HomeViewModel;