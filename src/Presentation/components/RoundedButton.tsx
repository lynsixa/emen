import React from 'react'
import { TouchableOpacity, Text, StyleSheet } from 'react-native';
import { Mycolors } from '../theme/AppTheme';


interface Props {
  text: string
  onPress: () => void,
}
export const RoundedButton = ({text, onPress}: Props) => {
  return (
      <TouchableOpacity
          style={styles.RoundedButton}
          onPress={() => onPress()} >
          <Text style={styles.textButton} >{text}</Text>
      </TouchableOpacity>
    )
  }
  
  const styles = StyleSheet.create({
      RoundedButton: {
          width: '70%',
          height: 50,
          backgroundColor: Mycolors.intermedio,
          alignItems: 'center',
          justifyContent: 'center',
          borderRadius: 15,
          marginTop: 30,
          borderColor: 'black',
          borderWidth: 2,
          opacity:0.5
      },
      textButton: {
          color: 'black',
      }
  });
  