import React from "react";
import { TextInput, StyleSheet, View, Text, TextInputProps, KeyboardType, Image } from "react-native";


export interface Props {
    image: any,
    placeholder: string,
    value: string,
    KeyboardType: KeyboardType,
    secureTextEntry: boolean,
    property: string,
    onChangeText: (property: string, value: any) => void
}

export const CustomTextInput = ({
    image,
    placeholder,
    value,
    KeyboardType,
    secureTextEntry,
    property,
    onChangeText
}: Props) => {
        return (
            <View style={styles.formInput}>
                <Image
                    style={styles.formIcon}
                    source={image}
                />
                <TextInput
                    style={styles.formTextInput}
                    placeholder={placeholder}
                    keyboardType={KeyboardType}
                    value={value}
                    onChangeText={text => onChangeText(property, text)}
                    secureTextEntry={secureTextEntry}
                />
            </View>
        )
}

const styles = StyleSheet.create({

    formIcon: {
        width: 25,
        height: 25,
        marginTop: 5,
    },

    formInput: {
        flexDirection: 'row',
        marginTop: 30,
    },

    formTextInput: {
        flex: 1,
        borderBottomWidth: 1,
        borderBottomColor: '#AAAAAA',
        marginLeft: 15,
    },
})

export default CustomTextInput;