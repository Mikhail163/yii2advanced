<div class="chat_area">
  <span class="chat_title chat_message">PHP WebSocket чат</span>
  <div id="chat_messages"></div>
  <div class="chat_control chat_message">
    <input placeholder="Введите сообщение" id="chat_new_message">
    <?= \yii\bootstrap\Html::a(
      'Отправить', 
      '#', 
      ['class' => 'btn btn-primary', 'id' => 'chat_button_send']); 
    ?>
  </div>
</div>