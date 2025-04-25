const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const logger = require('morgan');
const cors = require('cors');
const passport = require('passport');
const session = require('express-session');
const mysql = require('mysql2');
const db = require('./config/config');
const cloudinary = require('cloudinary').v2;
const upload = require('./multer');
const fs = require('fs');

// ✅ Importa el router correctamente
const userRoutes = require('./routes/userRoutes');

const port = process.env.PORT || 3000;

// Configuración de CORS
app.use(cors({
    origin: ['http://localhost:3000', 'http://192.168.20.113:3000'],
    credentials: true,
    methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
    allowedHeaders: ['Content-Type', 'Authorization']
}));

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

app.use(session({
    secret: 'tu-secreto-aqui',
    resave: false,
    saveUninitialized: false,
    cookie: {
        secure: false,
        httpOnly: true,
        maxAge: 24 * 60 * 60 * 1000
    }
}));

app.use(passport.initialize());
app.use(passport.session());
require('./config/passport');

app.disable('x-powered-by');
app.set('port', port);

// ✅ Usa el router correctamente
app.use('/api/users', userRoutes);

cloudinary.config({
    cloud_name: 'dmcwfn5kq',
    api_key: process.env.CLAUDINARY_API_KEY,
    api_secret: process.env.CLAUDINARY_API_SECRET,
});

module.exports = cloudinary;

app.get('/', (req, res) => {
    res.send('Ruta raíz del Backend');
});

app.get('/test', (req, res) => {
    res.send('Test del TEST');
});

// ⚠️ Asegúrate de que las demás rutas estén bien organizadas debajo

// Aquí irían tus otras rutas (ventas, productos, proveedores, etc...)

// Error handler
app.use((err, req, res, next) => {
    console.log(err);
    res.status(err.status || 500).send(err.stack);
});

server.listen(3000, '192.168.210.212' || 'localhost', function () {
    console.log('Aplicación de NodeJs ' + process.pid + ' ejecutando en ' + server.address().address + ':' + server.address().port);
});
