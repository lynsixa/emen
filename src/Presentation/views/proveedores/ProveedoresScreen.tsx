import React, {useState, useEffect} from 'react';
import { View, Text, FlatList, StyleSheet, Image } from 'react-native';
import { StackScreenProps } from '@react-navigation/stack';
import { RootStackParamList } from '../../../../App';
import  styles from "./Style";
import SearchInput from '../../components/InputSearch';
import WavyCircle from '../../components/Logo';
import { getProveedores } from '../../../Data/sources/remote/api/ApiGero';

interface Props extends StackScreenProps<RootStackParamList, 'ProveedorScreen'> {}

interface Proveedor {
  idProveedor: number;
  nombreproveedor: string;
  Telefono: number;
  productos: number;
}

export const ProveedorScreen = ({ navigation }: Props) => {
  const [proveedores, setProveedores] = React.useState<Proveedor[]>([]);
  const [nombreproveedor, setName] = React.useState('');
  const [Telefono, setTelefono] = React.useState('');
  const [productos, setProductos] = React.useState('');


   useEffect(() => {
      fetchProducts();
      }, []);
  
      const fetchProducts = async () => {
      const data = await getProveedores();
      
      setProveedores(data);
      };
  
  const renderItem = ({ item }: { item: Proveedor }) => (
    <View style={styles.card}>
      <Text style={styles.title}>ID: {item.idProveedor}</Text>
      <Text style={styles.text}>Nombre: {item.nombreproveedor}</Text>
      <Text style={styles.text}>Teléfono: {item.Telefono}</Text>
      <Text style={styles.text}>Producto: {item.productos}</Text>
    </View>
  );

  return (
    <View style={styles.container}>

      <WavyCircle size={350} color="#c24a46" style={{ position: 'absolute', top: '12.5%', right: '50%', opacity: 0.5, }} />            
      <WavyCircle size={350} color="#c24a46" style={{ position: 'absolute', top: '-30.5%', right: '-20%', opacity: 0.5, }} />            
      <WavyCircle size={150} color="#c24a46" style={{ position: 'absolute', top: '30.5%', right: '-1%', opacity: 0.5, }} />            
      <WavyCircle size={350} color="#c24a46" style={{ position: 'absolute', top: '70.5%', right: '-40%', opacity: 0.5, }} />            
      <WavyCircle size={150} color="#c24a46" style={{ position: 'absolute', top: '80.5%', right: '60%', opacity: 0.5, }} />            

      <SearchInput 
      value={nombreproveedor} 
      placeholder="Buscar Proveedor por ID" 
      onChange={(text) => {
        setName(text);
        if (text === '') {
        fetchProducts(); // Reset to all providers when input is cleared
        } else {
        const filtered = proveedores.filter((proveedor) =>
          proveedor.idProveedor.toString().includes(text)
        );
        setProveedores(filtered);
        }
      }} 
      />
      
      <Text style={styles.header}>Lista de Proveedores</Text>
      <View style={styles.cont}>
      <FlatList
        data={proveedores}
        renderItem={renderItem}
        keyExtractor={(item) => item.idProveedor.toString()}
        contentContainerStyle={{ paddingBottom: 100 }}
      />
      </View>
      
    </View>
  );
};
