const config = require('./config.json');

const mongo = require('mongodb').MongoClient;


var http = require('http').createServer();
http.listen(config.public_port, config.public_ip);

var io = require('socket.io').listen(http);

const client = io.sockets;

mongo.connect('mongodb://' + config.server.username + ':' + config.server.password + '@' + config.server.host + ':' + config.server.port + '/admin', function (err, database) {
    if (err) {
        throw err;
    }

    console.log("MongoDB connect ..");

    //connect database 
    const dbmongochat = database.db(config.server.database);

    //connect to socket io
    client.on('connection', function (socket) {
        let chats = dbmongochat.collection('Chats');
        chats.find({})
                .limit(5)
                .sort({update_at: -1})
                .toArray(function (err, res) {
                    if (err) {
                        throw err;
                    }

                    socket.emit('output', res);
                });


    });
});