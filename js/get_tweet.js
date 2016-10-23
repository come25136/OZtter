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
    var es = new window.EventSource('push.php?at=' + at + '&ats=' + ats);

    // メッセージを受信した場合
    es.addEventListener('message', function (e) {
        var data = validateJSON(e.data);

        if (data.Value == "89") {
            location.href = "reset.php"
        } else if (data.Value == "88") {
            es.close();

            setTimeout(function () {
                connect(at, ats, limit);
            }, 300000)
        } else {
            while ($(TweetDisplay).find("div").length >= limit) {
                $(TweetDisplay + ' div')[0].remove();
            }

            $(TweetDisplay).append('<div class="tweet" style="top:'
                + Math.floor(Math.random() * (window.innerHeight + 84) - 84)
                + 'px; left:' + Math.floor(Math.random() * (window.innerWidth + 300) - 300)
                + 'px;"><img class="icon"  align="left" src="' + data.Icon_url
                + '"><p class="value">'
                + data.Value
                + '</p></div>');
        }
    }, false);
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
