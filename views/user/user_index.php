<h1>Tere tulemast!</h1>

<?php if ($auth->is_admin): ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="well well-sm">
                    <form class="form-horizontal" action="" method="post">
                        <fieldset>
                            <legend class="text-center">Lisa video</legend>

                            <!-- Link-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="email">Link</label>
                                <div class="col-md-9">
                                    <input id="link" name="data[link]" type="text" placeholder="Link" class="form-control">
                                </div>
                            </div>

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
                                    <button type="submit" class="btn btn-primary btn-lg" name="submit">Lisa</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
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
            document.getElementById('title').value = data.items[0].snippet.title;
            document.getElementById('desc').value = data.items[0].snippet.description;
            document.getElementById('tags').value = data.items[0].snippet.tags.join(', ');
        }
        var link_input = document.getElementById('link'), timeout;
        link_input.addEventListener('input', delay);
    </script>
<?php endif; ?>