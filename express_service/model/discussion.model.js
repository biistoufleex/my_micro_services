var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var DiscussionSchema = Schema({
    user1: {
        type: Number,
        required: 'user1 is required',
    },
    user2: { 
        type: Number,
        required: 'user2 is required',
    },
    created_at : { type: Date, default: Date.now },
});


module.exports = mongoose.model('DiscussionSchema', DiscussionSchema);