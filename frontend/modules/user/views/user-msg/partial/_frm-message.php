<?php
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use backend\modules\user\models\UserMsgAttachments;
use yii\helpers\Html;


$modelAttachments = new UserMsgAttachments();
$host = Yii::$app->WebSocket->host;
$port = Yii::$app->WebSocket->port;

$user_id = Yii::$app->request->get('user_id');

?>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'validationUrl' => ['/msg-validate', 'message_id' => $message_id, 'item_id' => $item_id, 'user_id' => $user_id],
    'action' => ['/message-send', 'message_id' => $message_id, 'item_id' => $item_id,  'user_id' => $user_id,],
    'options' => ['enctype' => 'multipart/form-data'],
    'id' => 'chat-form']); ?>

    <div class="message_write">
        <?= $form->field($model, 'text')->textarea(['rows' => 3, 'class' => 'form-control input-sm chat_input', 'placeholder' => 'Write your message here...', 'id' => 'msg-text', 'onkeydown' => "if (event.keyCode == 13) $('#chat-form').trigger('beforeSubmit')"])->label(false) ?>
        <div class="clearfix"></div>
        <div class="chat_bottom">
            <?php
            echo $form->field($modelAttachments, 'attachment[]')->widget(FileInput::classname(), [
                'options' => ['multiple' => true, 'accept' => 'image/*'],
                'pluginOptions' => [
                    'uploadUrl' => Url::to(['/attachment-upload', 'message_id' => $message_id, 'item_id' => $item_id, 'user_id' => $user_id]),
                    'showPreview' => false,
                    'showCaption' => false,
                    'showRemove' => false,
                    'showUpload' => true,
                    'showCancel' => false,
                    'uploadAsync' => false,
                    'elCaptionText' => '#customCaption',
                    'uploadClass' => 'btn btn-info hide',
                    'browseLabel' => ' Attachments',
                    'maxFileCount' => 10,
                    'maxFileSize' => 2800
                ],
            ])->label('<span id="customCaption" class="text-success">No file selected</span>');?>


            <?= Html::submitButton('Send', ['class' => 'pull-right btn btn-success']) ?>
        </div>
        <div class="clearfix"></div>
    </div>
<?php ActiveForm::end(); ?>

<?php
$js = <<<JS

 $(document).ready(function(){    
    var message_id = "$message_id";
	//create a new WebSocket object.
	 var websocket = new WebSocket("ws://$host:$port",'echo-protocol');
	 
	websocket.onopen = function(ev) { // connection is open 
		$('#chat-error').html("Connected!"); //notify user
	}
	
	$('#usermsgattachments-attachment').on('filebatchuploadsuccess', function(event, data, previewId, index) {
           var form = data.form, files = data.files, extra = data.extra, response = data.response, reader = data.reader;     
           
           if(response.code == 'success'){
               if(message_id == '' && response.message_id != ''){
                   $(".modal").modal('hide'); 
                   self.location = '/messages?message_id='+response.message_id;
               }
               websocket.send(JSON.stringify({type:'upload', message_id:response.message_id, seq:response.seq, text:response.text}));
           }         
    });

	$('#chat-form').on('beforeSubmit', function(e) { //use clicks message send button 
 
	    e.preventDefault();
        var form = $(this);
        var formData = form.serialize();   
        
        $.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: formData,
                success: function (data) 
                {      
                    if( data.message_id == "$message_id" ){
                        //prepare json data
                        var msg = { message_id: data.message_id, seq: data.seq, text: data.text };       
                        //convert and send data to server 
                        websocket.send(JSON.stringify(msg));                         
                    }                    
                    $('#msg-text').val('');  
                    $('.fileinput-upload').trigger("click" );    
                },
                error: function () {  alert("Something went wrong"); }
            });
        
        }).on('submit', function(e){ e.preventDefault(); });	
	
	//#### Message received from server?
	websocket.onmessage = function(ev) {
	    
		var msg = JSON.parse(ev.data); //PHP sends Json data
		var type = msg.type; //message type
		var message_id = msg.message_id; //message id
		var seq = msg.seq; //message seq
		var text = msg.text; //user message 
		var attachment_id = msg.attachment_id; //user message
				
		if(msg.message_id != "$message_id"){
		    return false;
		}
		
		switch (type){
		    case 'user':
		        if(message_id != undefined ){
		            $.get('/append-recent', {seq:seq, message_id:message_id}, function(data){
                        $("#chat-listview").append(data);
                        $("#chat-listview").animate({scrollTop: $("#chat-listview").get(0).scrollHeight}, 2000);
                        $("#chat-receipents").load(" #chat-receipents");
                    });
		        }
		        break;
            case 'upload':     
                if(message_id != undefined ){
                      $.get('/append-attachment', {seq:seq, message_id:message_id}, function(attachment){
                        $("#attachments-"+message_id+"-"+seq).html(attachment);
                        $("#chat-listview").animate({scrollTop: $("#chat-listview").get(0).scrollHeight}, 2000);
                    });                
                }
                break;
		}		
		$("#chat-listview").slimScroll({start: 'bottom'});
	};
	
	websocket.onerror	= function(ev){ 
	    $('#chat-error').html("<div class='system_error'>Error Occurred - "+ev.data+"</div>");
	};
	
	websocket.onclose 	= function(ev){ 
	    $('#chat-error').html("<div class='system_msg'>Connection Closed</div>"); 
	};	
}); 
JS;

$this->registerJs($js);



