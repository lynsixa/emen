import React, {useState, useEffect} from 'react';
import { TouchableOpacity, Text, StyleSheet, View } from 'react-native';
import { getVentas } from '../../Data/sources/remote/api/ApiGero';

interface Ventas {
  idFactura: number;
  usuario: string;
  total: number;
  fechaventa: string;
  nombre: string;
  apellido: string;
  estadi: string;
  subtotal: number;
  productos: string;
}

interface Props {
  onPress: () => void;
  venta: Ventas;
}

const formatDate = (dateString: string) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('es-CO', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
};

const VentaButton = ({ onPress, venta }: Props) => {
  const cliente = venta.productos.split(',')[0]?.split(':')[5] || 'Sin cliente';
  
  return (
    <TouchableOpacity style={styles.botonVenta} onPress={onPress}>
      <Text style={styles.ventaTexto}>Factura #{venta.idFactura}</Text>
      <Text style={styles.ventaText}>Cliente: {cliente}</Text>
      <Text style={styles.ventaTex}>Total: ${venta.total}</Text>
      <View style={styles.fechaContenedor}>
        <Text style={styles.fechaText}>{formatDate(venta.fechaventa)}</Text>
      </View>
    </TouchableOpacity>
  );
};

const styles = StyleSheet.create({
  botonVenta: {
    width: '100%',
    backgroundColor: 'white',
    borderRadius: 10,
    borderWidth: 1,
    borderColor: 'black',
    padding: 15,
    marginBottom: 10,
    shadowColor: '#000',
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.1,
    shadowRadius: 3,
    elevation: 3,
  },
  fechaContenedor: {
    alignItems: 'flex-end',
    marginTop: 5,
  },
  fechaText: {
    fontSize: 12,
    color: '#666',
  },
  ventaTexto: {
    fontWeight: 'bold',
    fontSize: 18,
    marginBottom: 8,
    color: '#333',
  },
  ventaText: {
    fontSize: 14,
    color: '#555',
    marginBottom: 4,
  },
  ventaTex: {
    fontSize: 14,
    color: '#555',
    marginTop: 4,
    marginBottom: 4,
  },
});

export default VentaButton;
