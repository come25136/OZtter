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

function add_tweet(id, icon_url, value) {
    $(TweetDisplay).append('<div class="tweet" id="' + id + '" style="top:' + Math.floor(Math.random() * (window.innerHeight - 100)) + 'px; left:' + Math.floor(Math.random() * (window.innerWidth - 300)) + 'px;">'
        + '<div class="title_bar">'
        + '<button class="close" title="閉じる">'
        + '<span class="cross"></span>'
        + '</button>'
        + '</div>'
        + '<img class="icon"  align="left" src="' + icon_url + '">'
        + '<p class="value">' + value.replace(/\r\n?/g, "<br>") + '</p>'
        + '</div>');
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

function m_random(length) {
    var c = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; // 生成する文字列に含める文字セット
    var r = ""; // 初期化

    while (r.length < length) {
        r += c[Math.floor(Math.random() * c.length)];
    }

    return r;
}