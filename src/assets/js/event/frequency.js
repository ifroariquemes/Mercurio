function Frequency() {

    this.check = function (input) {
        if ($(input).is(':checked')) {
            MyCookieJS.execute('event/frequency/check', String.format('participant={0}&activity={1}', input.value, $('#actId').val()));
        }
        else {
            MyCookieJS.execute('event/frequency/uncheck', String.format('participant={0}&activity={1}', input.value, $('#actId').val()));
        }
    };

}

frequency = new Frequency();