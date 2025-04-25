import React from 'react';
import { View, StyleSheet } from 'react-native';
import Svg, { Path } from 'react-native-svg';

const WavyCircle: React.FC<{ size?: number; style?: any; color?: string }> = ({ size = 200, style, color = "#3db5b9" }) => {
    return (
      <View style={[styles.container, { width: size, height: size }, style]}>
        <Svg width={size} height={size} viewBox="0 0 200 200">
          <Path
            d="M100,20 C130,10 160,30 180,60 C200,90 190,130 170,160 C150,190 120,200 90,190 C60,180 30,160 20,130 C10,100 10,60 30,40 C50,20 70,30 100,20"
            fill={color} // Usa el color pasado como prop
            stroke="black"
            strokeWidth={0}
          />
        </Svg>
      </View>
    );
  };
  
const styles = StyleSheet.create({
  container: {
flex: 1,    
justifyContent: 'center',
alignItems: 'center',
  },
});

export default WavyCircle;
