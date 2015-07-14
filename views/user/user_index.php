<style>
    /* layout.css Style */
    .upload-drop-zone {
        height: 200px;
        border-width: 2px;
        margin-bottom: 20px;
    }
    /* skin.css Style*/
    .upload-drop-zone {
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
    #upload-div {
        display:none;
    }
    #yt-div {
        display:none;
    }
    #details {
        display:none;
    }
    #file-input {
        position: absolute;
        top: -200px;
    }
</style>

<h1>Tere tulemast!</h1>
<?php if ($auth->is_admin): ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="well well-sm">
                    <legend class="text-center">Lisa video</legend>
                    <button onclick="toggle(1)" class="btn btn-primary btn-lg">Youtube link</button>
                    <button onclick="toggle(0)"class="btn btn-primary btn-lg">Lae üles</button>
                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                        <fieldset>


                            <div id="upload-div">
                                <!-- sets the filesize limit to 40MB -->
                                <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="40000000"/>
                                <input type="file" id="file-input" name="upload" accept="video/*"/>
                                <!-- Drop Zone -->
                                <div onclick="$('#file-input').trigger('click');" class="upload-drop-zone" id="drop-zone">
                                    Klikka või lohista peale
                                </div>
                            </div>

                            <div id="yt-div">
                                <!-- Link-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="email">Link</label>
                                    <div class="col-md-9">
                                        <input id="link" name="data[link]" type="text" placeholder="Link" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div id="details">
                                <!-- Title -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="title">Pealkiri</label>
                                    <div class="col-md-9">
                                        <input id="title" name="data[title]" type="text" placeholder="Pealkiri" class="form-control">
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="desc">Kirjeldus</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" id="desc" name="data[desc]" placeholder="Kirjeldus" rows="5"></textarea>
                                    </div>
                                </div>

                                <!-- Tags -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="tags">Märksõnad</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" id="tags" name="data[tags]" placeholder="Märksõnad, eraldatud komaga" rows="3"></textarea>
                                    </div>
                                </div>

                                <!-- Access -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="desc">Avalik</label>
                                    <div class="col-md-9">
                                        <input checked type="checkbox" class="form-control" id="access" name="data[public]">
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
        </div>
    </div>
    <script>

        //functions
        function gId(s) {
            return document.getElementById(s);
        }
        function toggle(el) {
            if (forms[el].opened) {
                forms[el].style.display = 'none';
                forms[el].opened = false;
            }
            el = Math.abs(el - 1);
            forms[el].style.display = 'block';
            forms[el].opened = true;
        }
        function delay() {
            clearTimeout(timeout);
            timeout = setTimeout(function(){suggestInfo()}, 300);
        }
        function suggestInfo() {
            var lin = link_input.value.split('?')[1], i = 0, par,
                base = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&key=AIzaSyBc1oxOjnONquNYdCMxxMov4RpDYNYMFr4&id=';
            if (lin == 'undefined') return;
            lin = lin.split('&');
            for (; i < lin.length; i++) {
                par = lin[i].split('=');
                if (par[0] == 'v') {
                    $.getJSON(base + par[1], fillInfo);
                }
            }
        }
        function fillInfo(data) {
            gId('title').value = data.items[0].snippet.title;
            gId('desc').value = data.items[0].snippet.description;
            gId('tags').value = data.items[0].snippet.tags.join(', ');
            gId('details').style.display = 'block';
        }
        function startUpload(file) {
            gId('title').value = file.name;
            gId('details').style.display = 'block';
            /*  TODO: working xhr upload
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.response);
                }
            };
            //if (file.type == "video" && file.size <= $id("MAX_FILE_SIZE").value)
            xhr.open("POST", "user", true);
            xhr.setRequestHeader("X_FILENAME", file.name);
            xhr.send(file);
            */
        }

        //global variables
        var link_input = gId('link'), timeout, forms = [gId('yt-div'), gId('upload-div')],
            dropZone = gId('drop-zone'), fileinput = gId('file-input');

        //event listeners
        link_input.addEventListener('input', delay);
        fileinput.addEventListener('change', function(e) {
            var upfile = gId('file-input').files[0];
            e.preventDefault();
            startUpload(upfile);
        });
        dropZone.ondrop = function(e) {
            e.preventDefault();
            this.className = 'upload-drop-zone';
            startUpload(e.target.files || e.dataTransfer.files);
        };
        dropZone.ondragover = function() {
            this.className = 'upload-drop-zone drop';
            return false;
        };
        dropZone.ondragleave = function() {
            this.className = 'upload-drop-zone';
            return false;
        }
    </script>
<?php endif; ?>