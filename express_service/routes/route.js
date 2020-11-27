var express = require('express');
var router = express.Router();

var DiscussionController = require('../controllers/discussion.controller');
const validator = require("../middleware/discussionValidator");

router.post('/checkOrCreate', validator.validateDiscussion, DiscussionController.checkDiscussions);
router.delete('/delete', validator.validateDiscussion, DiscussionController.deleteDiscussions);
router.get('/allDiscussion/:sender_id',  DiscussionController.getDiscussions);

module.exports = router;