const userController = require('../controllers/userController');

  module.exports = (app) => {
  app.post('/api/usuario/create', userController.register);
 }