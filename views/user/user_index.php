<style>
    .upload-drop-zone {
        height: 200px;
        border-width: 2px;
        margin-bottom: 20px;
        margin-top: 15px;
        color: #ccc;
        border-style: dashed;
        border-color: #ccc;
        line-height: 200px;
        text-align: center;
        cursor: pointer;
    }

    .upload-drop-zone.drop {
        color: #222;
        border-color: #222;
    }

    #up-div {
        display: none;
    }

    #yt-div {
        display: none;
        padding-top: 15px;
    }

    #details {
        display: none;
    }

    #file-input {
        display: none;
    }

    #course-new {
        display: none;
    }

    .form-group {
        margin-top: 15px;
    }

    .progress-bar {
        margin: 20px 0;
        position: relative;
        display: none;
        width: 100%;
        background: #b4efe2;
        height: 30px;
    }

    .progress {
        background: #31a1ef;
        height: 30px;
    }

    .up-percentage {
        position: relative;
        bottom: 50px;
        line-height: 30px;
        font-size: 24px;
        color: #000;
    }

    .up-cancel {
        position: absolute;
        right: 0;
        width: 30px;
        cursor: pointer;
        line-height: 30px;
        font-size: 20px;
        color: #a5191c;
    }

    #img-thumb {
        margin: 0 auto;
        padding: 20px 0;
    }
</style>
<h1>Tere tulemast!</h1>
<?php if ($auth->is_admin): ?>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="well well-sm">
                    <legend class="text-center">Lisa video</legend>
                    <button id="yt-btn" class="btn btn-primary btn-lg">Youtube link</button>
                    <button id="up-btn" class="btn btn-primary btn-lg">Lae üles</button>
                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <input type="file" id="file-input" multiple="multiple" name="upload" accept="video/*"/>

                            <div id="up-div" class="upload-drop-zone">
                                Klikka või lohista peale
                            </div>
                            <div class="progress-bar">
                                <div class="progress"></div>
                                <div class="up-percentage"></div>
                                <span class="up-cancel glyphicon glyphicon-remove"></span>
                            </div>
                            <div id="yt-div">
                                <input id="yt-inp" name="data[link]" type="text" placeholder="link"
                                       class="form-control">
                            </div>
                            <div id="details">

                                <!-- Thumbnail -->
                                <div class="col-md-12">
                                    <img id="img-thumb" src="" class="img-responsive" height="130px"/>
                                </div>

                                <!-- Title -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="title">Pealkiri</label>

                                    <div class="col-md-9">
                                        <input id="title" name="data[title]" type="text" placeholder="Pealkiri"
                                               class="form-control">
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="desc">Kirjeldus</label>

                                    <div class="col-md-9">
                                        <textarea class="form-control" id="desc" name="data[video_desc]"
                                                  placeholder="Kirjeldus" rows="5"></textarea>
                                    </div>
                                </div>

                                <!-- Tags -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="tags">Märksõnad</label>

                                    <div class="col-md-9">
                                        <textarea class="form-control" id="tags" name="tags[tags]"
                                                  placeholder="Märksõnad, eraldatud komaga" rows="3"></textarea>
                                    </div>
                                </div>

                                <!-- Access -->
                                <div class="form-group">
                                    <label class="col-md-9 control-label" for="desc">Avalik (Nähtav sisselogimata
                                        kasutajatele)</label>

                                    <div class="col-md-3">
                                        <input checked type="checkbox" class="form-control" id="access"
                                               name="data[public]">
                                    </div>
                                </div>
                                <select placeholder="Vali kursus" id="course" name="data[course_id]"
                                        style="width:350px;">
                                    <option disabled selected>Soovi korral lisa uus kursus või vali olemasolev</option>
                                    <option value="Lisa uus">Lisa uus</option>
                                    <?
                                    foreach ($courses as $course) { ?>
                                        <option
                                            value="<?= $course['course_id'] ?>"><?= $course['course_name'] ?></option>
                                    <? } ?>
                                </select>

                                <div id="course-new">
                                    <!-- Title -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="title">Kursuse pealkiri</label>

                                        <div class="col-md-9">
                                            <input id="course-title" name="course[course_name]" type="text"
                                                   placeholder="Pealkiri" class="form-control">
                                        </div>
                                    </div>
                                    <!-- Description -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="desc">Kursuse kirjeldus</label>

                                        <div class="col-md-9">
                                            <textarea id="course-desc" name="course[course_desc]"
                                                      placeholder="Kirjeldus" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form actions -->
                                <div class="form-group">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary btn-lg">Lisa</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="col-md-8 col-md-offset-2">
                <div class="well well-sm">
                    <legend class="text-center">Lisatud videod</legend>

                    <? foreach ($courses as $course) { ?>
                        <div class="list-group-item" id="<?= $course['course_id'] ?>">
                            <legend>
                                <a href="user/course/<?= $course['course_id'] ?>"><?= $course['course_name'] ?></a>
                            </legend>
                            <? foreach ($videos as $video) {
                                if ($video['course_id'] == $course['course_id']) { ?>
                                    <div><a href="user/view/<?= $video['video_id'] ?>"><?= $video['title'] ?></a></div>
                                <? }
                            } ?>
                        </div>
                    <? } ?>
                    <div class="list-group-item">
                        <legend>
                            Kursuseta videod
                        </legend>
                        <? foreach ($videos as $video) {
                            if ($video['course_id'] == 1) { ?>
                                <a href="user/view/<?= $video['video_id'] ?>"><?= $video['title'] ?></a>
                            <? }
                        } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="assets/components/resumable/resumable.js"></script>
    <script>
        init.push(function () {
            function getLinkData(delay) {
                if (delay) {    // Delays the function
                    clearTimeout(ytInp.delay);
                    ytInp.delay = setTimeout(getLinkData, 300);
                } else {
                    var lin = ytInp[0].value.split('?')[1], i = 0, par,
                        base = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&key=AIzaSyBc1oxOjnONquNYdCMxxMov4RpDYNYMFr4&id=';

                    if (typeof lin == 'undefined') return;
                    lin = lin.split('&');
                    for (; i < lin.length; i++) {
                        par = lin[i].split('=');
                        if (par[0] == 'v') {
                            $.getJSON(base + par[1], fillInfo);
                        }
                    }
                }
            }

            function fillInfo(data) {
                console.log(data.items[0]);
                var d = data.items[0].snippet;
                $('#title').val(d.title);
                $('#desc').val(d.description);
                $('#tags').val(d.tags.join(', '));
                $('#img-thumb').attr('src', d.thumbnails.medium.url);

                $('#details').show();
            }

            var resum = new Resumable({target: 'user', maxChunkRetries: 6}),
                upDiv = $('#up-div'), fileInp = $('#file-input')[0], ytInp = $('#yt-inp');

            ytInp.on('input', getLinkData);
            resum.assignBrowse(fileInp);
            resum.assignDrop(upDiv);
            resum.on('fileProgress', function (e) {
                var p = (resum.progress() * 100 << 0) + '%';
                $('.up-percentage').html(p);
                $('.progress').css('width', p);
            });
            resum.on('fileAdded', function (e) {
                resum.upload();
                // Hide dropzone, show progressbar and details
                $('#up-div').hide();
                $('.progress-bar').show();
                $('#details').show();
                // Set title as filename
                $('#title').val(e.file.name);
            });
            resum.on('fileError', function (file, message) {
                console.log('Uploading failed');
            });
            resum.on('fileSuccess', function () {

            });

            upDiv.on('click', function (e) {
                fileInp.click();
            });
            upDiv.on('drop', function (e) {
                this.className = 'upload-drop-zone';
            });
            upDiv.on('dragover', function (e) {
                upDiv.addClass('drop');
            });
            upDiv.on('dragleave', function () {
                upDiv.removeClass('drop');
            });
            $('.up-cancel').on('click', function () {
                resum.cancel();
                $('#up-div').show();
                $('.progress-bar').hide();
            });
            $('#yt-btn').on('click', function () {
                $('#up-div').hide();
                $('#yt-div').show();
                $('.progress-bar').hide();
                resum.cancel();
            });
            $('#up-btn').on('click', function () {
                $('#yt-div').hide();
                $('#up-div').show();
            });
            $('#course').on('change', function (e) {
                if (this.value == 'Lisa uus') {
                    $('#course-new').show();
                    $(this).hide();
                }
            });
        });
    </script>
<?php endif; ?>