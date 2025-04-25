import React, { version, useEffect } from 'react'
import { View,Text, StyleSheet, Image, ToastAndroid } from "react-native";
import { RoundedButton } from '../../components/RoundedButton';
import  WavyCircle from '../../components/Logo';
import { useNavigation } from '@react-navigation/native';
import { StackNavigationProp, StackScreenProps } from '@react-navigation/stack';
import { RootStackParamList } from '../../../../App';
import HomeViewModel from './ViewModel';

interface Props extends StackScreenProps<RootStackParamList, 'HomeScreen'>{};
export const HomeScreen = ({navigation, route}: Props) => {
        const { correo, contrasena, errorMessage,user, onChange } = HomeViewModel();
    
        //const navigation = useNavigation<StackNavigationProp<RootStackParamList>>();
    
        useEffect(() => {
            if (errorMessage != '') {
                ToastAndroid.show(errorMessage, ToastAndroid.LONG);
            }
        }, [errorMessage]);
    
        useEffect(() => {
            if (user?.correo !== null && user?.documento !== undefined) {
            navigation.replace('ProfileInfoScreen');
            }
            }, [user]);
      
    //const navigation = useNavigation<StackNavigationProp<RootStackParamList>>();
  return (
    <View style={styles.container}>
    {/* 🟡 WavyCircle amarillo detrás */}
<WavyCircle size={550} color="#ffcc00" style={{ position: 'absolute', top: '-5.5%', right: '-10%', opacity: 0.5, }} />

{/* ⚫ WavyCircle negro principal */}
<WavyCircle size={270} color="#000000" style={{ position: 'absolute', top: '10%', right: '17%', opacity: 0.8, }} />


    <View style={styles.logoContainer}>
        <Image source={require('../../../../assets/log.png')}
        style={styles.logoImage}/>
        <Text style={styles.logoText}>DSRTV</Text>
    </View>

    <View style={{ flex: 1, top: '60%' ,alignItems: 'center'  }}>
        <RoundedButton text='Iniciar Sesion' onPress={() => navigation.navigate('LoginScreen')}></RoundedButton>
        <RoundedButton text='Registrate' onPress={() => navigation.navigate('RegisterScreen')} ></RoundedButton>
    </View>

    <View>
    <Text style={styles.versionText}>Versión 1.0.0 • © {new Date().getFullYear()}</Text>
    </View>
</View>
    )
}

const styles = StyleSheet.create({
    container: {
    flex: 1,
    backgroundColor: 'white',
    },
    logoContainer: {
        position: 'absolute',
        alignSelf: 'center',
        top: '15%',
        },
        logoImage: {
            width: 200,
            height: 200,
            borderRadius: 100, // Hace que la imagen sea circular
        },
        logoText: {
        color: 'black',
        textAlign: 'center',
        fontSize: 30,
        marginTop: '10%',
        fontWeight: 'bold',
        },
        versionText:{
            fontSize: 12,
  color: 'gray',
  textAlign: 'center',
  position: 'absolute',
  bottom: 10, // Para que quede pegado abajo
  width: '100%',
        }
        });