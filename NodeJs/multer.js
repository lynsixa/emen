const multer = require('multer');
const path = require('path');

const storage = multer.diskStorage({
    filename: (req, file, cb) => {
      cb(null, Date.now() + path.extname(file.originalname));
    },
  });

  const fileFilter = (req, file, cb) => {
    const allowedTypes = /jpeg|jpg|png/;
    const extname = allowedTypes.test(path.extname(file.originalname).toLowerCase());
    const mimetype = allowedTypes.test(file.mimetype);
  
    if (mimetype && extname) return cb(null, true);
    cb('Error: formato no permitido');
  };
  
  const upload = multer({ storage, fileFilter });
  
  module.exports = upload;