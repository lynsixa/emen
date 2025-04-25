import React, {useEffect, useState} from 'react'
import { Text, View, StyleSheet, TouchableOpacity, ScrollView, Image,   } from 'react-native';
import { useNavigation } from '@react-navigation/native';
import styles from './Styles';
import { StackNavigationProp, StackScreenProps } from '@react-navigation/stack';
import CajonLink from '../../components/CajonLink';
import { RootStackParamList } from '../../../../App';
import { getTopProducts } from '../../../Data/sources/remote/api/ApiGero';
import WavyCircle from '../../components/Logo';
import { Mycolors } from '../../theme/AppTheme';

interface Props extends StackScreenProps<RootStackParamList, 'HomeScreenn'>{};


interface TopProducts {
  idProducto: number;
  nombreproducto: string;
  precio: number;
  imagen: string;
  ventas: number;
  total: number;
}

const HomeScreenn = ({ navigation, route }: Props) => {
  const [products, setProducts] = useState<TopProducts[]>([]);
  const [nombreproducto, setName] = useState('');
  const [precio, setPrice] = useState('');
  const [imagen, setImage] = useState('');
  const [ventas, setVentas] = useState('');
  const [total, setTotal] = useState('');

  useEffect(() => {
    fetchProducts();
    }, []);

    const fetchProducts = async () => {
    const data = await getTopProducts();
    
    setProducts(data);
    };


  return (
    <View style={styles.container}>
 <WavyCircle size={350} color="#c24a46" style={{ position: 'absolute', top: '-10.5%', right: '50%', opacity: 0.5, }} />            
 <WavyCircle size={150} color="#c24a46" style={{ position: 'absolute', top: '10.5%', right: '-10%', opacity: 0.5, }} />            
 <WavyCircle size={100} color="#c24a46" style={{ position: 'absolute', top: '30%', right: '30%', opacity: 0.5, }} />            
 <WavyCircle size={350} color="#c24a46" style={{ position: 'absolute', top: '50.5%', right: '50%', opacity: 0.5, }} />            

 
 
 <View style={styles.links}>
                <CajonLink text='Productos' icon='pricetags' color='#CC0882' onPress={() => navigation.navigate('ProfileInfoScreen')}></CajonLink>
                <CajonLink text='Ventas' icon='receipt' color='#6495ed' onPress={() => navigation.navigate('VentasScreen')}></CajonLink>
                <CajonLink text='Proveedores' icon='cube' color='#9acd32' onPress={() => navigation.navigate('ProveedorScreen')}></CajonLink>
                <CajonLink text='Movimientos' icon='footsteps' color='#d2691e' onPress={() => navigation.navigate('ProfileInfoScreen')}></CajonLink>
            </View>

            <View style={styles.container2}>
              <Text style={styles.tuex}>Tus productos más vendidos</Text>
              </View>
              <ScrollView>
              <View style={styles.links}>
                {products.map((product) => (
                  <View key={product.idProducto} style={styles.cajon}>
          {/* Product ID Badge */}
          <View  style={styles.idBadge}>
            <Text style={styles.idText}>ID: {product.idProducto}</Text>
          </View>

          <Image source={{ uri: product.imagen}} style={styles.image} />

          <View style={styles.cajonText}>
            <View style={styles.infoRow}>
              <Text style={styles.label}>Nombre:</Text>
              <Text>{product.nombreproducto}</Text>
            </View>

            <View style={styles.infoRow}>
              <Text style={styles.label}>Ventas:</Text>
              <Text>{product.ventas}</Text>
            </View>

            <View style={styles.infoRow}>
              <Text style={styles.label}>Precio:</Text>
              <Text>$ {product.precio.toLocaleString('es-CO')}</Text>
            </View>

            <View style={styles.infoRow}>
              <Text style={styles.label}>Total:</Text>
              <Text>${Number(product.total).toLocaleString('es-CO')}</Text>
              </View>
          </View>
        </View>))}
        
        </View>
        </ScrollView>
              </View>
            
  )
}

export default HomeScreenn;
