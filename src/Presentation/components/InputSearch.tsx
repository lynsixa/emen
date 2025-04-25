import React from 'react';
import { View, TextInput, StyleSheet, Text } from 'react-native';
import Icon from 'react-native-vector-icons/Ionicons';

interface Props {
  placeholder?: string;
  value: string;
  onChange: (text: string) => void;
}

const SearchInput = ({ placeholder = "Buscar por usuario...", value, onChange }: Props) => {
  return (
    <View style={styles.container}>
      <Icon name="search-outline" size={20} color="#999" style={styles.icon} />
      <TextInput
        placeholder={placeholder}
        value={value}
        onChangeText={onChange}
        style={styles.input}
        autoCapitalize="none"
        autoCorrect={false}
        keyboardType="numeric"
        maxLength={10} // Por si el usuario es tipo documento
      />
    </View>
  );
};

export default SearchInput;

const styles = StyleSheet.create({
  container: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#f1f1f1',
    marginHorizontal: 15,
    borderRadius: 40,
    paddingHorizontal: 15,
    paddingVertical: 8,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 1 },
    shadowOpacity: 0.1,
    shadowRadius: 2,
    elevation: 2,
    borderWidth: 1,
  },
  icon: {
    marginRight: 10,
  },
  input: {
    flex: 1,
    fontSize: 16,
    color: '#333',
  },
});
