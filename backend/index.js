const express = require("express");
const cors = require("cors");

const app = express();
const port = 3001;

app.use(cors());
app.use(express.json()); // Necesario para leer JSON en el body

// Rutas
const authRoutes = require("./routes/auth");
app.use("/api", authRoutes);

app.listen(port, () => {
  console.log(`🚀 Servidor corriendo en http://localhost:${port}`);
});
