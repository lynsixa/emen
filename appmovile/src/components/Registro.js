import React, { useEffect, useState } from 'react';
import { View, TextInput, Button, Text, Alert, Platform, TouchableOpacity } from 'react-native';
import { Picker } from '@react-native-picker/picker';
import DateTimePicker from '@react-native-community/datetimepicker';

const Registro = () => {
  const [nombres, setNombres] = useState('');
  const [apellidos, setApellidos] = useState('');
  const [documento, setDocumento] = useState('');
  const [correo, setCorreo] = useState('');
  const [contraseña, setContraseña] = useState('');
  const [fechaNacimiento, setFechaNacimiento] = useState(new Date());
  const [showDatePicker, setShowDatePicker] = useState(false);

  const [tipoDocumentoId, setTipoDocumentoId] = useState('');
  const [tiposDocumento, setTiposDocumento] = useState([]);

  // ⚠️ CAMBIA esta IP por la de tu computadora en la red local
  const API_URL = 'http://192.168.0.105:3000';

  useEffect(() => {
    fetch(`${API_URL}/api/tipos-documento`)
      .then(res => res.json())
      .then(data => setTiposDocumento(data))
      .catch(err => {
        console.error(err);
        Alert.alert('Error', 'No se pudieron cargar los tipos de documento');
      });
  }, []);

  const onChangeDate = (event, selectedDate) => {
    setShowDatePicker(false);
    if (selectedDate) {
      setFechaNacimiento(selectedDate);
    }
  };

  const handleSubmit = async () => {
    const usuario = {
      nombres,
      apellidos,
      documento,
      correo,
      contraseña,
      fechaNacimiento: fechaNacimiento.toISOString().split('T')[0],
      tipoDocumentoId,
    };

    try {
      const res = await fetch(`${API_URL}/api/registro`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(usuario),
      });

      const data = await res.json();
      Alert.alert('Registro', data.message || 'Usuario registrado correctamente');
    } catch (error) {
      Alert.alert('Error', 'Error al registrar usuario');
    }
  };

  return (
    <View style={{ padding: 20 }}>
      <TextInput placeholder="Nombres" value={nombres} onChangeText={setNombres} />
      <TextInput placeholder="Apellidos" value={apellidos} onChangeText={setApellidos} />
      <TextInput placeholder="Documento" value={documento} onChangeText={setDocumento} />
      <TextInput placeholder="Correo" value={correo} onChangeText={setCorreo} keyboardType="email-address" />
      <TextInput placeholder="Contraseña" value={contraseña} onChangeText={setContraseña} secureTextEntry />

      <TouchableOpacity onPress={() => setShowDatePicker(true)} style={{ marginTop: 10 }}>
        <Text>Fecha de nacimiento: {fechaNacimiento.toISOString().split('T')[0]}</Text>
      </TouchableOpacity>

      {showDatePicker && (
        <DateTimePicker
          value={fechaNacimiento}
          mode="date"
          display={Platform.OS === 'ios' ? 'spinner' : 'default'}
          onChange={onChangeDate}
        />
      )}

      <Text style={{ marginTop: 15 }}>Tipo de documento:</Text>
      <Picker
        selectedValue={tipoDocumentoId}
        onValueChange={(itemValue) => setTipoDocumentoId(itemValue)}
      >
        <Picker.Item label="Seleccione un tipo..." value="" />
        {tiposDocumento.map((tipo) => (
          <Picker.Item
            key={tipo.idTipodedocumento}
            label={tipo.Descripcion}
            value={tipo.idTipodedocumento}
          />
        ))}
      </Picker>

      <Button title="Registrar" onPress={handleSubmit} />
    </View>
  );
};

export default Registro;
