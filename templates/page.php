<!DOCTYPE html>
<html>
<head>
    <title>Meilleurs Voeux 2016</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
    <link href="css/screen.css" rel="stylesheet" media="screen">
</head>
<body>


<div class="container sign-in-up">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="text-center">
                <h1>Ecard Send</h1>
            </div>
            <hr>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="new">
                    <br>
                    <fieldset>
                        <div class="form-group">
                            <div class="right-inner-addon">
                                <input class="form-control input-lg" placeholder="Votre nom *" type="text" id="myName">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="right-inner-addon">
                                <input class="form-control input-lg" placeholder="Votre adresse email *" type="text" id="myAddress">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="right-inner-addon">
                                <input class="form-control input-lg" placeholder="Liste des destinaires *" type="text"  id="destinataires">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="right-inner-addon">
                                <textarea class="form-control input-lg"  placeholder="Votre message *" id="message"></textarea>
                            </div>
                        </div>
                    </fieldset>
                    <hr>

                    <div class="tab-content">

                        <div class="tab-pane fade in active text-center" id="pp">
                            <button class="btn btn-primary btn-lg btn-block" id="previewbtn">Prévisualiser l'e-card</button>
                        </div>
                    </div>
                </div>
            </div>
            <footer></footer>
         </div>
    </div>
</div>


<div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Prévisualisation de l'ecard</h4>
            </div>
            <div class="modal-body">
                <body bgcolor="#f2f2f2">
                <table class="emailContent" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr  bgcolor="#ffffff">
                        <td  bgcolor="#f2f2f2" rowspan="3" width="10"><img src="./imgs/border-left.png" height="500" width="10"></td>
                        <td valign="top">
                            <img src="./imgs/header.jpg" style="width:100%">
                        </td>
                        <td  bgcolor="#f2f2f2" rowspan="3" width="10"><img src="./imgs/border-right.png"  height="500"></td>
                    </tr>

                    <tr bgcolor="#ffffff">

                        <td  valign="top" style="padding:5%; height:200px">
                            <p id="pre_message">

                            </p>
                        </td>

                    </tr>
                    <tr bgcolor="#ffffff">
                        <td align="center">
                            <img src="./imgs/footer.png" style="max-width:100%">
                        </td>
                    </tr>
                    <tr bgcolor="#f2f2f2">
                        <td align="center">
                            <img src="./imgs/border-bottom.png" style="width:100%">
                        </td>
                    </tr>
                </table>
                </body>
            </div>
            <div class="modal-footer" id="previewFooter">
                <span id="sendMsg"></span>
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="envoyer">Envoyer</button>
            </div>
        </div>
    </div>
</div>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<link href="css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<link href="css/summernote.css" rel="stylesheet" type="text/css" />
<script src="js/bootstrap-dialog.min.js"></script>
<script src="js/summernote.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>