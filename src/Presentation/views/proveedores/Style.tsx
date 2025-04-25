import { StyleSheet } from "react-native";

const styles = StyleSheet.create({
    container: {
      flex: 1,
      backgroundColor: '#FFF',
      padding: 20,
    },
    imageBackground: {
      width: '100%',
      height: 150,
      resizeMode: 'cover',
      borderRadius: 10,
      marginBottom: 10,
    },
    header: {
        fontSize: 20,
        fontWeight: 'bold',
        marginTop: 20,
        marginLeft: 20,
        marginBottom: 10,
    },
    card: {
      backgroundColor: 'white',
      padding: 15,
      borderRadius: 8,
      marginVertical: 5,
      borderWidth: 1,
    },
    cont:{
        
    },
    title: {
      fontWeight: 'bold',
      fontSize: 16,
      marginBottom: 5,
    },
    text: {
      fontSize: 14,
    },
  });

  export default styles;
  