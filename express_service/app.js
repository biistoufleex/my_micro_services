const express = require('express');
const mongoose = require('mongoose');
const bodyParser = require('body-parser');

// init app
const app = express();

// connect MongoDB with mongoose
let dev_db_url = 'mongodb://localhost/micro_service';
let mongoDB = dev_db_url;
mongoose.connect(mongoDB, {useNewUrlParser: true, useUnifiedTopology: true});
mongoose.Promise = global.Promise;
let db = mongoose.connection;
db.on('error', console.error.bind( console , 'Connexion error on MongoDB : '));

// Utilisation de body parser
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended : false }));

let port = 8000;

app.listen(
    port , () => {
        console.log(' Server running on : ' + port );
    }
)

var routes = require('./routes/route.js');
app.use(routes);