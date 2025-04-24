import React, { useState } from 'react';
import { View, Image, Text, TouchableOpacity, StyleSheet } from 'react-native';
import { RoundedButton } from '../../components/RoundedButton';
import { StackNavigationProp } from '@react-navigation/stack';
import { RootStackParamList } from '../../../../App';
import { useNavigation } from '@react-navigation/native';
import { CustomTextInput } from '../../components/CustomTextInput';
import useViewModel from './ViewModel';
import styles from './Styles';

export const HomeScreen = () => {
  const { correo, contraseña, onChange } = useViewModel();
  const navigation = useNavigation<StackNavigationProp<RootStackParamList>>();

  return (
    <View style={styles.container}>
      <Image
        source={require('../../../../assets/fondo.png')}
        style={styles.imageBackground}
      />
      <View style={styles.logoContainer}>
        <Image
          source={require('../../../../assets/logo.png')}
          style={styles.logoImage}
        />
        <Text style={styles.logoText}>DSRTV</Text>
      </View>
      <View style={styles.form}>
        <Text style={styles.formText}>INGRESAR</Text>
        <CustomTextInput
          image={require('../../../../assets/email.png')}
          placeholder="Correo Electrónico"
          keyboardType="email-address"
          property="correo"
          onChangeText={onChange}
          value={correo}
        />
        <CustomTextInput
                image={require('../../../../assets/password.png')}
                placeholder="Contraseña"
                keyboardType="default"
                property="Contraseña"
                onChangeText={onChange}
                value={contraseña}
                secureTextEntry
              />
        <View style={{ marginTop: 30 }}>
          <RoundedButton
            text="ENVIAR"
            onPress={() => {
              console.log('Correo: ' + correo);
              console.log('Contraseña: ' + contraseña);
            }}
          />
        </View>
        <View style={styles.formRegister}>
          <Text>¿No tienes cuenta?</Text>
          <TouchableOpacity onPress={() => navigation.navigate('RegisterScreen')}>
            <Text style={styles.formRegisterText}>Regístrate</Text>
          </TouchableOpacity>
        </View>
      </View>
    </View>
  );
};


