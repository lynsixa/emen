const JwStrategy = require("passport-jwt").Strategy;
const ExtractJwt = require("passport-jwt").ExtractJwt; 
const Keys = require('./keys');
const User = require('../models/user');

module.exports = (passport) => {
    const opts = {};
    opts.jwtFromRequest = ExtractJwt.fromAuthHeaderAsBearerToken('jwt');
    opts.secretOrKey = Keys.secretOrKey;

    passport.use(new JwStrategy(opts, (jwt_payLoad, done) => {
        
        User.findByNum_Documento(jwt_payLoad.id, (err, user) => {
            if (err) {
                return done(err, false);
            }
            if (user) {
                return done(null, user);
            }
            return done(null, false);
        })
    }))
}