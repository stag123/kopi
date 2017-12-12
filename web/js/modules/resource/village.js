class ResourceVillage {

    constructor(element, speedHour, max) {
        this.element = element;
        this.speed = speedHour;
        this.start_time = ResourceVillage.getTime();
        this.max = max;
        this.resource_start = parseInt(this.element.innerHTML);

        this.startTimer();
    }

     static getTime() {
         return (new Date()).getTime() / 1000;
     }

    update () {
        let res = Math.floor(this.speed * ( ResourceVillage.getTime() - this.start_time) / 3600);

        if (this.resource_start + res > this.max) {
            this.element.innerHTML = this.max;
            return;
        }

        this.element.innerHTML = this.resource_start + res;
    }

    startTimer() {
        this.timer = window.setInterval(this.update.bind(this), 100);
    }
}

export default ResourceVillage;