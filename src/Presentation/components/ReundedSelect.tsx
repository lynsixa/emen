import React from 'react'
import { TouchableOpacity, Text, StyleSheet } from 'react-native';
import { Mycolors } from '../theme/AppTheme';


interface Props {
  text: string
  onPress: () => void,
  isSelected:boolean 
}
export const RoundedSelect = ({text, onPress, isSelected}: Props) => {
  return (
      <TouchableOpacity
          style={[styles.RoundedButton,  isSelected && styles.selectedButton]}
          onPress={() => onPress()} >
          <Text style={styles.textButton} >{text}</Text>
      </TouchableOpacity>
    )
  }
  
  const styles = StyleSheet.create({
      RoundedButton: {
          width: '50%',
          height: 50,
          alignItems: 'center',
          justifyContent: 'center',
          borderRadius: 15,
          borderWidth: 1,
          borderColor: 'black'
      },
      selectedButton:{
        backgroundColor: Mycolors.intermedio,
        opacity: 0.5
      },
      textButton: {
          color: 'black',
      }
  });
  