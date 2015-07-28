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
    #play, #volume, #seekbg {
        float: left;
    }
    #fullScr {
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
    .glyphicon-unchecked {
        position: absolute;
        color: #AAA;
        top: -5px;
        left: -10px;
    }
    .glyphicon-unchecked:hover {
        color: #FFF;
    }
    .time {
        display: block;
        float: left;
        color: #FFF;
        font-size: 14px;
    }
</style>
<script>
    init.push(function() {
        function getTranscript() {
            $.post("uploads/" + subs, null, function (data) {
                var srt = data.split('\r\n\r\n'), i = 0, l = srt.length, s;
                time = Array(l);
                for (; i < l; i++) {
                    s = srt[i].split('\r\n');
                    subs_html += '<li>' + s.slice(2, s.length).join('<br/>') + '</li>';
                    s = s[1].split('-->')[1].replace(',', ".").split(':');
                    time[i] = s[0] * 3600 + s[1] * 60 + 1 * s[2];
                }
                ul.html(subs_html);
                lis = $('#transcript > li');
                lis[0].className = 'activeText';
            });
        }
        function setDuration() {
            duration = Math.ceil(player[0].duration);
            $('#duration').text(duration);
        }
        var player = $('#videoPlayer'), subs = '<?= $video['subs'] ? $video['subs'] : 0?>',
            subs_html = '', time, cur_id = 0, lis, ul = $('#transcript'), offset = (ul[0].offsetTop + ul[0].clientHeight * 0.5) << 0,
            duration, seeking = 0;
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
                for (; i < time.length; i++) {
                    if (time[i] > t) {
                        lis[cur_id].className = '';
                        cur_id = i;
                        lis[cur_id].className = 'activeText';
                        ul[0].scrollTop = lis[cur_id].offsetTop + lis[cur_id].clientHeight / 2 - offset;
                        break;
                    }
                }
            });
        }
        player.on('timeupdate', function () {
            if (subs) {
                if (time[cur_id] <= player[0].currentTime) {
                    lis[cur_id].className = '';
                    cur_id ++;
                    lis[cur_id].className = 'activeText';
                    ul[0].scrollTop = lis[cur_id].offsetTop + lis[cur_id].clientHeight / 2 - offset;
                }
            }
            $('#seek').css('width', (100* player[0].currentTime / duration) + '%');
            $('#current').text(Math.round(player[0].currentTime));
        });
        $('#transcript').click(function(e){
            var i = 0, el = e.target;
            while( (el = el.previousSibling) != null ) {
                i++;
            }
            player[0].currentTime = i == 0 ? 0 : time[i-1];
        });
        $('#seekbg').on('mousedown', function(e){
            //console.log(duration, player[0].currentTime, 100* player[0].currentTime / duration);
            seeking = [this.clientWidth, this.offsetLeft];
        });
        $('body').on('mousemove', function(e) {
            if (seeking) {

                player[0].currentTime =  duration * (e.clientX - seeking[1]) / seeking[0];
                $('#seek').css('width', (100* player[0].currentTime / duration) + '%');
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
            <div id="seekbg"><div class="glyphicon glyphicon-unchecked"></div><div id="seek"></div></div>
            <div class="videoControls">
                <div id="play">
                    <span class="glyphicon glyphicon-play"></span>
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