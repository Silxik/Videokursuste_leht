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
        float: left;
        width: 100%;
        height: 30px;
        font-size: 22px;
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
        margin-top: 2px;
        margin-left: 8px;
        margin-right: 8px;
    }
    #videoWrap {
        float: left;
        width: 75%;
        height: 100%;
    }
    #videoPlayer {
        display: block;     /*fixes whitespace issue in HTML5*/
        width: 100%;
        height: 100%;
    }
    #play, #volume, #seekbg, #speed {
        float: left;
    }
    #fullScr, #addSub {
        float: right;
    }
    #seekbg {
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
    #speed {
        font-size: 18px;
        line-height: 30px;
    }
    .glyphicon-unchecked {
        position: absolute;
        color: #AAA;
        top: -5px;
        left: -15px;
    }
    .glyphicon-unchecked:hover {
        color: #FFF;
    }
    .time {
        display: block;
        float: left;
        color: #FFF;
        font-size: 14px;
        line-height: 30px;
    }
</style>
<script>
    init.push(function() {
        function getTranscript() {
            $.post("uploads/" + subs, null, function (data) {
                var srt = data.split('\r\n\r\n'), i = 0, l = srt.length, s;
                subTime = Array(l);
                for (; i < l; i++) {
                    s = srt[i].split('\r\n');
                    subs_html += '<li>' + s.slice(2, s.length).join('<br/>') + '</li>';
                    s = s[1].split('-->')[1].replace(',', ".").split(':');
                    subTime[i] = s[0] * 3600 + s[1] * 60 + 1 * s[2];
                }
                ul.html(subs_html);
                li_elements = $('#transcript > li');
                li_elements[0].className = 'activeText';
            });
        }
        function formatTime(seconds) {
            var h = seconds / 3600 << 0,
                m = (seconds - h * 3600) / 60 << 0,
                s =  seconds - (h * 3600) - (m * 60) << 0;
            m = m ? m : '0';
            s = s < 10 ? "0" + s : s;
            return h ? h + ':' + m + ':' + s : m ? m + ':' + s : s;
        }
        function setDuration() {
            duration = Math.ceil(player[0].duration);
            $('#duration').text(formatTime(duration));
        }
        function moveToTime(seconds) {
            $('#seek').css('width', (100* seconds / duration) + '%');
            $('.glyphicon-unchecked').css('left', (seconds / duration) * $('#seekbg')[0].clientWidth -15 + 'px');
            $('#current').text(formatTime(seconds));
        }
        function scrollToText(id) {
            li_elements[cur_id].className = '';
            cur_id = id;
            li_elements[cur_id].className = 'activeText';
            ul[0].scrollTop = li_elements[cur_id].offsetTop + li_elements[cur_id].clientHeight / 2 - offset;
        }
        var player = $('#videoPlayer'), subs = '<?= $video['subs'] ? $video['subs'] : 0?>',
            subs_html = '', subTime, cur_id = 0, li_elements, ul = $('#transcript'), offset = (ul[0].offsetTop + ul[0].clientHeight * 0.5) << 0,
            duration, seeking;
        setDuration();
        if (!duration) {
            player.on('loadeddata', function () {
                setDuration();
            });
        }
        if (subs) {
            getTranscript();
            player.on('seeking', function () {
                var i = 0, t = player[0].currentTime;
                for (; i < subTime.length; i++) {
                    if (subTime[i] > t) {
                        scrollToText(i);
                        break;
                    }
                }
            });
        }
        player.on('timeupdate', function () {
            if (subs) {
                if (subTime[cur_id] <= player[0].currentTime && cur_id < li_elements.length) {
                    scrollToText(cur_id + 1);
                }
            }
            moveToTime(player[0].currentTime);
        });
        $('#transcript').click(function(e){
            var i = 0, el = e.target;
            while( (el = el.previousSibling) != null ) {
                i++;
            }
            player[0].currentTime = i == 0 ? 0 : subTime[i-1];
        });
        $('#seekbg').on('mousedown', function(e){
            seeking = [this.clientWidth, this.offsetLeft];
            var percent = (e.clientX - seeking[1]) / seeking[0];
            percent = percent > 1 ? 1 : percent < 0 ? 0 : percent;
            moveToTime(player[0].currentTime = duration * percent);
        });
        $('body').on('mousemove', function(e) {
            if (seeking) {
                var percent = (e.clientX - seeking[1]) / seeking[0];
                percent = percent > 1 ? 1 : percent < 0 ? 0 : percent;
                moveToTime(player[0].currentTime = duration * percent);
            }
        });
        $('body').on('mouseup', function(e) {
            seeking = 0;
        });
        $('#play').click(function () {
            if (player[0].paused) {
                player[0].play();
                $('#play').children().attr('class', 'glyphicon glyphicon-pause');
            }
            else {
                player[0].pause();
                $('#play').children().attr('class', 'glyphicon glyphicon-play');
            }
            return false;
        });
        $('.btnMute').click(function () {
            if (player[0].muted == false) {
                player[0].muted = true;
                $('.glyphicon-volume-up').attr('class', 'glyphicon glyphicon-volume-off');
            } else {
                player[0].muted = false;
                $('.glyphicon-volume-off').attr('class', 'glyphicon glyphicon-volume-up');
            }
        });
        $('.btnFullscreen').on('click', function () {
            player[0].webkitEnterFullscreen();
            player[0].mozRequestFullScreen();
            return false;
        });
    });
</script>
<div class="container">
    <?php if ($video['linktype']) {//uploaded video ?>
        <div class="player">
            <div id="videoWrap">
                <video id="videoPlayer" preload="" controls>
                    <source src="uploads/<?= $video['link'] ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <ul id="transcript">
                <li>TEST</li>
            </ul>
            <div id="seekbg"><div id="seek"></div><div class="glyphicon glyphicon-unchecked"></div></div>
            <div class="videoControls">
                <div id="play">
                    <span class="glyphicon glyphicon-play"></span>
                </div>
                <div id="speed">
                    1.0x
                </div>
                <div id="volume">
                    <span class="glyphicon glyphicon-volume-up"></span>
                </div>
                <span class="time">
                    <span id="current" >0:00</span>
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