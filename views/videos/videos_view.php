<style type="text/css">
    .activeText {
        background: #888;
        font-weight: bold;
    }

    #transcript {
        background: #CCC;
        width: 25%;
        float: left;
        height: 100%;
        margin: 0px;
        padding: 0px;
        list-style-type: none;
        overflow-y: scroll;
        padding: 10px;
    }

    #transcript li {
        cursor: pointer;
    }

    #transcript li:hover {
        color: #000;
        text-decoration: underline;
    }

    .player {
        height: 360px;
        background: #444;
        min-width: 500px;
    }

    .videoControls {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        float: left;
        width: 100%;
        height: 30px;
        font-size: 20px;
        background: #222;
        display: block;
    }

    .videoControls div {
        color: #AAA;
        cursor: pointer;
        height: 30px;
    }

    .videoControls div:hover {
        color: #CCC;
    }

    .player .glyphicon {
        margin-top: 3px;
        margin-left: 8px;
        margin-right: 8px;
    }

    #videoWrap {
        position: relative;
        float: left;
        width: 75%;
        height: 100%;
    }

    #videoPlayer {
        display: block; /*fixes whitespace issue in HTML5*/
        width: 100%;
        height: 100%;
    }

    #play, #volume, #seekBg, #speed, #volBarWrap {
        float: left;
    }

    #fullScr, #addSub {
        float: right;
    }

    #seekBg {
        position: relative;
        background: #555;
        height: 10px;
        width: 100%;
        cursor: pointer;
    }

    #seek {
        background: #F00;
        height: 10px;
        width: 0%;
    }

    #volBarWrap {
        width: 0px;
        -webkit-transition: width 0.6s ease-in;
        -moz-transition: width 0.6s ease-in;
        -ms-transition: width 0.6s ease-in;
        -o-transition: width 0.6s ease-in;
        transition: width 0.6s ease-in;
        line-height: 30px;
    }

    #volBar {
        background: #F00;
        width: 100%;
        height: 8px;
    }

    #volBarBg {
        background: #555;
        width: 100%;
        height: 8px;
        margin-top: 11px;
    }

    #volume:hover + #volBarWrap, #volBarWrap:hover {
        color: #00F;
        width: 100px;
        -webkit-transition: width 0.2s;
        -moz-transition: width 0.2s;
        -ms-transition: width 0.2s;
        -o-transition: width 0.2s;
        transition: width 0.2s;
    }

    #speed {
        font-size: 18px;
        line-height: 30px;
        position: relative;
    }

    #subBox {
        position: absolute;
        background: #AAA;
        color: #000;
        text-align: center;
        display: none;
        right: 5px;
        bottom: 5px;
    }

    #subBox div, button {
        text-align: right;
    }

    #subArea {
        width: 240px;
        height: 60px;
    }

    #subBox button {

    }

    .glyphicon-unchecked {
        position: absolute;
        color: #AAA;
        top: -5px;
        left: -15px;
        opacity: 0;
        -webkit-transition: opacity 0.2s;
        -moz-transition: opacity 0.2s;
        -ms-transition: opacity 0.2s;
        -o-transition: opacity 0.2s;
        transition: opacity 0.2s;
    }

    #seekBg:hover .glyphicon-unchecked {
        color: #FFF;
        opacity: 1;
    }

    .time {
        display: block;
        float: left;
        color: #FFF;
        font-size: 14px;
        line-height: 30px;
        margin-left: 5px;
    }

    #speed ul {
        display: none;
        position: absolute;
        bottom: 20px;
        background: #222;
        padding: 0 20px;
        font-size: 13px;
        margin-left: -13px;
        opacity: 0.7;
        list-style: none;
        color: #aaa;
    }

    #speed:hover ul {
        display: block;
    }

    #speed li:hover {
        color: #fff;
    }
</style>
<div class="container">
    <?php if ($video['linktype']) {//uploaded video ?>
        <div class="player">
            <div id="videoWrap">
                <div id="subBox">
                    <button id="subClose" class="btn btn-default">Sulge</button>
                    <div><span>Algusaeg:</span><input id="subStart" type="text"/></div>
                    <textarea id="subArea"></textarea>
                </div>
                <video id="videoPlayer" preload="">
                    <source src="uploads/<?= $video['link'] ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <ul id="transcript"></ul>
            <div id="seekBg">
                <div id="seek"></div>
                <div class="glyphicon glyphicon-unchecked">
                </div>
            </div>
            <div class="videoControls">
                <div id="play">
                    <span class="glyphicon glyphicon-play"></span>
                </div>
                <div id="speed">
                    <span>1.0x</span>
                    <ul>
                        <li>2.0x</li>
                        <li>1.5x</li>
                        <li>1.0x</li>
                        <li>0.5x</li>
                    </ul>
                </div>
                <div id="volume">
                    <span class="glyphicon glyphicon-volume-up"></span>
                </div>
                <div id="volBarWrap">
                    <div id="volBarBg">
                        <div id="volBar"></div>
                    </div>
                </div>
               <span class="time">
                   <span id="current">0:00</span>
                   /
                   <span id="duration">0:00</span>
               </span>

                <div id="fullScr">
                    <span class="glyphicon glyphicon-fullscreen"></span>
                </div>
                <div id="addSub"><span class="glyphicon glyphicon-pencil"></span></div>
            </div>
        </div>

    <?php } else {//youtube video ?>
        <iframe id="videoPlayer" width="560" height="315"
                src="https://www.youtube.com/embed/<?= $video['link'] ?>?controls=0" frameborder="0"
                allowfullscreen></iframe>
    <?php } ?>
</div>
<div class="container">
    <div class="row">
        <h2><?= $video['title'] ?></h2>

        <p><?= $video['video_desc'] ?></p>
        <? foreach ($tags as $tag): ?>
            <a href="tags/view/<?= $tag['tag_id'] ?>"><span class="label label-info"><?= $tag['tag_name'] ?></span></a>
        <? endforeach ?>
        <p>Posted by: <strong><?= $video['username'] ?></strong></p>
        <?php if ($auth->active): ?>
            <div class="col-md-12">
                <h3>Lisa kommentaar</h3>

                <form method="POST">
                    <textarea class="form-control" id="comment" name="data[comment]" placeholder="Kirjuta kommentaar"
                              rows="2"></textarea>
                    <button type="submit" class="btn btn-primary btn-sm" name="submit">Postita</button>
                </form>
            </div>
        <?php endif; ?>
        <div class="col-md-12">
            <ul class="list-group">
                <h3>Kommentaarid</h3>
                <? foreach ($comments as $comment): ?>
                    <li class="list-group-item">
                        <p><?= $comment['comment'] ?></p>

                        <p>Posted by <strong><?= $comment['username'] ?></strong> on <?= $comment['date_added'] ?></p>
                    </li>
                <? endforeach ?>
            </ul>
        </div>
    </div>
</div>
<script>
    "use strict";
    init.push(function () {

        function gId(s) {
            return document.getElementById(s);
        }

        function xhrPost(url, callback) {
            var req = new XMLHttpRequest();
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    callback(req.response);
                }
            };
            req.open("POST", url, true);
            //r.overrideMimeType('text/plain');
            req.send();
        }

        function sortSubs() {
            var i = 0, l = sub.rows.length;
            sub.rows.sort(function (a, b) {
                return a.endsAt - b.endsAt;
            });
            for (; i < l; i++) {
                sub.appendChild(sub.rows[i].dom);
            }
            sub.rows[sub.current].dom.className = 'activeText';
        }

        function getTranscript() {
            if (!sub.file) return;
            xhrPost('uploads/' + sub.file, function (data) {
                var srt = data.split('\r\n\r\n'),       //splits to chunks by an empty row
                    i = srt.length, s, o;
                while (--i >= 0) {
                    s = srt[i].split('\r\n');       //splits to rows by newline
                    o = document.createElement("li");
                    o.innerHTML = s.slice(2, s.length).join('<br/>');  //appends lines after the 2nd
                    s = s[1].split('-->')[1].replace(',', ".").split(':');      //grabs the ending times
                    sub.rows[i] = {endsAt: s[0] * 3600 + s[1] * 60 + 1 * s[2], dom: o};
                }
                sortSubs();
            });
        }

        function formatTime(seconds, micro) {
            var h = seconds / 3600 << 0,
                m = (seconds - h * 3600) / 60 << 0,
                s = seconds - (h * 3600) - (m * 60);
            s = micro ? s.toFixed(3) : s << 0;
            m = m ? m : '0';
            s = s < 10 ? "0" + s : s;
            return h ? h + ':' + m + ':' + s : m ? m + ':' + s : s;
        }

        function getDuration() {
            var sec = Math.ceil(vid.duration);
            if (!sec) {    //if player metadata has not loaded, retry
                vid.addEventListener("loadeddata", function () {
                    getDuration();
                });
            } else {
                gId('duration').textContent = formatTime(sec);
            }
        }

        function moveToTime(percent) {
            var per, sec;
            if (percent == undefined) {     //video playing
                sec = vid.currentTime;
                per = sec / vid.duration;
            } else {                        //user specified
                per = percent > 1 ? 1 : percent < 0 ? 0 : percent;
                sec = vid.currentTime = per * vid.duration;
            }
            $('#seek').css('width', 100 * per + '%');
            $('.glyphicon-unchecked').css('left', per * $('#seekBg')[0].clientWidth - 15 + 'px');
            $('#current').text(formatTime(sec));
            if (sub.editing) $("#subStart").val(formatTime(sec, 1));
        }

        function scrollToText(id) {
            if (id >= sub.rows.length) return;
            sub.children[sub.current].className = '';
            sub.children[sub.current = id].className = 'activeText';
            sub.scrollTop = sub.children[sub.current].offsetTop - sub.offsetTop + (sub.children[sub.current].clientHeight - sub.clientHeight) / 2;
        }

        function setVolume(percent) {
            var ico, per;
            if (percent == 'mute') {     //mute & unmute
                if (vid.muted == false) {
                    vid.muted = true;
                    per = 0;
                } else {
                    vid.muted = false;
                    per = vid.volume;
                    if (!per) per = vid.volume = 1;
                }
            } else {                        //volume drag
                vid.muted = false;
                per = percent > 1 ? 1 : percent < 0 ? 0 : percent;
                vid.volume = per;
                if (!per) vid.muted = true;
            }
            ico = per > 0.5 ? 'up' : per > 0 ? 'down' : 'off';
            $('#volBar').css('width', 100 * per + '%');
            $("#volume").children().attr('class', 'glyphicon glyphicon-volume-' + ico);
        }

        function toggleEdit() {
            $('#subBox').css('display', sub.editing ? 'none' : 'block');
            sub.editing = !sub.editing;
            $('.glyphicon-unchecked').css('opacity', 1 * sub.editing);
        }

        var vid = gId('videoPlayer'),
            sub = gId('transcript');
        vid.seekDrag = vid.volDrag = sub.current = sub.editing = 0;
        sub.file = '<?= $video['subs'] ? $video['subs'] : 0?>';
        sub.rows = [];

        getDuration();
        getTranscript();

        $('#speed > ul').click(function (e) {
            var s = e.target.innerHTML;
            $('#speed > span').html(s);
            vid.playbackRate = parseFloat(s);
        });
        $('#play').click(function () {
            if (vid.paused) {
                vid.play();
                this.children[0].className = 'glyphicon glyphicon-pause';
                //console.log(gId('play').children[0]);
                //.attr('class', 'glyphicon glyphicon-pause');
            } else {
                vid.pause();
                this.children[0].className = 'glyphicon glyphicon-play';
                //gId('play').children[0]
                //.attr('class', 'glyphicon glyphicon-play');
            }
            return false;
        });
        vid.ontimeupdate = function () {
            if (sub.rows.length && sub.rows[sub.current].endsAt <= vid.currentTime) {
                scrollToText(sub.current + 1);
            }
            moveToTime();
        }
        vid.addEventListener('seeking', function () {
            var i = 0, t = vid.currentTime;
            for (; i < sub.children.length; i++) {
                if (sub.rows[i].endsAt > t) {
                    scrollToText(i);
                    break;
                }
            }
        });

        $('#transcript').click(function (e) {
            var i = 0, el = e.target;
            while ((el = el.previousSibling) != null) {
                i++;
            }
            if (sub.editing) $("#subArea").val(sub.children[i].innerHTML);
            vid.currentTime = i == 0 ? 0 : sub.rows[i - 1].endsAt;
        });
        $('#volBarWrap').on('mousedown', function (e) {
            e.preventDefault();
            $('#volBarWrap').css('width', '100px');
            vid.volDrag = this.offsetLeft;
            setVolume((e.clientX - vid.volDrag) / 100);
        });
        $('#seekBg').on('mousedown', function (e) {
            e.preventDefault();
            vid.seekDrag = [this.clientWidth, this.offsetLeft];
            moveToTime((e.clientX - vid.seekDrag[1]) / vid.seekDrag[0]);
            if (sub.editing) $("#subArea").val('');
        });
        $('body').on('mousemove', function (e) {
            if (vid.seekDrag) {
                moveToTime((e.clientX - vid.seekDrag[1]) / vid.seekDrag[0]);
            } else if (vid.volDrag) {
                setVolume((e.clientX - vid.volDrag) / 100);
            }
        });
        $('body').on('mouseup', function (e) {
            vid.seekDrag = 0;
            vid.volDrag = 0;
            $('#volBarWrap')[0].style.width = '';
        });

        $('#volume').click(function () {
            setVolume('mute');
        });
        $('#fullScr').on('click', function () {
            //vid.webkitEnterFullscreen();
            vid.mozRequestFullScreen();
            return false;
        });
        $('#addSub').on('click', toggleEdit);
        $('#subClose').on('click', toggleEdit);
    });
</script>