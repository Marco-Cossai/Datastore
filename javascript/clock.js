var getTime = function () {
    let today = new Date();
    let hour = today.getHours();
    let minutes = today.getMinutes();
    let h = this.checkTime(hour);
    let m = this.checkTime(minutes);
    document.getElementById('hours').innerText = `${h + " :"}`;
    document.getElementById('minutes').innerText = m;
    setTimeout(this.getTime, 1000);
}
var checkTime = function (i) {
    if (i < 10) {
        i = "0" + i
    };
    return i;
}
getTime();