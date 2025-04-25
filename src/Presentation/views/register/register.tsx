import React, { useEffect } from 'react';
import { View, Text, Image, ScrollView, ToastAndroid } from 'react-native';
import { RoundedButton } from '../../components/RoundedButton';
import useViewModel from './viewModel';
import { CustomTextInput } from '../../components/CustomTextInput';
import styles from './Styles';
import WavyCircle from '../../components/Logo';
import { RoundedSelect } from '../../components/ReundedSelect';

export const RegisterScreen = () => {
    const {
        Documento,
        tipoDocumento,
        Nombres,
        Apellidos,
        Correo,
        Contraseña,
        confirmPassword,
        FechaDeNacimiento,
        errorMessage,
        onChange,
        register,
        resetForm
    } = useViewModel();

    useEffect(() => {
        if (errorMessage !== '') {
            ToastAndroid.show(errorMessage, ToastAndroid.LONG);
        }
    }, [errorMessage]);

    const handleRegister = async () => {
        const success = await register();
        if (success) {
            resetForm();
        }
    };

    return (
        <View style={styles.container}>
            <WavyCircle size={130} color="#c24a46" style={{ position: 'absolute', top: '13%', right: '35%' }} />
            <WavyCircle size={90} style={{ position: 'absolute', top: '16%', right: '40%' }} />
            <Image source={require('../../../../assets/fondo.png')} style={styles.imageBackground} />

            <View style={styles.logoContainer}>
                <Image source={require('../../../../assets/log.png')} style={styles.logoImage} />
            </View>

            <View style={styles.form}>
                <ScrollView>
                    <Text style={styles.formText}>REGISTRARSE</Text>

                    {/* Efectos decorativos */}
                    <WavyCircle size={230} color="#c24a46" style={{ position: 'absolute', top: '73%', right: '-40%', opacity: 0.4 }} />
                    <WavyCircle size={230} color="#c24a46" style={{ position: 'absolute', top: '-8%', right: '-35%', opacity: 0.4 }} />
                    <WavyCircle size={30} color="#c24a46" style={{ position: 'absolute', top: '53%', right: '15%', opacity: 0.4 }} />
                    <WavyCircle size={50} color="#c24a46" style={{ position: 'absolute', top: '87%', right: '65%', opacity: 0.4 }} />

                    {/* Tipo de Documento */}
                    <Text style={styles.tpodoc}>Tipo de Documento</Text>
                    <View style={styles.optionsContainer}>
                        <RoundedSelect
                            text="CC"
                            isSelected={tipoDocumento === 'CC'}
                            onPress={() => onChange('tipoDocumento', 'CC')}
                        />
                        <RoundedSelect
                            text="TI"
                            isSelected={tipoDocumento === 'TI'}
                            onPress={() => onChange('tipoDocumento', 'TI')}
                        />
                    </View>

                    {/* Inputs */}
                    <CustomTextInput
                        image={require('../../../../assets/user.png')}
                        placeholder="Documento"
                        value={Documento}
                        KeyboardType="numeric"
                        property="Documento"
                        onChangeText={onChange}
                        secureTextEntry={false}
                    />

                    <CustomTextInput
                        image={require('../../../../assets/user.png')}
                        placeholder="Nombres"
                        value={Nombres}
                        KeyboardType="default"
                        property="Nombres"
                        onChangeText={onChange}
                        secureTextEntry={false}
                    />

                    <CustomTextInput
                        image={require('../../../../assets/user.png')}
                        placeholder="Apellidos"
                        value={Apellidos}
                        KeyboardType="default"
                        property="Apellidos"
                        onChangeText={onChange}
                        secureTextEntry={false}
                    />

                    <CustomTextInput
                        image={require('../../../../assets/calendar.png')}
                        placeholder="Fecha de Nacimiento (YYYY-MM-DD)"
                        value={FechaDeNacimiento}
                        KeyboardType="default"
                        property="FechaDeNacimiento"
                        onChangeText={onChange}
                        secureTextEntry={false}
                    />

                    <CustomTextInput
                        image={require('../../../../assets/email.png')}
                        placeholder="Correo electrónico"
                        value={Correo}
                        KeyboardType="email-address"
                        property="Correo"
                        onChangeText={onChange}
                        secureTextEntry={false}
                    />

                    <CustomTextInput
                        image={require('../../../../assets/password.png')}
                        placeholder="Contraseña"
                        value={Contraseña}
                        KeyboardType="default"
                        property="Contraseña"
                        onChangeText={onChange}
                        secureTextEntry={true}
                    />

                    <CustomTextInput
                        image={require('../../../../assets/confirm_password.png')}
                        placeholder="Confirmar Contraseña"
                        value={confirmPassword}
                        KeyboardType="default"
                        property="confirmPassword"
                        onChangeText={onChange}
                        secureTextEntry={true}
                    />

                    <View style={{ marginTop: 30 }}>
                        <RoundedButton text="GUARDAR" onPress={handleRegister} />
                    </View>
                </ScrollView>
            </View>
        </View>
    );
};
