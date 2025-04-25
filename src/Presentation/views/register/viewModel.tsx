import { useState } from 'react';
import { RegisterAuthUseCase } from '../../../Domain/useCases/auth/RegisterAuth';

const RegisterViewModel = () => {
    const [errorMessage, setErrorMessage] = useState('');
    const [values, setValues] = useState({
        Documento: '',
        tipoDocumento: '', // será convertido a 'Tipo de documento_idTipodedocumento'
        Nombres: '',
        Apellidos: '',
        Correo: '',
        Contraseña: '',
        confirmPassword: '',
        FechaDeNacimiento: '',
        Roles_idRoles: 4, // Rol por defecto
        CodigoNis_idCodigoNis: null,
        token: '',
        token_password: null,
        password_request: 0
    });

    const onChange = (property: string, value: any) => {
        setValues({ ...values, [property]: value });
    };

    const isValidDate = (dateString: string): boolean => {
        const regex = /^\d{4}-\d{2}-\d{2}$/;
        return regex.test(dateString);
    };

    const isValiForm = (): boolean => {
        if (values.Documento === '') {
            setErrorMessage('El documento es requerido');
            return false;
        }

        if (values.tipoDocumento === '') {
            setErrorMessage('El tipo de documento es requerido');
            return false;
        }

        if (values.Nombres === '') {
            setErrorMessage('El nombre es requerido');
            return false;
        }

        if (values.Apellidos === '') {
            setErrorMessage('El apellido es requerido');
            return false;
        }

        if (values.Correo === '') {
            setErrorMessage('El correo es requerido');
            return false;
        }

        if (values.FechaDeNacimiento === '') {
            setErrorMessage('La fecha de nacimiento es requerida');
            return false;
        }

        if (!isValidDate(values.FechaDeNacimiento)) {
            setErrorMessage('Formato de fecha inválido. Usa YYYY-MM-DD');
            return false;
        }

        if (values.Contraseña === '') {
            setErrorMessage('La contraseña es requerida');
            return false;
        }

        if (values.confirmPassword === '') {
            setErrorMessage('La confirmación de contraseña es requerida');
            return false;
        }

        if (values.Contraseña !== values.confirmPassword) {
            setErrorMessage('Las contraseñas no coinciden');
            return false;
        }

        return true;
    };

    const register = async () => {
        if (isValiForm()) {
            const payload = {
                Documento: values.Documento,
                Nombres: values.Nombres,
                Apellidos: values.Apellidos,
                Correo: values.Correo,
                Contraseña: values.Contraseña,
                FechaDeNacimiento: values.FechaDeNacimiento,
                token: '', // backend lo debe generar
                token_password: null,
                password_request: 0,
                'Tipo de documento_idTipodedocumento': values.tipoDocumento,
                Roles_idRoles: values.Roles_idRoles,
                CodigoNis_idCodigoNis: values.CodigoNis_idCodigoNis
            };

            const response = await RegisterAuthUseCase(payload as any);
            console.log('Resultado del registro:', response);
            return response.success;
        }

        return false;
    };

    const resetForm = () => {
        setValues({
            Documento: '',
            tipoDocumento: '',
            Nombres: '',
            Apellidos: '',
            Correo: '',
            Contraseña: '',
            confirmPassword: '',
            FechaDeNacimiento: '',
            Roles_idRoles: 4,
            CodigoNis_idCodigoNis: null,
            token: '',
            token_password: null,
            password_request: 0
        });
    };

    return {
        ...values,
        onChange,
        register,
        resetForm,
        errorMessage
    };
};

export default RegisterViewModel;
