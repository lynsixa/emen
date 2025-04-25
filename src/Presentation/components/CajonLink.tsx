import React from 'react'
import { StyleSheet, TouchableOpacity, Text } from 'react-native';
import Icon from "react-native-vector-icons/Ionicons";

interface Props {
    text: string
    onPress: () => void,
    icon: string
    color: string
  }

export const CajonLink = ({ text, onPress, icon, color }: Props) => {
  return (
    <TouchableOpacity
    style={styles.link} onPress={() => onPress()} >
            <Text style={styles.textButton} >{text}</Text>
            <Icon name={icon} size={15} color={color} style={styles.icon} />
    </TouchableOpacity>
  )
}

const styles = StyleSheet.create({
  link: {
    width: '40%',
    height: 65,
    backgroundColor: 'white',
    flexDirection: 'row',        // elementos uno al lado del otro
    justifyContent: 'center',    // centrar horizontalmente
    alignItems: 'center',        // centrar verticalmente
    borderWidth: 1,
    borderColor: 'black',
    borderRadius: 15,
  },
  textButton: {
    fontSize: 15,
    fontWeight: 'bold',
    marginRight: 8, // espacio entre texto e ícono
  },
  icon: {
    fontSize: 20
  }
});

export default CajonLink;
