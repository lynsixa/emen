import React from 'react';
import { Text, View, Image, ScrollView } from 'react-native';
import { RoundedButton } from '../../components/RoundedButton';
import { CustomTextInput } from '../../components/CustomTextInput';
import useViewModel from './ViewModel';
import { Picker } from '@react-native-picker/picker';
import styles from './Styles';

export const RegisterScreen = () => {
  const {
    Nombres, Apellidos, Documento, Correo, FechaDeNacimiento, Contraseña, Tipo_de_documento_idTipodedocumento,
    onChange,
    register,
  } = useViewModel();

  // Definir los tipos de documento
  const documentTypes = [
    { id: '1', label: 'Cédula de ciudadanía' },
    { id: '2', label: 'Pasaporte' },
    { id: '3', label: 'Cédula de extranjería' },
    { id: '4', label: 'Permiso especial de permanencia' },
  ];

  return (
    <View style={styles.container}>
      <Image source={require('../../../../assets/fondo.png')} style={styles.imageBackground} />
      <View style={styles.logoContainer}>
        <Image source={require('../../../../assets/logo.png')} style={styles.logoImage} />
        <Text style={styles.logoText}>DSRTV</Text>
      </View>

      <View style={styles.form}>
        <ScrollView>
          <Text style={styles.formText}>REGÍSTRATE</Text>

          <CustomTextInput
            image={require('../../../../assets/user.png')}
            placeholder="Nombres"
            keyboardType="default"
            property="Nombres"
            onChangeText={onChange}
            value={Nombres}
          />

          <CustomTextInput
            image={require('../../../../assets/my_user.png')}
            placeholder="Apellidos"
            keyboardType="default"
            property="Apellidos"
            onChangeText={onChange}
            value={Apellidos}
          />

          <Text style={{ color: 'white', marginBottom: 5, marginTop: 10 }}>Tipo de Documento</Text>
          <View style={{ backgroundColor: 'white', borderRadius: 10, overflow: 'hidden' }}>
            <Picker
              selectedValue={Tipo_de_documento_idTipodedocumento} // Este es el valor seleccionado
              onValueChange={(value) => onChange('Tipo_de_documento_idTipodedocumento', value)} // Actualiza el valor seleccionado
              style={{ height: 50 }}
            >
              <Picker.Item label="Seleccione tipo de documento..." value="" />
              {documentTypes.map((item) => (
                <Picker.Item label={item.label} value={item.id} />
              ))}
            </Picker>
          </View>

          <CustomTextInput
            image={require('../../../../assets/id-card.png')}
            placeholder="Documento"
            keyboardType="numeric"
            property="Documento"
            onChangeText={onChange}
            value={Documento}
          />

          <CustomTextInput
            image={require('../../../../assets/email.png')}
            placeholder="Correo Electrónico"
            keyboardType="email-address"
            property="Correo"
            onChangeText={onChange}
            value={Correo}
          />

          <CustomTextInput
            image={require('../../../../assets/calendar.png')}
            placeholder="Fecha de Nacimiento (YYYY-MM-DD)"
            keyboardType="default"
            property="FechaDeNacimiento"
            onChangeText={onChange}
            value={FechaDeNacimiento}
          />

          <CustomTextInput
            image={require('../../../../assets/password.png')}
            placeholder="Contraseña"
            keyboardType="default"
            property="Contraseña"
            onChangeText={onChange}
            value={Contraseña}
            secureTextEntry
          />

          <View style={{ marginTop: 10 }}>
            <RoundedButton text="CONFIRMAR" onPress={register} />
          </View>
        </ScrollView>
      </View>
    </View>
  );
};
