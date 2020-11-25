const {check, validationResult} = require('express-validator');

exports.validateDiscussion = [
  check('sender')
    .isInt()
    .withMessage('sender should be int')
    .bail()
    .trim()
    .escape()
    .not()
    .isEmpty()
    .withMessage('sender id can not be empty!')
    .bail(),
  check('receiver')
    .isInt()
    .withMessage('receiver should be int')
    .bail()
    .trim()
    .escape()
    .not()
    .isEmpty()
    .withMessage('sender id can not be empty!')
    .bail(),
  (req, res, next) => {
    const errors = validationResult(req);
    if (!errors.isEmpty())
      return res.status(422).json({errors: errors.array()});
    next();
  },
];