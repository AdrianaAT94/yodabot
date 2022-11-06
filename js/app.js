new Vue({
    el: '#chat',
    data: {
        writing: false,
        nMsg: "",
        msgList: []   
    },
    methods: {
        Session() {
            var chat = sessionStorage.getItem('historial');
            if (chat) {
                return JSON.parse(chat);
            } else {
                sessionStorage.setItem('historial', JSON.stringify([]));
                return [];
            }
        },
        userMsg() {
            if (this.nMsg) {
                var msgItem = { bot: false, content: this.nMsg };
                this.msgList.push(msgItem);
                this.writing = true;
                this.sendMsg(this.nMsg);
                this.saveHistorial(msgItem);
                this.nMsg = "";
            }
        },
        botMsg(msg) {
            var msgItem = { bot: true, content: msg };
            this.msgList.push(msgItem);
            this.writing = false;
            this.saveHistorial(msgItem);
        },
        sendMsg(msg) {
            var self = this;
            var xhr = new XMLHttpRequest();
            xhr.addEventListener("load", function () {
                self.botMsg(xhr.responseText);
            });
            xhr.open("POST", "api/CargaMensaje.php");
            xhr.setRequestHeader('Content-type', 'application/json')
            xhr.send(JSON.stringify({ "msg": msg }));
        },
        saveHistorial(msg) {
            $chat = this.Session();
            $chat.push(msg);
            sessionStorage.setItem('historial', JSON.stringify($chat));
        },
        deleteHistorial() {
            sessionStorage.removeItem('historial');
            location.reload();
        }
    },    
    created: function () {
        this.msgList = this.Session();
    },
    watch: {
        msgList: function () {
            setTimeout(function () {
                window.scrollTo(0, document.body.scrollHeight);
            }, 100);
        }
    }
});