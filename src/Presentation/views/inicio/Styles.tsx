import { StyleSheet } from "react-native";

const HomeStyles = StyleSheet.create({
    container:{
        width: '100%',
        height: '100%',
        backgroundColor: 'white'
    },
    links:{
        flexDirection: 'row',
        flexWrap: 'wrap',
        justifyContent: 'center',
        gap: 10,
        marginBlockStart: 30
    },
    container2:{
        marginTop: 30,
        marginLeft: 30
    },
    tuex:{
        fontSize: 18,
        fontWeight: 'bold',
        },
        cajon: {
            width: "45%",
            height: 300,
            borderColor: "black",
            borderWidth: 1,
            borderRadius: 15,
            position: "relative",
            overflow: "hidden",
            backgroundColor: "white",
            marginBottom: 10,
          },
          idBadge: {
            position: "absolute",
            top: 0,
            right: 0,
            backgroundColor: "#f0f0f0",
            paddingHorizontal: 8,
            paddingVertical: 4,
            borderBottomLeftRadius: 10,
            zIndex: 1,
          },
          idText: {
            fontWeight: "bold",
            fontSize: 12,
          },
          cajonText: {
            padding: 10,
            gap: 5,
          },
          image: {
            width: "100%",
            height: 160,
          },
          infoRow: {
            flexDirection: "row",
            justifyContent: "space-between",
            alignItems: "center",
            paddingVertical: 2,
          },
          label: {
            fontWeight: "bold",
            fontSize: 13,
          },
});

export default HomeStyles;