const mixin = {
    methods : {
        inMillions(number) {
            return new Intl.NumberFormat('en-US').format(number / 1000000)
        }
    }
}

exports.mixin = mixin
