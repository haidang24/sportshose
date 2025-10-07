$(document).ready(function () {
  const chatBtn = $('#gemini-chat-toggle');
  const chatBox = $('#gemini-chatbox');
  const input = $('#gemini-input');
  const sendBtn = $('#gemini-send');
  const messages = $('#gemini-messages');

  if (!chatBtn.length || !chatBox.length) return; // Only on contact page

  let history = [];
  let sending = false;

  function appendMessage(role, text) {
    const isUser = role === 'user';
    const item = $('<div/>').addClass('g-msg ' + (isUser ? 'from-user' : 'from-bot'));
    const bubble = $('<div/>').addClass('g-bubble').text(text);
    item.append(bubble);
    messages.append(item);
    messages.scrollTop(messages.prop('scrollHeight'));
  }

  function setLoading(on) {
    sending = on;
    input.prop('disabled', on);
    sendBtn.prop('disabled', on);
    sendBtn.find('.spinner-border').toggleClass('d-none', !on);
  }

  chatBtn.on('click', function () {
    chatBox.toggleClass('open');
  });

  function sendCurrentMessage() {
    const text = (input.val() || '').trim();
    if (!text || sending) return;
    appendMessage('user', text);
    history.push({ role: 'user', text });
    input.val('');
    setLoading(true);

    $.ajax({
      url: 'Controller/gemini.php?action=chat',
      method: 'POST',
      contentType: 'application/json; charset=UTF-8',
      data: JSON.stringify({ message: text, history }),
      dataType: 'json'
    })
      .done(function (res) {
        const reply = res && res.message ? res.message : 'Xin lỗi, hiện không có phản hồi.';
        appendMessage('model', reply);
        history.push({ role: 'model', text: reply });
      })
      .fail(function (xhr) {
        const err = xhr && xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Lỗi kết nối máy chủ';
        appendMessage('model', '⚠️ ' + err);
      })
      .always(function () {
        setLoading(false);
        input.focus();
      });
  }

  sendBtn.on('click', sendCurrentMessage);
  input.on('keydown', function (e) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      sendCurrentMessage();
    }
  });
});


