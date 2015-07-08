<style>
    p {
        color:red;
    }
</style>


<form action="register" method="post">
    <div class="container-fluid">
        <section class="container">
            <div class="container-page">
                <div class="col-md-6">
                    <h3 class="dark-grey">Registreerimine</h3>

                    <div>
                        <p><?php foreach ($data["errors"] as $i) {echo $i . "<br>"; } ?></p>
                    </div>

                    <div class="form-group col-lg-12">
                        <label>Kasutajanimi</label>
                        <input type="" name="user" class="form-control" id="" value="<?php if(isset($data['user'])){echo $data['user'];}?>">
                    </div>

                    <div class="form-group col-lg-6">
                        <label>Parool</label>
                        <input type="password" name="pass" class="form-control" id="" value="">
                    </div>

                    <div class="form-group col-lg-6">
                        <label>Parool uuesti</label>
                        <input type="password" name="pass2" class="form-control" id="" value="">
                    </div>

                    <div class="form-group col-lg-6">
                        <label>E-maili aadress </label>
                        <input type="" name="email" class="form-control" id="" value="<?php if(isset($data['mail'])){echo $data['mail'];}?>">
                    </div>

                    <div class="form-group col-lg-6">
                        <label>E-maili aadress uuesti</label>
                        <input type="" name="email2" class="form-control" id="" value="<?php if(isset($data['mail'])){echo $data['mail'];}?>">
                    </div>
                    <!--
                    <div class="col-sm-6">
                        <input type="checkbox" class="checkbox" />Sigh up for our newsletter
                    </div>
                    <div class="col-sm-6">
                        <input type="checkbox" class="checkbox"/>Send notifications to this email
                    </div>
                    -->
                    <div>
                        <input class="btn btn-primary" type="submit" value="Kinnita" name="submit">
                    </div>
                </div>
            </div>
        </section>
    </div>
</form>