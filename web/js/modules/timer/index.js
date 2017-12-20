class Timer {

    constructor(element, timeLeft) {
        this.element = element;
        this.time_left = timeLeft;
        if (this.time_left <= 0) {
            throw new Error('Error time left ' + this.time_left);
        }
        this.startTimer();
    }

    static plural (number, one, two, five) {
        let n = Math.abs(number);
        n %= 100;
        if (n >= 5 && n <= 20) {
            return five;
        }
        n %= 10;
        if (n === 1) {
            return one;
        }
        if (n >= 2 && n <= 4) {
            return two;
        }
        return five;
    }


     static fancyDate (dateDiff) {
        let dayLen = 24 * 3600,
            diff = {y:0,m:0,d:0,h:0,i:0,s:0};

        if (dateDiff < dayLen) {
            // только кол-во часов минут
            diff.h = Math.floor(dateDiff / 3600);
            diff.i = Math.ceil((dateDiff % 3600) / 60);
            diff.s = Math.ceil(dateDiff % 60);
        } else if (dateDiff < dayLen * 30) {
            //только кол-во дней и часов
            diff.d = Math.floor(dateDiff / dayLen);
            diff.h = Math.ceil((dateDiff % dayLen) / 3600);
        } else {
            //кол-во лет и месяцев
            let dayCount = Math.floor(dateDiff / dayLen);
            diff.y = Math.floor(dayCount / 365);
            if (!diff.y) {
                diff.m = Math.floor(dayCount / 30);
            }
            if (!diff.y && !diff.m) {
                diff.d = dayCount;
            }
        }

        let diffLabel = {
            y: ['год', 'года', 'лет'],
            m: ['месяц', 'месяца', 'месяцев'],
            d: ['день', 'дня', 'дней'],
            h: ['час', 'часа', 'часов'],
            i: ['минута', 'минуты', 'минут'],
            s: ['секунда', 'секунды', 'секунд']
        };

        let date = [];
        for(let k in diff) {
            if (diff[k]) {
                date.push(diff[k] + ' ' + Timer.plural(diff[k], ...diffLabel[k]));
               // break;
            }
        }

        return date.join(' ');
    }


    update () {
        this.time_left -= 1;
        if (this.time_left < 0) {
            document.location.reload();
            return;
        }
        this.element.innerHTML = Timer.fancyDate(this.time_left);
    }

    startTimer() {
        this.timer = window.setInterval(this.update.bind(this), 1000);
    }
}

export default Timer;