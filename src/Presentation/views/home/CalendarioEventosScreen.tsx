// src/Presentation/views/calendario/CalendarioEventosScreen.tsx

import React from 'react';
import { View, StyleSheet } from 'react-native';
import { WebView } from 'react-native-webview';

export const CalendarioEventosScreen = () => {
  return (
    <View style={styles.container}>
      <WebView
        source={{ uri: 'http://192.168.1.100/App-GeroyNatis/src/Presentation/views/home/api/calendario_eventos.php' }} // Reemplaza por tu IP local
        style={{ flex: 1 }}
        startInLoadingState={true}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
});
