var Discussion = require('../model/discussion.model');

exports.checkDiscussions = async function(req, res) {
    sender_id = req.body.sender;
    receiver_id = req.body.receiver;

    var discussion = await Discussion.findOne({$or: [{ user1 : sender_id, user2 : receiver_id  }, { user1: receiver_id, user2 : sender_id }]}).exec();

    if (discussion) {
        return res.status(200).json({ discussion });
    }

    const newDiscussion = new Discussion({
        user1: sender_id,
        user2: receiver_id,
    }) ;
     
    newDiscussion.save((err) => {
    });

    return res.status(200).json({ msg: 'discussion saved'});
};

exports.deleteDiscussions = async function(req, res) {
    sender_id = req.body.sender;
    receiver_id = req.body.receiver;

    Discussion.deleteOne({$or: [{ user1 : sender_id, user2 : receiver_id  }, { user1: receiver_id, user2 : sender_id }]}, function(err, result) {
        if (err) {
          console.err(err);
        } else {
            nbr_suppr = result.deletedCount;
            deletedMsg =  nbr_suppr + " discussion deleted !" ;
            return res.status(200).json({ msg: deletedMsg, result});
        }
      });
}