import { StyleSheet } from "react-native";
import LinearGradient from 'react-native-linear-gradient';
import { Mycolors } from "../../theme/AppTheme";

const HomeStyles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: 'white',
    },
    imageBackground: {
        width: '100%',
        height: '100%',
        opacity: 0.7,
        bottom: '15%',
    },
    form: {
        width: '100%',
        height: '70%',
        backgroundColor: 'white',
        position: 'absolute',
        bottom: 0,
        borderTopLeftRadius: 40,
        borderTopRightRadius: 40,
        padding: 30,
    },
    formText: {
        fontWeight: 'bold',
        fontSize: 16
    },
    formRegister: {
        flexDirection: 'row',
        justifyContent: 'center',
        marginTop: 30,
    },
    formRegisterText: {
        fontStyle: 'italic',
        color: Mycolors.principal,
        borderBottomWidth: 1,
        borderBottomColor: 'orange'
        
        ,
        fontWeight: 'bold',
        marginLeft: 10,
    },
    logoContainer: {
        position: 'absolute',
        alignSelf: 'center',
        top: '15%',
    },
    logoImage: {
        width: 100,
        height: 100,
    },
    logoText: {
        color: 'white',
        textAlign: 'center',
        fontSize: 20,
        marginTop: 10,
        fontWeight: 'bold',
    },
    optionsContainer:{
        flexDirection: 'row',
      },
      tpodoc:{
        fontSize: 15,
        textAlign: 'center',
        marginTop: 25,
        marginBottom: 10
      },




})
export default HomeStyles;