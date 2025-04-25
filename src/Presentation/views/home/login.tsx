import React, { useEffect } from 'react';
import { View, Text, StyleSheet, Image, ToastAndroid } from 'react-native';
import { StackScreenProps } from '@react-navigation/stack';
import { RootStackParamList } from '../../../../App';
import { CustomTextInput } from '../../components/CustomTextInput';
import { RoundedButton } from '../../../Presentation/components/RoundedButton';
import styles from './Styles';
import HomeViewModel from "./ViewModel";

interface Props extends StackScreenProps<RootStackParamList, 'LoginScreen'> {}

export const LoginScreen = ({ navigation }: Props) => {
    const { correo, contrasena, errorMessage, user, onChange, login } = HomeViewModel();

    useEffect(() => {
        if (errorMessage) {
            ToastAndroid.show(errorMessage, ToastAndroid.LONG);
        }
    }, [errorMessage]);

    useEffect(() => {
        if (user) {
            navigation.replace('HomeScreen');
        }
    }, [user]);

    const handleLogin = async () => {
        const success = await login();
        if (success) {
            onChange('correo', '');
            onChange('contrasena', '');
        }
    };

    return (
        <View style={styles.container}>
            <Image
                source={require('../../../../assets/chef.jpg')}
                style={styles.imageBackground}
            />
            <View style={styles.logoContainer}>
                <Image
                    source={require('../../../../assets/delivery.png')}
                    style={styles.logoImage}
                />
                <Text style={styles.logoText}>DSRTV</Text>
            </View>

            <View style={styles.form}>
                <Text style={styles.formText}>INGRESAR</Text>

                <CustomTextInput
                    image={require('../../../../assets/email.png')}
                    placeholder='Correo'
                    value={correo}
                    KeyboardType='email-address'
                    property='correo'
                    onChangeText={onChange}
                    secureTextEntry={false}
                />

                <CustomTextInput
                    image={require('../../../../assets/password.png')}
                    placeholder='Contraseña'
                    value={contrasena}
                    KeyboardType='default'
                    secureTextEntry={true}
                    property='contrasena'
                    onChangeText={onChange}
                />

                <View style={{ marginTop: 30 }}>
                    <RoundedButton text='ENTRAR' onPress={handleLogin} />
                </View>

                <RoundedButton
                    text='VER CALENDARIO'
                    onPress={() => navigation.navigate('./CalendarioEventosScreen')}
                />
            </View>
        </View>
    );
};
