import React, {useEffect, useState} from 'react';
import { View, Text, StyleSheet, ScrollView, TouchableOpacity, TextInput } from 'react-native';
import Modal from 'react-native-modal';
import styles from "./Styles";
import VentaButton from '../../components/CajonVentas';
import SearchInput from '../../components/InputSearch';
import { getVentas, postVentas } from '../../../Data/sources/remote/api/ApiGero';
import { StackScreenProps } from '@react-navigation/stack';
import { RootStackParamList } from '../../../../App';
import { Scroll } from 'lucide-react-native';
import { Mycolors } from '../../theme/AppTheme';
import WavyCircle from '../../components/Logo';

interface Props extends StackScreenProps<RootStackParamList, 'VentasScreen'> {}

interface Ventas {
  idFactura: number;
  fechaventa: string;
  subtotal: number;
  total: number;
  usuario: string;
  nombreusuario: string;
  apellidousuario: string;
  estado: string;
  idProducto: number;
  cantidad: number;
  precio: number; 
  productos: string;
  nombre: string;
  apellido: string;
  estadi: string;
}

interface ProductoForm {
  idProducto: string;
  cantidad: string;
  cliente: string;
}

const VentasScreen = ({ navigation }: Props) => {
  const [ventas, setVentas] = useState<Ventas[]>([]);
  const [selectedVenta, setSelectedVenta] = useState<Ventas | null>(null);
  const [isModalVisible, setModalVisible] = useState(false);
  const [isAddModalVisible, setAddModalVisible] = useState(false);
  const [usuario, setUsuario] = useState('');
  const [documento, setDocumento] = useState('');
  const [productos, setProductos] = useState<ProductoForm[]>([{ idProducto: '', cantidad: '', cliente: '' }]);

  const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('es-CO', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    });
  };

  useEffect(() => {
    fetchVentas();
  }, []);

   const fetchVentas = async () => {
     const data = await getVentas();
     
     setVentas(data);
     };

  const handlePress = (venta: Ventas) => {
    setSelectedVenta(venta);
    setModalVisible(true);
  };

  const toggleModal = () => {
    setModalVisible(!isModalVisible);
  };

  const toggleAddModal = () => {
    setAddModalVisible(!isAddModalVisible);
  };

  const handleAddProduct = () => {
    setProductos([...productos, { idProducto: '', cantidad: '', cliente: '' }]);
  };

  const handleProductChange = (index: number, field: keyof ProductoForm, value: string) => {
    const newProductos = [...productos];
    newProductos[index] = { ...newProductos[index], [field]: value };
    setProductos(newProductos);
  };

  const handleSubmit = async () => {
    try {
      const ventaData = {
        fechaventa: new Date().toISOString(),
        id_estadof: 1, // Estado por defecto
        documento: parseInt(documento),
        productos: productos.map(p => ({
          idProducto: parseInt(p.idProducto),
          cantidad: parseInt(p.cantidad),
          cliente: parseInt(p.cliente)
        }))
      };

      await postVentas(ventaData);
      setAddModalVisible(false);
      fetchVentas(); // Actualizar la lista de ventas
      setProductos([{ idProducto: '', cantidad: '', cliente: '' }]); // Resetear el formulario
      setDocumento('');
    } catch (error) {
      console.error('Error al crear la venta:', error);
      // Aquí podrías mostrar un mensaje de error al usuario
    }
  };

  return (
    <View style={styles.container}>
       <WavyCircle size={350} color="#c24a46" style={{ position: 'absolute', top: '-10.5%', right: '50%', opacity: 0.5, }} />            
       <WavyCircle size={300} color="#c24a46" style={{ position: 'absolute', top: '30.5%', right: '-50%', opacity: 0.5, }} />            
       <WavyCircle size={350} color="#c24a46" style={{ position: 'absolute', top: '70.5%', right: '50%', opacity: 0.5, }} />            
       <WavyCircle size={150} color="#c24a46" style={{ position: 'absolute', top: '40.5%', right: '50%', opacity: 0.5, }} />            
       <WavyCircle size={150} color="#c24a46" style={{ position: 'absolute', top: '9.5%', right: '-10%', opacity: 0.5, }} />            


      <View>
        <SearchInput value={usuario} onChange={setUsuario} />
      </View>
      <Text style={styles.titulo}>Ventas</Text>
      <View style={styles.fila}>
        <ScrollView>
          <View style={styles.container2}>
            {ventas.map((venta) => (
              <VentaButton key={venta.idFactura} venta={venta} onPress={() => handlePress(venta)} />
            ))}
          </View>
        </ScrollView>
      </View>

      <TouchableOpacity style={styles.floatingButton} onPress={toggleAddModal}>
        <Text style={styles.floatingButtonText}>+</Text>
      </TouchableOpacity>

      <Modal isVisible={isAddModalVisible} onBackdropPress={toggleAddModal}>
        <View style={styles.addModalContainer}>
          <Text style={styles.modalTitle}>Nueva Venta</Text>
          <ScrollView style={styles.modalContent}>
            <View style={styles.formContainer}>
              <View style={styles.inputContainer}>
                <Text style={styles.label}>Documento del Vendedor</Text>
                <TextInput
                  style={styles.input}
                  value={documento}
                  onChangeText={setDocumento}
                  keyboardType="numeric"
                  placeholder="Ingrese el documento"
                />
              </View>

              <Text style={styles.modalSubtitle}>Productos</Text>
              {productos.map((producto, index) => (
                <View key={index} style={styles.productContainer}>
                  <View style={styles.inputContainer}>
                    <Text style={styles.label}>ID del Producto</Text>
                    <TextInput
                      style={styles.input}
                      value={producto.idProducto}
                      onChangeText={(value) => handleProductChange(index, 'idProducto', value)}
                      keyboardType="numeric"
                      placeholder="ID del producto"
                    />
                  </View>
                  <View style={styles.inputContainer}>
                    <Text style={styles.label}>Cantidad</Text>
                    <TextInput
                      style={styles.input}
                      value={producto.cantidad}
                      onChangeText={(value) => handleProductChange(index, 'cantidad', value)}
                      keyboardType="numeric"
                      placeholder="Cantidad"
                    />
                  </View>
                  <View style={styles.inputContainer}>
                    <Text style={styles.label}>ID del Cliente</Text>
                    <TextInput
                      style={styles.input}
                      value={producto.cliente}
                      onChangeText={(value) => handleProductChange(index, 'cliente', value)}
                      keyboardType="numeric"
                      placeholder="ID del cliente"
                    />
                  </View>
                </View>
              ))}

              <TouchableOpacity style={styles.addProductButton} onPress={handleAddProduct}>
                <Text style={styles.addProductButtonText}>+ Agregar Otro Producto</Text>
              </TouchableOpacity>

              <TouchableOpacity style={styles.submitButton} onPress={handleSubmit}>
                <Text style={styles.submitButtonText}>Crear Venta</Text>
              </TouchableOpacity>
            </View>
          </ScrollView>
          <TouchableOpacity style={styles.closeButton} onPress={toggleAddModal}>
            <Text style={styles.closeButtonText}>Cerrar</Text>
          </TouchableOpacity>
        </View>
      </Modal>

      <Modal isVisible={isModalVisible} onBackdropPress={toggleModal}>
        <View style={styles.modalContainer}>
          <Text style={styles.modalTitle}>Detalle de Factura</Text>
          <ScrollView style={styles.modalContent}>
            {selectedVenta && (
              <>
                <View style={styles.modalRow}>
                  <Text style={styles.modalLabel}>ID Factura:</Text>
                  <Text style={styles.modalValue}>{selectedVenta.idFactura}</Text>
                </View>
                <View style={styles.modalRow}>
                  <Text style={styles.modalLabel}>Fecha:</Text>
                  <Text style={styles.modalValue}>{formatDate(selectedVenta.fechaventa)}</Text>
                </View>
                <View style={styles.modalRow}>
                  <Text style={styles.modalLabel}>Subtotal:</Text>
                  <Text style={styles.modalValue}>${selectedVenta.subtotal.toLocaleString('es-CO')}</Text>
                </View>
                <View style={styles.modalRow}>
                  <Text style={styles.modalLabel}>Total:</Text>
                  <Text style={styles.modalValue}>${selectedVenta.total.toLocaleString('es-CO')}</Text>
                </View>
                <View style={styles.modalRow}>
                  <Text style={styles.modalLabel}>Vendedor:</Text>
                  <Text style={styles.modalValue}>{selectedVenta.nombre} {selectedVenta.apellido}</Text>
                </View>
                <View style={styles.modalRow}>
                  <Text style={styles.modalLabel}>Documento:</Text>
                  <Text style={styles.modalValue}>{selectedVenta.usuario}</Text>
                </View>
                <View style={styles.modalRow}>
                  <Text style={styles.modalLabel}>Estado:</Text>
                  <Text style={styles.modalValue}>{selectedVenta.estadi}</Text>
                </View>
                <Text style={styles.modalSubtitle}>Productos:</Text>
                {selectedVenta.productos.split(', ').map((producto, index) => {
                  const [id, nombre, cantidad, valor, iva, cliente] = producto.split(':');
                  return (
                    <View key={index} style={styles.productoContainer}>
                      <View style={styles.modalRow}>
                        <Text style={styles.modalLabel}>Producto:</Text>
                        <Text style={styles.modalValue}>{nombre}</Text>
                      </View>
                      <View style={styles.modalRow}>
                        <Text style={styles.modalLabel}>Cantidad:</Text>
                        <Text style={styles.modalValue}>{cantidad}</Text>
                      </View>
                      <View style={styles.modalRow}>
                        <Text style={styles.modalLabel}>Valor Unitario:</Text>
                        <Text style={styles.modalValue}>${Number(valor).toLocaleString('es-CO')}</Text>
                      </View>
                      <View style={styles.modalRow}>
                        <Text style={styles.modalLabel}>IVA:</Text>
                        <Text style={styles.modalValue}>{iva}%</Text>
                      </View>
                      <View style={styles.modalRow}>
                        <Text style={styles.modalLabel}>Cliente:</Text>
                        <Text style={styles.modalValue}>{cliente}</Text>
                      </View>
                      {index < selectedVenta.productos.split(', ').length - 1 && (
                        <View style={styles.separator} />
                      )}
                    </View>
                  );
                })}
              </>
            )}
          </ScrollView>
          <TouchableOpacity style={styles.closeButton} onPress={toggleModal}>
            <Text style={styles.closeButtonText}>Cerrar</Text>
          </TouchableOpacity>
        </View>
      </Modal>
    </View>
  );
};

export default VentasScreen;


