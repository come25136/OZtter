var progressbar = '#progressbar';

var welcome_count = 3;

var size = 12; // 大きさ
var density = 26; // パーティクルの密度

$(function () {
    var particles = []; // パーティクルをまとめる配列

    var canvas = document.querySelector('#progress');
    var ctx = canvas.getContext('2d');

    ctx.globalAlpha = 0.9; // 半透明度

    var Particle = function (scale, color, speed) {
        this.scale = scale; // 大きさ
        this.color = color; // 色
        this.speed = speed; // 速度
        this.position = { // 位置
            x: null,
            y: null
        };
    };

    Particle.prototype.draw = function () {
        ctx.beginPath();
        ctx.arc(this.position.x, this.position.y, this.scale, 0, 20 / 2 * Math.PI, false);
        ctx.fillStyle = this.color;
        ctx.fill();
    };

    for (var i = 0; i < density; i++) {
        make(i);
    }

    loop();

    function loop() {
        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

        for (var i = 0; i < density; i++) {
            particles[i].position.y -= particles[i].speed;
            particles[i].draw();

            if (particles[i].position.y <= 0 - particles[i].scale) {
                particles.splice(i, 1);
                i--;
                make(Object.keys(particles).length++);
            }
        }

        setTimeout(loop, 1000 / 60);
    }

    function make(i) {
        var scale = ~~(Math.random() * (size - 3)) + 3;
        particles[i] = new Particle(scale, '#ffffff', scale / 5);
        particles[i].position.x = Math.random() * canvas.width;
        particles[i].position.y = canvas.height + 5 + Math.random() * canvas.height;
        particles[i].draw();
    }
});

$(document).on('keydown', 'input', function (e) {
    if (e.keyCode == 13) {
        $('.form').hide();
        $(progressbar).show();

        $('#progress-t').animate({
            'left': 11 + $(progressbar).width(),
            'width': '0px'
        }, {
            'duration': 6000,
            'complete': function () {
                progress_bye();
            }
        });
    }
});

function progress_bye() {
    $(progressbar).fadeOut(500);
    $(progressbar).hide(welcome);
}

var count = 0;

function welcome() {
    if(count < welcome_count--){
        $('#welcome').fadeIn(2000).fadeOut(0, welcome);
        count++;
    }else {
        $('#welcome').fadeIn(2000, load);
    }
}

function load() {
    $('body').fadeOut(3000, go);
}

function go() {
    window.location.href = "index.php";
}