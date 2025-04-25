import { StyleSheet } from "react-native";
import { Mycolors } from "../../theme/AppTheme";

const Styles = StyleSheet.create({
    container: {
      flex: 1,
      padding: 12,
      backgroundColor: '#fff',
    },
    container2: {
      flex: 1,
      flexDirection: 'row',
      flexWrap: 'wrap',
      justifyContent: 'space-between',
      padding: 10,
      gap: 10,
    },
    titulo: {
      fontSize: 20,
      fontWeight: 'bold',
      marginTop: 20,
      marginLeft: 20,
    },
    fila: {
      flexDirection: 'row',
      justifyContent: 'space-between',
      marginBottom: 12,
    },
    // Estilos para el modal
    modalContainer: {
      backgroundColor: 'white',
      borderRadius: 10,
      padding: 20,
      maxHeight: '80%',
    },
    modalTitle: {
      fontSize: 20,
      fontWeight: 'bold',
      color: Mycolors.principal,
      marginBottom: 15,
      textAlign: 'center',
    },
    modalSubtitle: {
      fontSize: 16,
      fontWeight: 'bold',
      color: Mycolors.principal,
      marginTop: 15,
      marginBottom: 10,
    },
    modalContent: {
      maxHeight: '80%',
    },
    modalRow: {
      flexDirection: 'row',
      justifyContent: 'space-between',
      marginBottom: 8,
      paddingHorizontal: 5,
    },
    modalLabel: {
      fontWeight: 'bold',
      color: '#666',
      flex: 1,
    },
    modalValue: {
      flex: 2,
      textAlign: 'right',
      color: '#333',
    },
    productoContainer: {
      backgroundColor: '#f8f9fa',
      borderRadius: 8,
      padding: 10,
      marginBottom: 10,
    },
    separator: {
      height: 1,
      backgroundColor: '#ddd',
      marginVertical: 10,
    },
    closeButton: {
      backgroundColor: Mycolors.principal,
      padding: 12,
      borderRadius: 8,
      marginTop: 15,
      alignItems: 'center',
    },
    closeButtonText: {
      color: 'white',
      fontWeight: 'bold',
      fontSize: 16,
    },
    floatingButton: {
      position: 'absolute',
      right: 20,
      bottom: 20,
      width: 60,
      height: 60,
      borderRadius: 30,
      backgroundColor: Mycolors.principal,
      justifyContent: 'center',
      alignItems: 'center',
      elevation: 5,
      shadowColor: '#000',
      shadowOffset: {
        width: 0,
        height: 2,
      },
      shadowOpacity: 0.25,
      shadowRadius: 3.84,
    },
    floatingButtonText: {
      color: 'white',
      fontSize: 30,
      fontWeight: 'bold',
    },
    addModalContainer: {
      backgroundColor: 'white',
      borderRadius: 10,
      padding: 20,
      maxHeight: '80%',
    },
    formContainer: {
      marginTop: 10,
    },
    inputContainer: {
      marginBottom: 15,
    },
    label: {
      fontSize: 16,
      fontWeight: 'bold',
      color: '#333',
      marginBottom: 5,
    },
    input: {
      borderWidth: 1,
      borderColor: '#ddd',
      borderRadius: 8,
      padding: 12,
      fontSize: 16,
      backgroundColor: '#f8f9fa',
    },
    productContainer: {
      backgroundColor: '#f8f9fa',
      borderRadius: 8,
      padding: 15,
      marginBottom: 15,
      borderWidth: 1,
      borderColor: '#ddd',
    },
    addProductButton: {
      backgroundColor: Mycolors.principal,
      padding: 12,
      borderRadius: 8,
      alignItems: 'center',
      marginTop: 10,
    },
    addProductButtonText: {
      color: 'white',
      fontWeight: 'bold',
      fontSize: 16,
    },
    submitButton: {
      backgroundColor: Mycolors.principal,
      padding: 15,
      borderRadius: 8,
      alignItems: 'center',
      marginTop: 20,
    },
    submitButtonText: {
      color: 'white',
      fontWeight: 'bold',
      fontSize: 18,
    },
    buttonContainer: {
      flexDirection: 'row',
      justifyContent: 'space-around',
      marginTop: 15,
      marginBottom: 15,
    },
    estadoButton: {
      padding: 10,
      borderRadius: 8,
      minWidth: 100,
      alignItems: 'center',
    },
    estadoButtonText: {
      color: 'white',
      fontWeight: 'bold',
      fontSize: 14,
    },
  });

export default Styles;