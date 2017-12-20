module.exports = function (arg1, arg2, options) {
    if (arg1 == arg2) {
        return options.fn ? options.fn(this): true;
    } else {
        return options.inverse ? options.inverse(this) : false;
    }
};