var TweetDisplay = '#tweets';

function main(at, ats, limit) {
    if (window.EventSource) {
        connect(at, ats, limit)
    } else {
        alert('EventSourceに対応していません');
    }
};

function connect(at, ats, limit) {
    // サーバに接続
    var es = new EventSource('push.php?at=' + at + '&ats=' + ats);

    es.addEventListener('Info', function (e) {
        var data = Init(limit, e);

        add_tweet(m_random(18), data.icon_url, data.value);
    }, false);
    es.addEventListener('Tweet', function (e) {
        var data = Init(limit, e);

        add_tweet(data.id, data.icon_url, data.value);
    }, false);

    es.addEventListener('Error', function (e) {
        var data = Init(limit, e);

        if (data.value == "89") {
            location.href = "reset.php"
        } else if (data.value == "88") {
            es.close();

            setTimeout(function () {
                connect(at, ats, limit);
            }, 300000)
        }
    }, false);
}

function Init(limit, data) {
    while ($(TweetDisplay).find("div").length >= limit) {
        $(TweetDisplay + ' div')[0].remove();
    }

    return validateJSON(data.data);
}

var z_count = 0;
var w_size = 48;

function add_tweet(id, icon_url, value) {
    var wh = window.innerHeight - 104;
    var ww = window.innerWidth - 300;

    $(TweetDisplay).append('<div class="tweet" id="' + id + '" style="top:' + calculation(wh / 100 * w_size, wh, 104) + 'px; left:' + calculation(ww / 100 * w_size, ww, 300) + 'px; z-index:' + z_count + ';">'
        + '<div class="title_bar">'
        + 'OZtter Message'
        + '<button class="close" title="閉じる">'
        + '<span class="cross"></span>'
        + '</button>'
        + '</div>'
        + '<img class="icon"  align="left" src="' + icon_url + '">'
        + '<p class="value">' + tweet_value(value) + '</p>'
        + '</div>');

    $('.tweet').draggable({handle: '.title_bar'});

    if (0 < w_size) {
        w_size--;
    }
}

// JSON の評価を行う、JSON.parseでエラーになる場合は、jsとしてevalする
function validateJSON(text) {
    var obj = null;

    try {
        obj = JSON.parse(text);
        return obj;
    } catch (O_o) {
        ;
    }

    // try eval(text)
    try {
        obj = eval("(" + text + ")");
    } catch (o_O) {
        console.log("ERROR. JSON.parse failed");
        return null;
    }

    console.log("WARN. As a result of JSON.parse, a trivial problem has occurred");
    return obj; // repaired
}

function tweet_value(value) {
    return value
        .replace(/(https?:\/\/[\x21-\x7e]+)/gi, "<a href='$1'>$1</a>") // メンションのURLと干渉するため、必ず一番最初にこの処理を書くこと
        .replace(/@(\w+)/g, '<a href="https://twitter.com/$1">@$1</a>')
        .replace(/\r\n?/g, "<br>");
}

function calculation(min, max, size) {
    return Math.random() * ((max - min) - min) + min;
}

function m_random(length) {
    var c = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; // 生成する文字列に含める文字セット
    var r = ""; // 初期化

    while (r.length < length) {
        r += c[Math.floor(Math.random() * c.length)];
    }

    return r;
}
