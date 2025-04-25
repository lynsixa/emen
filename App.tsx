import * as React from 'react';
import { useFonts } from "expo-font";
import {NavigationContainer} from '@react-navigation/native';
import {createNativeStackNavigator} from '@react-navigation/native-stack';
import { TouchableOpacity, Text } from "react-native";
import { HomeScreen } from './src/Presentation/views/home/home';
import { LoginScreen } from './src/Presentation/views/home/login';
import { RegisterScreen } from './src/Presentation/views/register/register';
import { ProfileInfoScreen } from './src/Presentation/views/profile/info/ProfileInfo';
import HomeScreenn from './src/Presentation/views/inicio/HomeScreen';
import VentasScreen from './src/Presentation/views/ventas/VentasScreen';
import { Mycolors } from './src/Presentation/theme/AppTheme';
import Icon from 'react-native-vector-icons/Ionicons';
import { ProveedorScreen } from './src/Presentation/views/proveedores/ProveedoresScreen';

export type RootStackParamList = {
    HomeScreen: undefined;
    LoginScreen: undefined;
    RegisterScreen: undefined;
    ProfileInfoScreen: undefined;
    HomeScreenn: undefined;
    VentasScreen: undefined;
    ProveedorScreen: undefined;
    };

const Stack = createNativeStackNavigator<RootStackParamList>();

function App() {
    const [fontsLoaded] = useFonts({
        'SpecialFont': require('./assets/fonts/PoetsenOne-Regular.ttf'),
      });
      
  if (!fontsLoaded) return null;

  const customTitle = () => (
    <Text style={{ fontFamily: 'SpecialFont', fontSize: 25, color: Mycolors.principal, marginLeft: 20 }}>
      Gero y Natis
    </Text>
  );


    return (
        <NavigationContainer>
            <Stack.Navigator screenOptions={{ headerShown: false }}>
                <Stack.Screen
                    name='HomeScreen'
                    component={HomeScreen} />
                <Stack.Screen
                    name='LoginScreen'
                    component={LoginScreen}
                    options={{ headerShown: true, title: 'Iniciar' }} />
                    <Stack.Screen
                    name='RegisterScreen'
                    component={RegisterScreen}
                    options={{ headerShown: true, title: '' }} />
                    <Stack.Screen
                    name='ProfileInfoScreen'
                    component={ProfileInfoScreen}
                    options={{ headerShown: true, title: '' }} />
                  <Stack.Screen name="ProveedorScreen" 
                  component={ProveedorScreen} 
                  options={{ headerShown: true, headerShadowVisible: false ,headerBackVisible: false,
                    title: 'Gero y Natis', 
                    headerTitle:customTitle, headerLeft: () => null,
                     }} />
                  <Stack.Screen 
                    name="HomeScreenn" 
                     component={HomeScreenn}
                     options={{ headerShown: true, headerShadowVisible: false ,headerBackVisible: false,
                      title: 'Gero y Natis', 
                      headerTitle:customTitle, headerLeft: () => null,
                       }} />
                       <Stack.Screen 
                    name="VentasScreen" 
                     component={VentasScreen}
                     options={{ headerShown: true, headerShadowVisible: false ,headerBackVisible: false,
                      title: 'Gero y Natis', 
                      headerTitle:customTitle, headerLeft: () => null,
                       }} />


{/*<Stack.Screen 
      name="ProductScreen" component={ProductScreen} options={({ navigation }) => ({headerTitle: customTitle, headerTintColor: Mycolors.principal, headerRight: () => (
        <TouchableOpacity 
          onPress={() => navigation.navigate('VentasScreen')} 
          style={{ marginRight: 15 }}
        >
          <Icon name="cart-outline" size={24} color={Mycolors.principal} />
        </TouchableOpacity>
      ),
    })} />*/}


       

                {/*<Stack.Screen name="Profile" component={ProfileScreen} />*/}
            </Stack.Navigator>
        </NavigationContainer>
    );
};

export default App;