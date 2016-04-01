/**
 * Created by Jean-Baptiste on 09/13/2015.
 */

(function() {
    window.alesMailer = {
        domain:'alesgroupe.com',
        senderName:'',
        sender:'',
        receiverList:'',
        receiverListArray:[],
        message:'',
        init:function(){
            var self;
            self = this;
            $('#myAddress').tooltip({'trigger':'focus', 'title': 'Obligatoirement votre adresse alesgroupe.com'});
            $('#destinataires').tooltip({'trigger':'focus', 'title': 'Liste d\'adresses email valides séparées par des points-virgules'});
            $('#message').tooltip({'trigger':'focus', 'title': 'Message à ajouter au corp de l\'email'});
            $('#previewbtn').on('click',function(){
                self.preview();
            });

            $('#destinataires').on('blur', function(){
                var clean = self.cleanEmailList($(this).val())
                $(this).val(self.cleanEmailList(clean));
            });
            $('#message').summernote( {height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                ]
            });
            $('#envoyer').on('click',function(){
                self.send();
            });

        },
        preview:function(){
            this.senderName = $('#myName').val();
            this.sender = $('#myAddress').val();
            this.receiverList = $('#destinataires').val();
            this.message = $('#message').val();
            var errorMsg = "";
            if( !this.senderName )
                errorMsg = "Veuillez indiquer votre nom";

            if( !this.validEmailList(this.receiverList) )
                errorMsg = "La liste des destinaires contient des erreurs, veuillez entrer une liste d'adresses email valide separées par des points-virgules";

            if( !this.validEmailEnvoyer(this.sender) )
                errorMsg = "Adresse email invalide, vous devez utiliser une adresse en @alesgroupe.com";


            if( this.message.trim().length < 3 )
                errorMsg = "Veuillez indiquer votre message";

            if( errorMsg ){
                this.alert(errorMsg);
            }
            else
            {
                $('#pre_message').html(this.message);
                $('#preview').modal('show');
            }
        },
        mailSend:function(){
            var self = this;

            var msgBox = $('#sendMsg');
            var origin = self.receiverList.split(';')
            var done = origin.length-(self.receiverListArray.length);
            msgBox.html('Envoi en cours ('+done+'/'+origin.length+'), veuillez patienter...');

            $.post( "./", { senderName:this.senderName, sender:this.sender, receiverList:self.receiverListArray[0], message:this.message })
                .done(function( data ) {
                    self.receiverListArray.shift();
                    if(self.receiverListArray.length)
                    {
                        self.mailSend();
                    }
                    else
                    {
                        msgBox.html('Envoi en cours ('+origin.length+'/'+origin.length+'), veuillez patienter...');
                        setTimeout(function(){
                        $('#preview').modal('hide');
                        },1000);
                        setTimeout(function(){
                            self.msg('Votre mail a bien été envoyé');
                            btn.removeClass('loading');
                            msgBox.html('');
                        },1500);
                    }
                });
        },
        send:function()
        {
            var self = this;
            var btn = $('#previewFooter');

            self.receiverListArray = self.receiverList.split(';');
            if(!btn.hasClass('loading') || true)
            {

                btn.addClass('loading');
                self.mailSend();
            }

        },
        alert:function( msg ){
            BootstrapDialog.alert({
                title: 'Attention',
                message:msg,
                type: BootstrapDialog.TYPE_WARNING});
        },
        msg:function( msg ){
            BootstrapDialog.show({
                title: 'Envoi effectué',
                message: msg
            });
        },
        validEmailEnvoyer:function( email ){
            return this.validEmail(email) && email.indexOf('@'+this.domain) > -1;
        },
        validEmailList:function( list ){
            var list = list.split(';')
            var res = false;
            for( var i=0; i<list.length; i++ )
            {
                res=this.validEmail(list[i].trim());
            }
            return res;
        },
        cleanEmailList:function( list ){
            var list = list.split(';');
            var res = [];
            for( var i=0; i<list.length; i++ )
            {
                if( this.validEmail(list[i].trim()) ){
                    res.push(list[i].trim());
                }
                else
                {
                    var clean = list[i].trim().substring(list[i].lastIndexOf("<")+1,list[i].lastIndexOf(">"));
                    if(clean.trim()) res.push(clean);
                }
            }
            return res.join(';');
        },
        validEmail:function( email ) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    }

    window.alesMailer.init();

}).call(this);