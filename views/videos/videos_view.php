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
        -webkit-user-select:none;
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
        display: block;     /*fixes whitespace issue in HTML5*/
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
    #volume:hover + #volBarWrap, #volBarWrap:hover{
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
    }
    #subBox {
        position: absolute;
        background: #444;
        color: #000;
        text-align: center;
        display: none;
        right: 5px;
        bottom: 5px;
    }
    #subBox textarea {
        width: 200px;
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


    #speed ul li {
        list-style-type: none;
    }

    #speed ul {
        padding: 0;
    }

    #speed li {
        position: relative;
        width: 100%;
    }

    #speed li ul {
        position: absolute;
        display: none;
    }

    #speed li:hover ul {
        bottom:18px;
        display:block;
        background:#222;
        margin-bottom: 12px;
        padding: 0 20px;
        font-size: 13px;
        margin-left: -10px;
        color: #aaa;
        opacity: 0.7;
    }

    #speed li ul li:hover {
        color: #ccc;
    }
</style>
<script>
    init.push(function() {

        //functions

        function getTranscript() {
            $.post("uploads/" + subFile, null, function (data) {
                var srt = data.split('\r\n\r\n'),       //splits to chunks by an empty row
                    i = 0, l = srt.length, s, html = '';
                for (; i < l; i++) {
                    s = srt[i].split('\r\n');       //splits chunks by newline
                    html += '<li>' + s.slice(2, s.length).join('<br/>') + '</li>';  //appends lines after the 2nd
                    s = s[1].split('-->')[1].replace(',', ".").split(':');      //grabs the ending times
                    subTime[i] = s[0] * 3600 + s[1] * 60 + 1 * s[2];
                }
                subWrap.html(html);
                subParts = $('#transcript > li');
                subParts[0].className = 'activeText';
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
        function getDuration() {
            duration = Math.ceil(player[0].duration);
            $('#duration').text(formatTime(duration));
            if (!duration) {    //if player metadata has not loaded, retry
                player.on('loadeddata', function () {
                    getDuration();
                });
            }
        }
        function moveToTime(percent) {
            var per, sec;
            if (percent == undefined) {     //video playing
                sec = player[0].currentTime;
                per = sec / duration;
            } else {                        //user specified
                per = percent > 1 ? 1 : percent < 0 ? 0 : percent;
                sec = player[0].currentTime = per * duration;
            }
            $('#seek').css('width', 100 * per + '%');
            $('.glyphicon-unchecked').css('left', per * $('#seekBg')[0].clientWidth -15 + 'px');
            $('#current').text(formatTime(sec));
        }
        function scrollToText(id) {
            if (id >= subTime.length) return;
            subParts[subId].className = '';
            subParts[subId = id].className = 'activeText';
            subWrap[0].scrollTop = subParts[subId].offsetTop - subWrap[0].offsetTop + (subParts[subId].clientHeight - subWrap[0].clientHeight) / 2;
        }
        function setVolume(percent) {
            var ico, per;
            if (percent == 'mute') {     //mute & unmute
                if (player[0].muted == false) {
                    player[0].muted = true;
                    per = 0;
                } else {
                    player[0].muted = false;
                    per = player[0].volume;
                    if (!per) per = player[0].volume = 1;
                }
            } else {                        //volume drag
                player[0].muted = false;
                per = percent > 1 ? 1 : percent < 0 ? 0 : percent;
                player[0].volume = per;
                if (!per) player[0].muted = true;
            }
            ico = per > 0.5 ? 'up' : per > 0 ? 'down' : 'off';
            $('#volBar').css('width', 100 * per + '%');
            $("#volume").children().attr('class', 'glyphicon glyphicon-volume-' + ico);
        }

        //global variables

        var player = $('#videoPlayer'),
            subWrap = $('#transcript'),
            subFile = '<?= $video['subs'] ? $video['subs'] : 0?>',
            subTime = [],
            subId = 0,
            subParts, duration, seeking, volDrag;

        //Initialization

        getDuration();

        if (subFile) {
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
            if (subFile) {
                if (subTime[subId] <= player[0].currentTime) {
                    scrollToText(subId + 1);
                }
            }
            moveToTime();
        });
        $('#transcript').click(function(e){
            var i = 0, el = e.target;
            while( (el = el.previousSibling) != null ) {
                i++;
            }
            player[0].currentTime = i == 0 ? 0 : subTime[i-1];
        });
        $('#volBarWrap').on('mousedown', function(e) {
            e.preventDefault();
            $('#volBarWrap').css('width', '100px');
            volDrag = this.offsetLeft;
            setVolume((e.clientX - volDrag) / 100);
        });
        $('#seekBg').on('mousedown', function(e) {
            e.preventDefault();
            seeking = [this.clientWidth, this.offsetLeft];
            moveToTime((e.clientX - seeking[1]) / seeking[0]);
        });
        $('body').on('mousemove', function(e) {
            if (seeking) {
                moveToTime((e.clientX - seeking[1]) / seeking[0]);
            } else if (volDrag) {
                setVolume((e.clientX - volDrag) / 100);
            }
        });
        $('body').on('mouseup', function(e) {
            seeking = 0;
            volDrag = 0;
            $('#volBarWrap')[0].style.width = '';
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
        $('#volume').click(function () {
            setVolume('mute');
        });
        $('#fullScr').on('click', function () {
            //player[0].webkitEnterFullscreen();
            player[0].mozRequestFullScreen();
            return false;
        });
        /*
        $('#addSub').on('click', function () {
            $('#subBox').css('display', 'block');
        });
        $('#closeSub').on('click', function () {
            $('#subBox').css('display', 'none');
        });
        $('#addLine').on('click', function () {
            /*
             $.post("uploads/" + subFile, null, function (data) {
             var srt = data.split('\r\n\r\n'),       //splits to chunks by an empty row
             i = 0, l = srt.length, s, html = '';
             for (; i < l; i++) {
             s = srt[i].split('\r\n');       //splits chunks by newline
             html += '<li>' + s.slice(2, s.length).join('<br/>') + '</li>';  //appends lines after the 2nd
             s = s[1].split('-->')[1].replace(',', ".").split(':');      //grabs the ending times
             subTime[i] = s[0] * 3600 + s[1] * 60 + 1 * s[2];
             }
             subWrap.html(html);
             subParts = $('#transcript > li');
             subParts[0].className = 'activeText';
             });

        });
        */
    });
</script>
<div class="container">
    <?php if ($video['linktype']) {//uploaded video ?>
        <div class="player">
            <div id="videoWrap">

                <div id="subBox">
                    <textarea id="subArea"></textarea><br/>
                    <div class="btn-group">
                        <button id="addLine" class="btn btn-default">Lisa</button>
                        <button id="closeSub" class="btn btn-default">Sulge</button>
                    </div>
                </div>

                <video id="videoPlayer" preload="">
                    <source src="uploads/<?= $video['link'] ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <ul id="transcript">
                <li>TEST</li>
            </ul>
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
                    <ul>
                        <li>Kiirus
                            <ul>
                                <li>2.0x</li>
                                <li>1.5x</li>
                                <li>1.0x</li>
                                <li>0.5x</li>
                            </ul>
                        </li>
                    </ul>
                </div>
               <div id="volume">
                   <span class="glyphicon glyphicon-volume-up"></span>
               </div>
               <div id="volBarWrap"><div id="volBarBg"><div id="volBar"></div></div></div>
               <span class="time">
                       <span id="current" >0:00</span>
                       /
                   <span id="duration">0:00</span>
               </span>
               <div id="fullScr">
                   <span class="glyphicon glyphicon-fullscreen"></span>
               </div>
               <!-- <div id="addSub"><span class="glyphicon glyphicon-pencil"></span></div> -->
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